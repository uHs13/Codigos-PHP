<?php 

class Usuario{

	private $idUsuario;
	private $login;
	private $pass;
	private $dtRegister;

	///GETTERS AND SETTERS

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
	///FIM GETTERS AND SETTERS


	public function __construct($login="",$pass=""){

		$this->setLogin($login);
		$this->setPass($pass);

	}//Fim construct

	public function __toString(){

		return json_encode(array(

			"idUsuario"=>$this->getIdUsuario(),
			"login"=>$this->getLogin(), //Colocar vírgulas separando os itens do array;
			"pass"=> $this->getPass(),
			"dtRegister"=>$this->getDtRegister()->format("d/m/Y H:i:s")

		));

	}//Fim toString

	public function setUserData($user){//Recebe um array com os dados do usuário e os define como valores para os atributos da classe; Fazendo isso os dados já ficam salvos no objeto e podemos visualizar o objeto quando dermos um echo ( __toString exibe os dados cadastrados do objeto em formato JSON );

		//Caso tenhamos iniciado o obejeto com um login e uma senha, esses serão sobreescritos com os dados retornados do banco, dados que $user traz para a função;

		$this->setIdUsuario($user['idUsuario']);
		$this->setLogin($user['login']);
		$this->setPass($user['pass']);
		$this->setDtRegister(new DateTime($user['dtRegister']));//Usando o DateTime podemos formatar a saída da data de registro;


	}//Fim setUserData

	public function loadById($id){

		$sql = new Sql();

		$result = $sql->select('select idUsuario,login,pass,dtRegister from usuario where idUsuario=:ID',
			array(':ID'=> $id ));

		if ( count($result) > 0 ){ //Caso tenha algum registro dentro do array;

			// A função select da nossa classe Sql retorna um array de arrays. Como a consulta procurou por apenas 1 usuário o array de retorno terá apenas uma posição, a primeira , a 0;

			$this->setUserData($result[0]);

			
		}

	}//Fim loadById

	public static function getUsers(){//Retorna todos os usuários cadastrados no banco;

		$sql = new Sql();

		return $sql->select("select idUsuario,login,pass,dtRegister from usuario order by idUsuario"); 
		/*
			Se colocarmos o return só no $sql vai dar errado, pois $sql é só a istância da nossa classe,
			o array retornado pelo select não fica guardado nela. Precisamos dar um return no array do método select;  
		*/

	}//Fim getUsers

	public static function search($login){//Busca os dados do usuário de acordo com o login

		$sql = new Sql();//Classe com os métodos de acesso ao banco de dados

		return $sql->select("select idUsuario,login,pass,dtRegister from usuario where login=:LOG",

			array(
				':LOG'=>$login
			));

	}//Fim search


	public function login($login,$password){//retorna os dados de um usuário caso o login e a senha estejam de acordo com os dados cadastrados no banco;

		$sql = new Sql();

		$result =  $sql->select("select idUsuario,login,pass,dtRegister from usuario where login=:LOG and pass=:PASS",array(

			':LOG'=>$login,
			':PASS'=>$password
		));

		if (count($result) > 0){

			$this->setUserData($result[0]);

		}else{

			throw new Exception("Login or password error");
			
			
		}
	}//Fim login


	public function insert(){//Insere um novo usuário utilizando uma procedure do banco

		$sql = new Sql();

		if($this->login != "" && $this->pass != ""){//Fazemos essa verificação porque o construtor inicia esses dois atributos com "" caso não sejam passados valores. Não podemos inserir valores vazios no banco;

			$results = $sql->select("call insertUser(:LOGIN,:PASS)",array(

				':LOGIN' => $this->getLogin(),
				':PASS' => $this->getPass()
			));

			if( count($results) > 0){

				$this->setUserData($results[0]);//Função que sobreescreve os atributos do objeto User com os valores retornados do banco;

		    }

	   }else{

	   		throw new Exception("Set user login and password before proceed");
	   		

	   }

    }//Fim insert

    public function update($login,$pass){

   		$this->setLogin($login);
   		$this->setPass($pass);

   		$sql = new Sql();

   		$sql->query('update usuario set login=:LOGIN, pass=:PASS where idUsuario=:ID',array(

   			':LOGIN' => $this->getLogin(),
   			':PASS' => $this->getPass(),
   			':ID' => $this->getIdUsuario()

   		));

    }//Fim update

    public function delete(){

    	$sql = new Sql();

    	$sql->select('delete from usuario where idUsuario=:ID',array(
    		':ID' => $this->getIdUsuario()
    	));

    	$this->setIdUsuario("");
    	$this->setLogin("");
    	$this->setPass("");
    	$this->setDtRegister(new DateTime());
    
    }//Fim delete

}


?>