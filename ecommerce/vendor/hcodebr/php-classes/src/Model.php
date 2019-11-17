<?php  

namespace Hcode;

class Model
{

	private $values = [];//aramzena todos os valores e nomes dos atributos que temos na classe

	//O método mágico call captura o nome e os parâmetros do método chamado pelo objeto, caso esse método não exista. Está sendo usado nesse caso para implementar dinamicamente os getters and setters da classe
	public function __call($name, $args)
	{

		//quebra o nome do método invocado pelo objeto
		$method = substr($name, 0, 3);//pega o nome do método ( get ou set )
		$fieldName = substr($name, 3, strlen($name));// pega o resto do nome para descobrir de qual atributo estamos falando

		switch($method)
		{

			case 'get':

				return (isset($this->values[$fieldName]))? $this->values[$fieldName] : 0;//caso exista um atributo com o nome capturado pelo __call dentro do array $values ele é retornado 
			
			break;

			case 'set':

				$this->values[$fieldName] = $args[0];//é criado um índice no array $values com o nome capturado pelo __call e o valor passado como parâmetro é atribuido a essa posição do array
			break;

		}

		

	}// /__call

	public function setData($data = array())//método para criar dinamicamente atributos com seus respectivos valores para o objeto 
	{

		foreach ($data as $key => $value) {
			
			$this->{"set".$key}($value);
			//$this->{} - as chaves são um recurso do PHP que permite a criação dinâmica de um atributo. Como esse método ainda não existe e está sendo invocado o método mágico __call será chamado e dentro do switch será criado o índice no array $values e o valor armazenado. Dessa forma para cada posição do array $data será criado em tempo de execução um atributo para a classe.

		}

	}// /setData()

	public function getValues() //método que retorna todos os atributos do objeto
	{

		return $this->values;

	}


}






?>