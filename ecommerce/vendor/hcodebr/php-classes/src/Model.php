<?php  

namespace Hcode;

class Model
{

	private $values = [];//aramzena todos os valores dos atributos que temos na classe

	public function __call($name, $args)
	{

		$method = substr($name, 0, 3);//pega o nome do método ( get ou set )
		$fieldName = substr($name, 3, strlen($name));// pega o resto do nome para descobrir de qual atributo estamos falando

		var_dump($method, $fieldName);
		exit;

	}

}






?>