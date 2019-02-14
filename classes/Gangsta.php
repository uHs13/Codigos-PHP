<?php 
class Gangsta extends Pessoa{
	
	function __construct($cpf){
		Parent::__construct($cpf);
		echo "Construtor da classe ".get_class($this)." chamando o da classe ".get_parent_class()."<br>";//get_parent_class() retorna o nome da classe mãe;
	}

	function __destruct(){// É chamado automáticamente no fim da execução do script ou quando chamamos ($objeto->__destruct() ou unset($objeto) );
		echo "Cancelando cpf ".get_class($this);
	}

}//Fim classe Gangsta;



?>