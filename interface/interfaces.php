<?php 

interface Veiculo{

	
	public function desligar();//Em interfaces somente a assinatura do método;
	public function ligar();
	public function acelerar($nmr);
	public function frear();
	//public function marcha():bool;

}

class Carro implements Veiculo{

	private $ligado=false;
	private $nome;
	private $velocidade=0;

	function __construct($name){
		$this->setNome($name);
	}

	function __destruct(){
		echo $this->getNome()." destruido";
	}
 
	function __toString():string{
		if($this){
			return "Nome: ".$this->getNome()."<br>"."Ligado: ".$this->getLigado()."<br>"."Velocidade: ".$this->getVelocidade();
		}
	}

	private function getLigado(){
		if(isset($this->ligado)) return $this->ligado;
	}

	public function setLigado($bool){
		$this->ligado = $bool;
	}

	private function getNome(){
		if(isset($this->nome)) return $this->nome;
	}	

	public function setNome($name){
		$this->nome = $name;
	}

	private function getVelocidade(){
		if(isset($this->velocidade))return $this->velocidade;
	}

	public function setVelocidade($nmr){
		$this->velocidade = $nmr;
	}

	//Métodos da Interface

	public function ligar(){
		if($this->getLigado() == false){
			$this->setLigado(true);
			$this->setVelocidade(0);
		}else{
			echo "veiculo já está ligado";
		}
	}

	public function desligar(){
		if($this->getLigado() == true){
			$this->setLigado(false);
			$this->setVelocidade(0);
		}else{
			echo "<br>veiculo já está desligado";
		}
	}

	
	
	public function acelerar($nmr){
		if($nmr <= 0){
			throw new Exception("VELOCIDADE INVÁLIDA", 1);
		}else{
			if($this->getLigado() == true){
				$this->setVelocidade($this->getVelocidade()+$nmr);
			}else{
				throw new Exception("LIGUE O CARRO ANTES DE ACELERAR", 1);
				
			}
		}

	}
	public function frear(){
		if($this->getVelocidade() >= 0){
			$this->setVelocidade(0);
		}else{
			throw new Exception("CARRO PARADO", 1);
			
		}
	}
	

}

$uno = new Carro("golzin g4");
$uno->ligar()."<br>";
$uno->acelerar(130)."<br>";
$uno->frear();
echo $uno."<br>";



?>