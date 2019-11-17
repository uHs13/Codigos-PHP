<?php

class Obj
{
	
	//O método mágico call captura o nome e os parâmetros do método chamado pelo objeto caso esse método não exista
	
	/* __call utilizado nos exemplos com a variável $obj
	public function __call($name, $arguments)
	{
		
		echo "calling '".$name."' method in Obj Class passing these parameters:"."</br>";
		print_r($arguments);
		echo "</br>";
			
	}
	*/
	
	private $values = [];
	//array que vai armazenar todos os atributos da classe
	
	public function __call($name, $args)
	{
			
		//cria uma string com o tipo do método chamado ( get ou set )
		$method = substr($name, 0, 3);
		
		//cria uma string com o nome do atributo que será criado (set) ou terá o seu valor retornado (get)
		$attribute = substr($name, 3, strlen($name));
	
		switch($method)
		{
				
			case 'get':
				return $this->values[$attribute];//caso exista um atributo com o nome armazenado em $attribute o valor desse índice no $values é retornado
			break;
			
			
			case 'set':
				$this->values[$attribute] = $args[0];// é criado um novo índice no $values com o valor passado como parâmetro
			break;
				
		}
		
	}
	
	/* método utilizado no exemplo com a variável $obj
	public function exists(){
		
		echo "Implemented method"."</br>";
		
	}
	*/
	
	public function setAttributes($data = array())
	{
		
			foreach($data as $key => $value){
				
				$this->{"set".$key}($value);
				//$this->{} - as chaves são um recurso do PHP que permite a criação dinâmica de um atributo. Como esse método ainda não existe e está sendo invocado, o método mágico __call será é chamado e dentro do switch será criado o índice no array $values e o valor armazenado. Dessa forma para cada posição do array $data será criado em tempo de execução um atributo para a classe.
			}

	}
	
}

/*
$obj = new Obj();
$obj->magic("arg1","arg2");
$obj->exists();
$obj->anotherOne();
*/

$array = array("name"=>'another person', "age"=> '26', "country_code"=>"BR");

$object = new Obj();

$object->setAttributes($array);

var_dump($object); 

?>