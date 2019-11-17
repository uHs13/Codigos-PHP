<?php 

class UsuarioFile{

	private $name;
	private $email;
	private $dateRegister;
	private $password;

	//GETTERS AND SETTERS

	public function getName(){

		return $this->name;

	}

	public function setName($name){

		$this->name = $name ;

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

	public function getPassword(){

		return $this->password;

	}

	public function setPassword($pass){

		$this->password = $pass;

	}


	//FIM GETTERS AND SETTERS

	public function __construct($name,$email,$pass){

		$this->setName($name);

		$this->setEmail($email);

		$this->setPassword($pass);

		$this->setDateRegister();

	}

	public function __toString(){

		return json_encode(array(

			'Name' => $this->getName(),
			'Email' => $this->getEmail(),
			'Password' => $this->getPassword(),
			'Register' => $this->getDateRegister()
		));

	}


}

?>