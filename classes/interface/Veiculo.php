<?php 

interface Veiculo{

	
	public function desligar();//Em interfaces somente a assinatura do método;
	public function ligar();
	public function acelerar($nmr);
	public function frear();
	//public function marcha():bool;

}



?>