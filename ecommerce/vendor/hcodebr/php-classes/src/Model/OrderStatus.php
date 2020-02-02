<?php
namespace Hcode\Model;

use Hcode\Model;
use Hcode\DB\Sql;

class OrderStatus extends Model
{

	/*
		class constants must be declared in all upper case with underscore separators
		https://www.php-fig.org/psr/psr-1/
	*/
	const EM_ABERTO = 1;
	const AGUARDANDO_PAGAMENTO = 2;
	const PAGO = 3;
	const ENTREGUE = 4;

	public function getStatus()
	{

		$sql = new Sql();

		$results = $sql->select("SELECT idstatus, desstatus FROM tb_ordersstatus");

		if (count($results) === 0) return false;

		return $results;

	}
	// .getStatus

}
// .Order