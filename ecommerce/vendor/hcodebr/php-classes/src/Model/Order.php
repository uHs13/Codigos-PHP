<?php
namespace Hcode\Model;

use Hcode\Model;
use Hcode\DB\Sql;

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

}
// .Order