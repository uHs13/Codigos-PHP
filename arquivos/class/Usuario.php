<?php 

class Usuario{

	private $nome;
	private $email;
	private $dateRegister;

	//GETTERS AND SETTERS

	public function getNome(){

		return $this->nome;

	}

	public function setNome($name){

		$this->nome = $name ;

	}

	public function getEmail(){

		return $this->email;

	}

	public function setEmail($Email){

		$this->email = $Email;

	}

	public function getDateRegister(){

		return $this->dateRegister;

	}

	public function setDateRegister(){

		$this->dateRegister = date("d/m/Y H:i:s");

	}

	//FIM GETTERS AND SETTERS

	public function __construct($name,$email){

		$this->setNome($name);

		$this->setEmail($email);

		$this->setDateRegister();

	}

	public function __toString(){

		return json_encode(array(

			'Nome' => $this->getNome(),
			'Email' => $this->getEmail(),
			'Registro' => $this->getDateRegister()
		));

	}


}

?>