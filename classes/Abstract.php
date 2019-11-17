<?php 

interface Animal{

	public function emitirSom();//Em interfaces somente a assinatura do método;
}

abstract class Mamifero implements Animal{
	public $corAnimal;
	function __construct(){
		echo 'Construindo '.get_class().'<br>';
	}

	public function emitirSom(){}
}

class Gato extends Mamifero{
	public function __construct(){
		Parent::__construct();
		$this->corAnimal = "Branco e Laranja";
		echo "Construindo ".get_class()."<br>";
	}

	public function emitirSom(){
		echo(get_class()." ".$this->corAnimal." emitindo sons:  Miau");
	}
}

$bichano = new Gato();
$bichano->emitirSom();

?>