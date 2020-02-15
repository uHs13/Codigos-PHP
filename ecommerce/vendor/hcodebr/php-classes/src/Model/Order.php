<?php
namespace Hcode\Model;

use Hcode\Utils\Utils;
use Hcode\Model\Cart;
use Hcode\Model\OrderStatus;
use Hcode\DB\Sql;
use Hcode\Model;

class Order extends Model
{

	public function save()
	{

		$sql = new Sql();

		$results = $sql->select("

			CALL sp_orders_save(

			:pidorder,
			:pidcart,
			:piduser,
			:pidstatus,
			:pidaddress,
			:pvltotal

			)

			", [

				":pidorder" => $this->getidorder(),
				":pidcart" => $this->getidcart(),
				":piduser" => $this->getiduser(),
				":pidstatus" => $this->getidstatus(),
				":pidaddress" => $this->getidaddress(),
				":pvltotal" => $this->getvltotal()

			]);

		if (count($results) === 0) return false;

		$this->setData($results[0]);

		return true;

	}
	// .save

	public function get($id)
	{

		$sql = new Sql();

		$results = $sql->select("

			SELECT
			o.idorder,
			o.idcart,
			o.iduser,
			o.idstatus,
			o.idaddress,
			o.vltotal,
			os.desstatus,
			c.dessessionid,
			c.deszipcode,
			c.vlfreight,
			c.nrdays,
			a.desaddress,
			a.descomplement,
			a.descity,
			a.desstate,
			a.descountry,
			a.deszipcode,
			a.desdistrict,
			p.desperson,
			p.desemail,
			p.nrphone
			FROM tb_orders o
			INNER JOIN tb_ordersstatus os
			ON o.idstatus = os.idstatus
			INNER JOIN tb_carts c
			ON o.idcart = c.idcart
			INNER JOIN tb_users u
			ON o.iduser = u.iduser
			INNER JOIN tb_addresses a
			ON o.idaddress = a.idaddress
			INNER JOIN tb_persons p
			ON u.idperson = p.idperson
			WHERE o.idorder = :idorder

			", [

				":idorder" => $id

			]);

		if (count($results) === 0) return false;

		$this->setData($results[0]);

		return true;

	}
	// .get

	public function getAll()
	{

		$sql = new Sql();

		$results = $sql->select("

			SELECT
			tbo.idorder AS idorder,
			tbp.desperson AS desperson,
			tbo.vltotal AS vltotal,
			tbc.vlfreight AS vlfreight,
			tbc.vlfreight AS vlperson,
			tbo.idstatus AS idstatus
			FROM tb_orders tbo
			INNER JOIN tb_users tbu
			ON tbo.iduser = tbu.iduser
			INNER JOIN tb_persons tbp
			ON tbu.idperson = tbp.idperson
			INNER JOIN tb_carts tbc
			ON tbo.idcart = tbc.idcart
			ORDER BY tbo.dtregister DESC

			");

		if (count($results) === 0) return false;

		return $results;

	}
	// .getAll

	public function delete($idOrder)
	{

		$sql = new Sql();

		$sql->query("

			DELETE FROM tb_orders
			WHERE idorder = :idOrder

			", [

				":idOrder" => $idOrder

			]);

		return true;

	}
	// .delete

	public function getClientDetails($idOrder)
	{

		$sql = new Sql();

		$results = $sql->select("

			SELECT
			o.idorder,
			o.idstatus,
			o.idaddress,
			DATE_FORMAT(o.dtregister, '%d/%m/%y') AS dtregister,
			a.desaddress,
			a.descomplement,
			a.descity,
			a.desstate,
			a.descountry,
			a.deszipcode,
			a.desdistrict,
			p.desperson,
			p.desemail,
			p.nrphone
			FROM tb_orders o
			INNER JOIN tb_ordersstatus os
			ON o.idstatus = os.idstatus
			INNER JOIN tb_users u
			ON o.iduser = u.iduser
			INNER JOIN tb_addresses a
			ON o.idaddress = a.idaddress
			INNER JOIN tb_persons p
			ON u.idperson = p.idperson
			WHERE o.idorder = :idorder

			", [

				":idorder" => $idOrder

			]);

		if (count($results) === 0) return false;

		return $results[0];

	}
	// .getClientDetails

	public function getProductDetails($idOrder)
	{

		$idCart = $this->getCart($idOrder)["idcart"];

		$cart = new Cart();

		$cart->setidcart($idCart);

		return $cart->getProducts();

	}
	// .getProductDetails

	public function getCart($idOrder)
	{

		$sql = new Sql();

		$results = $sql->select("

			SELECT
			tbo.idcart AS idcart,
			tbc.deszipcode AS deszipcode
			FROM tb_orders tbo
			INNER JOIN tb_carts tbc
			ON tbc.idcart = tbo.idcart
			WHERE idorder = :idOrder

			", [

				":idOrder" => $idOrder

			]);

		if (count($results) === 0) return false;

		return $results[0];

	}
	// .getCart

	public function getCartDetails($idOrder)
	{

		$cart = new Cart();

		$cart->setData($this->getCart($idOrder));

		$cart->calculateTotal();

		return $cart->getValues();

	}
	// .getCartDetails

	public function getStatus()
	{

		$orderStatus = new OrderStatus();

		return $orderStatus->getStatus();

	}
	// .getStatus

	public function updateStatus(int $idStatus)
	{

		if ($this->validateStatus($idStatus)) {

			$sql = new Sql();

			$sql->query("

				UPDATE tb_orders
				SET idstatus = :idStatus
				WHERE idorder = :idOrder

				", [

					":idStatus" => $idStatus,
					":idOrder" => $this->getidorder()

				]);

			Utils::setSessionMsgSuccess("Status alterado com sucesso");

		} else {

			Utils::setSessionMsgError("Não foi possível alterar o status");

		}

	}
	// .updateStatus

	public function validateStatus($idStatus)
	{

		if (
			array_search($idStatus, array_column($this->getStatus(), "idstatus")) !== false
		) {

			return true;

		} 

		return false;

	}
	// .validateStatus

	public function getOrderPage($page = 1, $itensPage = 5)
	{

		$start = ($page - 1) * $itensPage;

		$sql = new Sql();

		$results = $sql->select("

			SELECT SQL_CALC_FOUND_ROWS
			tbo.idorder AS idorder,
			tbp.desperson AS desperson,
			tbo.vltotal AS vltotal,
			tbc.vlfreight AS vlfreight,
			tbc.vlfreight AS vlperson,
			tbo.idstatus AS idstatus
			FROM tb_orders tbo
			INNER JOIN tb_users tbu
			ON tbo.iduser = tbu.iduser
			INNER JOIN tb_persons tbp
			ON tbu.idperson = tbp.idperson
			INNER JOIN tb_carts tbc
			ON tbo.idcart = tbc.idcart
			ORDER BY tbo.dtregister DESC
			LIMIT $start, $itensPage

			");

		$resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal");

		return [

			'data' => $results,
			'total' => (int)$resultTotal[0]["nrtotal"],
			'pages' => ceil($resultTotal[0]["nrtotal"] / $itensPage)

		];

	}
	// .getOrderPage

	public function getOrderPageSearch($search, $page = 1, $itensPage = 5)
	{

		$start = ($page - 1) * $itensPage;

		$sql = new Sql();

		$results = $sql->select("

			SELECT SQL_CALC_FOUND_ROWS
			tbo.idorder AS idorder,
			tbp.desperson AS desperson,
			tbo.vltotal AS vltotal,
			tbc.vlfreight AS vlfreight,
			tbc.vlfreight AS vlperson,
			tbo.idstatus AS idstatus
			FROM tb_orders tbo
			INNER JOIN tb_users tbu
			ON tbo.iduser = tbu.iduser
			INNER JOIN tb_persons tbp
			ON tbu.idperson = tbp.idperson
			INNER JOIN tb_carts tbc
			ON tbo.idcart = tbc.idcart
			WHERE
			tbo.idorder LIKE :STR OR
			tbp.desperson LIKE :STR2
			ORDER BY tbo.dtregister DESC
			LIMIT $start, $itensPage

			", [

				":STR" => $search,
				":STR2" => "%$search%"

			]);

		$resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal");

		return [

			'data' => $results,
			'total' => (int)$resultTotal[0]["nrtotal"],
			'pages' => ceil($resultTotal[0]["nrtotal"] / $itensPage)

		];

	}
		// .getOrderPage


}
// .Order