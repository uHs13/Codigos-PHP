<?php  
namespace Hcode\Model;

use Hcode\DB\Sql;
use Hcode\Model;
use Hcode\Model\User;
use Hcode\Model\Products;

class Cart extends Model
{

	const SESSION = "cart";

	public static function getFromSession()
	{

		$cart = new Cart();

		if (

			isset($_SESSION[Cart::SESSION])
			&&
			//se for vazio, no cast pra inteiro vira 0
			(int)$_SESSION[Cart::SESSION]["idcart"] > 0

		) {
			/* se as condições forem satisfeitas temos então um carrinho já inicializado na sessão e que já está inserido no banco de dados */

			/* carregando o carrinho */
			$cart->get((int)$_SESSION[Cart::SESSION]["idcart"]);


		} else {

			/* carrinho não existente */

			$cart->getFromSessionId();

			/* se não conseguir carregar um carrinho temos que criar */
			if (!(int)$cart->getidcart() > 0) {

				$data = array(

					"dessessionid" => session_id(),

				);

				if (User::checkLogin(false)) {

					$user = User::getFromSession();

					$data["iduser"] = $user->getiduser();

				}

				$cart->setData($data);

				$cart->save();

				$cart->setToSession();

			}


		}

		return $cart;

	}
	//.getFromSession

	public function setToSession()
	{

		$_SESSION[Cart::SESSION] = $this->getValues();

	}

	public function getFromSessionId()
	{

		$sql = new Sql();

		$results = $sql->select("
			
			SELECT
			idcart,
			dessessionid,
			iduser,
			vlfreight,
			nrdays
			FROM tb_carts
			WHERE dessessionid = :sessionid;
			", [

				":sessionid" => session_id()

			]);

		if (count($results) > 0) {

			$this->setData($results[0]);

		}

	}
	//.getFromSessionId

	public function get(int $idcart)
	{

		$sql = new Sql();

		$results = $sql->select("
			
			SELECT
			idcart,
			dessessionid,
			iduser,
			vlfreight,
			nrdays
			FROM tb_carts
			WHERE idcart = :idcart;
			", [

				":idcart" => $idcart

			]);

		if (count($results) > 0) {

			$this->setData($results[0]);

		}

	}
	//.get

	public function save()
	{

		$sql = new Sql();

		$results = $sql->select("
			
			call sp_carts_save(
			:idcart,
			:dessessionid,
			:iduser,
			:deszipcode,
			:vlfreight,
			:nrdays
			)

			", [
				":idcart" => $this->getidcart(),
				":dessessionid" => $this->getdessessionid(),
				":iduser" => $this->getiduser(),
				":deszipcode" => $this->getdeszipcode(),
				":vlfreight" => $this->getvlfreight(),
				":nrdays" => $this->getnrdays()
			]);

		$this->setdata($results[0]);

	}
	//.save

	public function addProduct(Products $product)
	{

		$sql = new Sql();

		$res = $sql->select("

			INSERT INTO tb_cartsproducts (idcart, idproduct)
			VALUES (:idcart, :idproduct);

			", [

				":idcart" => $this->getidcart(),
				":idproduct" => $product->getidproduct()

			]);

	}
	//.addProduct

	public function removeProduct(Products $product, $all = false)
	{

		$sql = new Sql();

		if ($all) {

			$res = $sql->select("

				UPDATE tb_cartsproducts
				SET dtremoved = NOW()
				WHERE idcart = :idcart AND
				idproduct = :idproduct AND
				dtremoved IS NULL

				", [

					":idcart" => $this->getidcart(),
					":idproduct" => $product->getidproduct()


				]);



		} else {

			$res = $sql->select("

				UPDATE tb_cartsproducts
				SET dtremoved = NOW()
				WHERE idcart = :idcart AND
				idproduct = :idproduct AND
				dtremoved IS NULL
				LIMIT 1

				", [

					":idcart" => $this->getidcart(),
					":idproduct" => $product->getidproduct()


				]);

		}

	}
	//.removeProduct

	public function getProducts()
	{

		$sql = new Sql();

		$products = $sql->select("

			SELECT
				p.idproduct,
				p.vlprice,
				p.desproduct,
				p.vlprice,
				p.vlwidth,
				p.vlheight,
				p.vllength,
				p.vlweight,
				p.desurl,
				COUNT(*) as 'nrqtd',
				SUM(p.vlprice) as 'vltotal'
			FROM tb_cartsproducts cp
			INNER JOIN tb_products p
			ON cp.idproduct = p.idproduct
			WHERE cp.idcart = :idcart AND
			cp.dtremoved IS NULL
			GROUP BY 
				p.idproduct,
				p.vlprice,
				p.desproduct,
				p.vlprice,
				p.vlwidth,
				p.vlheight,
				p.vllength,
				p.vlweight
			ORDER BY p.desproduct;

			", [

				":idcart" => $this->getidcart()

			]);

		return Products::checkList($products);

	}
	//.getProducts

}//Cart
