<?php  
namespace Hcode\Model;

use Hcode\DB\Sql;
use Hcode\Model;
use Hcode\Model\User;
use Hcode\Model\Products;
use Hcode\Utils\Utils;

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

			if (User::checkLogin(false)) {

				$user = User::getFromSession();

				$cart->setiduser($user->getiduser());

			}

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

					var_dump($user);
					exit;

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
			nrdays,
			deszipcode
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

		$this->calculatTotal();

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

		$this->calculateTotal();

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

	public function getProductsCount()
	{

		$cart = $this->getFromSession()->getidcart();

		$sql = new Sql();

		$results = $sql->select("

			SELECT COUNT(cp.idcartproduct) as nmr
			FROM tb_cartsproducts cp
			INNER JOIN tb_carts c
			ON cp.idcart = c.idcart
			WHERE ISNULL(cp.dtremoved) AND
			cp.idcart = :idcart;

			", [

				":idcart" => $cart

			]);

		if ((int)$results[0]["nmr"] === 0) {

			$sql->query("

				UPDATE tb_carts
				SET deszipcode = :deszipcode,
				vlfreight = :vlfreight,
				nrdays = :nrdays
				WHERE idcart = :idcart;

				", [

					":deszipcode" => (string)0,
					":vlfreight" => (float)0,
					"nrdays" => 0,
					":idcart" => $cart

				]);

		}

		return $results[0]["nmr"];

	}
	//.getProductsCount

	public function getProductTotal()
	{

		$sql = new Sql();

		$results = $sql->select("

			SELECT
			SUM(vlprice) as vlprice,
			SUM(vlwidth) as vlwidth,
			SUM(vlheight) as vlheight,
			SUM(vllength) as vllength,
			SUM(vlweight) as vlweight,
			COUNT(vlprice) as nrqtd
			FROM tb_products p
			INNER JOIN tb_cartsproducts cp
			ON p.idproduct = cp.idproduct AND
			cp.dtremoved IS NULL AND
			cp.idcart = :idcart;

			", [

				":idcart" => $this->getidcart()

			]);

		return (count($results) > 0) ? $results[0] : [];

	}
	//.getProductTotal

	//postcode == CEP
	public function setFreight($postcode)
	{

		$postcode = str_replace("-", "", $postcode);

		$values = $this->getProductTotal();

		// verificando se existem produtos no carrinho. Se não tiver nrqtd é 0.
		if ($values["nrqtd"] > 0) {

			if ((float)$values["vlheight"] < (float)2) {

				$values["vlheight"] = (float)2;

			}

			if ((float)$values["vlwidth"] < 11) {

				$values["vlwidth"] = (float)11;

			}

			if ((float)$values["vllength"] < 16) {

				$values["vllength"] = (float)16;

			}

			//configurando os valores que serão passados pro web service do correios
			$queryString = http_build_query([

				"nCdEmpresa" => "",
				"sDsSenha" => "",
				"nCdServico" => "40010",
				"sCepOrigem" => "32340030",
				"sCepDestino" => $postcode,
				"nVlPeso" => $values["vlweight"],
				"nCdFormato" => 1,
				"nVlComprimento" => (float)$values["vllength"],
				"nVlAltura" => (float)$values["vlheight"],
				"nVlLargura" => (float)$values["vlwidth"],
				"nVlDiametro" => "0",
				"sCdMaoPropria" => "N",
				"nVlValorDeclarado" => $values["vlprice"],
				"sCdAvisoRecebimento" => "N"

			]);

			//enviando os dados para o web service e obtendo a resposta
			$xml = simplexml_load_file("http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx/CalcPrecoPrazo?$queryString");
			//interpolação de variáveis

			$result = $xml->Servicos->cServico;

			//caso o web Service retorne algum erro
			if (strlen($result->MsgErro) > 0) {

				Utils::setSessionMsgError($result->MsgErro);

				return false;

			} else {

				Utils::clearSessionMsgError();

			}

			$this->setnrdays($result->PrazoEntrega);

			$this->setvlfreight(Utils::formatValueToDBDecimal($result->Valor));

			$this->setdeszipcode($postcode);

			$this->save();

			return $result;

		} else {



		}

	}
	//.setFreight

	public function updateFreight()
	{

		if ($this->getdeszipcode() != 0) {

			$this->setFreight($this->getdeszipcode());

		}

	}
	//.updateFreight

	public function getValues()
	{

		$this->calculateTotal();

		return parent::getValues();

	}
	//.getValues

	public function calculateTotal()
	{

		$this->updateFreight();

		$total = $this->getProductTotal();

		$this->setsubTotal($total["vlprice"]);
		$this->setTotal($total["vlprice"] + $this->getvlfreight());

	}
	//.calculateTotal

}
//.Cart