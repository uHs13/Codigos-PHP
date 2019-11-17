<?php 

class User{

	private $name;
	private $email;



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

	
	//FIM GETTERS AND SETTERS


	function __construct($name,$email){

		$this->setName(trim($name,"\r\n"));
		$this->setEmail(trim($email,"\r\n"));



	}

	function __toString(){

		return $this->getName().';'.$this->getEmail();

	}

	

}


?>