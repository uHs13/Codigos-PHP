<?php 

class Usuario{

	private $idUsuario;
	private $login;
	private $pass;
	private $dtRegister;

	public function getIdUsuario(){
		
		return $this->idUsuario;

	}

	public function setIdUsuario($value){
		
		$this->idUsuario = $value;

	}


	public function getLogin(){
		
		return $this->login;

	}

	public function setLogin($value){

		$this->login = $value;

	}


	public function getPass(){

		return $this->pass;

	}

	public function setPass($value){

		$this->pass = $value;

	}

	public function getDtRegister(){
		
		return $this->dtRegister;

	}

	public function setDtRegister($value){
		
		$this->dtRegister = $value;

	}

	public function __toString(){

		return json_encode(array(

			"idUsuario"=>$this->getIdUsuario(),
			"login"=>$this->getLogin(),//Colocar vírgulas separando os itens do array;
			"dtRegister"=>$this->getDtRegister()->format("d/m/Y H:i:s")
		
		));

	}//Fim toString

	public function loadById($id){

		$sql = new Sql();

		$result = $sql->select('select idUsuario,login,dtRegister from usuario where idUsuario=:ID',
			array(':ID'=> $id ));

		if ( count($result) > 0 ){ //Caso tenha algum registro dentro do array;

			// A função select da nossa classe Sql retorna um array de arrays. Como a consulta procurou por apenas 1 usuário o array de retorno terá apenas uma posição, a primeira , a 0;

			$user = $result[0];//Após receber os dados do usuário temos que guardá-los nos atributos da classe que estamos ( Usuário );

			$this->setIdUsuario($user['idUsuario']);
			$this->setLogin($user['login']);
			$this->setDtRegister(new DateTime($user['dtRegister']));//Usando o DateTime podemos formatar a saída da data de registro;

		}

	}//Fim loadById

	public static function getUsers(){//Retorna todos os usuários cadastrados no banco;

		$sql = new Sql();

		return $sql->select("select idUsuario,login,dtRegister from usuario order by idUsuario"); 
		/*
			Se colocarmos o return só no $sql vai dar errado, pois $sql é só a istância da nossa classe,
			o array retornado pelo select não fica guardado nela. Precisamos dar um return no array do método select;  
		*/

	}//Fim getUsers

	public static function search($login){//Busca os dados do usuário de acordo com o login

		$sql = new Sql();

		return $sql->select("select idUsuario,login,dtRegister from usuario where login=:LOG",

			array(
				':LOG'=>$login
			));

	}

	public function login($login,$password){//retorna os dados de um usuário caso o login e a senha estejam de acordo com os dados cadastrados no banco;

		$sql = new Sql();

		$result =  $sql->select("select idUsuario,login,pass,dtRegister from usuario where login=:LOG and pass=:PASS",array(

				':LOG'=>$login,
				':PASS'=>$password
		));

		if (count($result) > 0){

			$user = $result[0];

			$this->setIdUsuario($user['idUsuario']);
			$this->setLogin($user['login']);
			$this->setPass($user['pass']);
			$this->setDtRegister(new DateTime($user['dtRegister']));

		}else{

			throw new Exception("Login or password error");
			
			
		}
	}

}


?>