<?php 

class User{

	private $name;
	private $email;
	private $cpf;


	//GETTERS AND SETTERS
	public function setName($name){
		$this->name = $name;
	}

	public function getName(){
		return $this->name;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function getEmail(){
		return $this->email;
	}

	public function setCpf($cpf){
		$this->cpf = $cpf;
	}

	public function getCpf(){
		return $this->cpf;
	}
	//FIM GETTERS AND SETTERS


	function __construct($name,$email,$cpf){

		$this->setName($name);
		$this->setEmail($email);
		$this->setCpf($cpf);


	}

	function __toString(){

		return $this->getName().';'.$this->getEmail().';'.$this->getCpf();

	}

	

}


?>