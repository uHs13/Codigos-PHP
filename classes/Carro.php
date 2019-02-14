<?php 

interface Veiculo{

	
	public function desligar();//Em interfaces somente a assinatura do método;
	public function ligar();
	public function acelerar($nmr);
	public function frear();
	//public function marcha():bool;

}
class Carro{

	private $montadora;
	private $modelo;
	private $ano;
	private $velMax;
	private $preco;

	//declare(strict_types = 1);

	public function __construct(string $mont = NULL,string $mod = NULL,int $year = NULL,int $topsp = NULL,float $price = NULL){
		
		$this->montadora = $mont;
		$this->modelo = $mod;
		$this->ano = $year;
		$this->velMax = $topsp;
		$this->preco = $price;

	}

	function __destruct(){
		echo $this->modelo." desmontado"."<br>";
	}

	public function getMontadora():string{
		if(isset($this->montadora))return $this->montadora;
	} 

	public function getmodelo():string{
		if(isset($this->modelo))return $this->modelo;
	}

	public function getano():int{
		if(isset($this->ano))return $this->ano;
	} 

	public function getvelMax():int{
		if(isset($this->velMax))return $this->velMax;
	}

	public function getpreco():float{
		if(isset($this->preco))return $this->preco;
	}


	public function toArray(){
		if(isset($this)){
			return array(
				"montadora" => $this->getMontadora(),
				"modelo" => $this->getmodelo(),
				"ano" => $this->getano(),
				"velocidade maxima" => $this->getvelMax(),
				"preco" => $this->getpreco()
			);
		}
	}

}

$uno = new Carro("Ford","Mustang",2008,230,78.887);
print_r($uno->toArray());echo"<br>";
$ghost = new Carro("Gangsta","Makaveli",1968,180,98.909);
print_r($ghost->toArray());echo "<br>";
unset($uno,$ghost);
?>