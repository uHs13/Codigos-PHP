<?php
namespace Hcode\Model;

use Hcode\Model;
use Hcode\Utils\Utils;
use Hcode\DB\Sql;

class Address extends Model
{

	public function getCEPData(string $cep)
	{

		$cep = Utils::safeEntry($cep);

		$cep = str_replace("-", "", $cep);

		return self::queryAddress($cep);

	}
	// .getCEP

	public function queryAddress($cep)
	{

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "http://viacep.com.br/ws/$cep/json/");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		//passa true como segundo argumento para ser retornado um array. O padrão é um objeto.
		$data = json_decode(curl_exec($ch), true);

		curl_close($ch);

		return $data;

	}
	// .queryCEP

	public function setAddress($cep)
	{

		$cep = Utils::safeEntry($cep);

		$data = $this->getCEPData($cep);

		if (isset($data["logradouro"]) && strlen($data["logradouro"]) > 0) {

			$this->setdesaddress($data["logradouro"]);
			$this->setdescomplement($data["complemento"]);
			$this->setdescity($data["localidade"]);
			$this->setdesstate($data["uf"]);
			$this->setdesdistrict($data["bairro"]);
			$this->setdescountry("Brasil");
			$this->setdeszipcode($cep);

		}

	}
	// .setAddress

	public function save()
	{

		$sql = new Sql();

		$results = $sql->select("

			CALL sp_addresses_save (

			:PIDADDRESS,
			:PIDPERSON,
			:PDESADDRESS,
			:PDESCOMPLEMENT,
			:PDESCITY,
			:PDESSTATE,
			:PDESCOUNTRY,
			:PDESZIPCODE,
			:PDESDISTRICT

			)

			", [

				":PIDADDRESS" => $this->getidaddress(),
				":PIDPERSON" => $this->getidperson(),
				":PDESADDRESS" => $this->getdesaddress(),
				":PDESCOMPLEMENT" => $this->getdescomplement(),
				":PDESCITY" => $this->getdescity(),
				":PDESSTATE" => $this->getdesstate(),
				":PDESCOUNTRY" => $this->getdescountry(),
				":PDESZIPCODE" => $this->getzipcode(),
				":PDESDISTRICT" => $this->getdesdistrict()

			]);

		if (count($results) > 0) return false;

	}
	// .save

	public function get($id)
	{

		$sql = new Sql();

		$results = $sql->select("

			SELECT
			idaddress,
			idperson,
			desaddress,
			descomplement,
			descity,
			desstate,
			descountry,
			deszipcode,
			desdistrict
			FROM tb_addresses
			WHERE idperson = :idperson;

			", [

				":idperson" => $id

			]);

		$this->setData($results[0]);

	}
	// .get

}
//.Address