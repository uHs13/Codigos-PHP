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

				":pidorder" => $this->get,
				":pidcart" => $this->get,
				":piduser" => $this->get,
				":pidstatus" => $this->get,
				":pidaddress" => $this->get,
				":pvltotal" => $this->get

			]);

	}
	// .save

	public function get($id)
	{

	}
	// .get

}
// .Order