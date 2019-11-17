<?php
//CONEXAO DIRETA COM BANCO MYSQL;
include_once "../tools/bootstrap.php";
class ConexaoBD{

	private $connection;//atributo que vai armazenar os dados da conexão com o banco;
	private $statement;//atributo usado para passar os valores que serão inseridos no banco;
	private $dbData= array();//array que vai armazenar os dados presentes no banco;

	public function __construct($server, $user, $pass, $dbName){

		$this->setConnection($server, $user, $pass, $dbName);

		$this->getData();
		
	}

	function __destruct(){
		
	}

	private function setConnection(string $server,string $user,string $pass,string $dbName){//O método recebe os dados de conexão com o banco de dados e a estabelece;

		$this->connection = new mysqli($server, $user, $pass, $dbName);

		$this->getConnectionError($this->connection);//função para verficar se a conexão foi estabelecida normalmente;
		
	}

	private function setdbData($object){

		array_push($this->dbData, $object);
	
	}

	public function getdbData(){

		return $this->dbData;

	}

	private function getConnectionError($connVar){

		if(isset($connVar)){
			//connect_error é um atributo da classe mysqli que retorna um erro caso a conexão com a base de dados não tenha sido estabelecida; 
			return ($connVar->connect_error)? $connVar->connect_error: true ;
		
		}
	}

	public function insertData($login,$pass){//Função que insere os valores passados como parâmetro no banco de dados;

		$this->statement = $this->connection->prepare('insert into usuario (login,pass) objects(?,?)');

		$this->statement->bind_param('ss',$login,$pass);

		if($this->statement->execute()) $this->setInsertMsg($login);

	}


	private function getData(){//Através da query recuperamos todos os logins e datas de registro de todas as tuplas da tabela usuário. Como utilizar select * from é uma pessima prática trabalhamos melhor a consulta.

		//USAR ORDER BY PRA RETORNAR O DATASET ORGANIZADO;
		$result = $this->connection->query('select login,dtRegister from usuario order by login');
		

		while($row = $result->fetch_object()){//fetch object retorna as colunas e os respectivos valores formatados como objeto. Fica mais simples e mais bonito que usar array;

			$this->setdbData($row);//setdbData é um setter normal do atributo dbData;

		}

		unset($result,$row);

	}

	public function toTable(){//Com os dados presentes no atributo dbData montamos uma tabela para melhor visualização dos dodos presentes no banco

		echo "<table class='table table-dark table-bordered w-50 p-3 mx-auto align-middle mt-5 '>";
		echo '<tr class="text-center text-warning">';
		echo '<th>Login</th>';
		echo '<th>Data e Hora do Registro</th>';
		echo '</tr>';
		echo '<tr>';

		foreach ($this->getdbData() as  $object) {

			echo '<td class="text-center text-white">';
			echo $object->login;//como os dados foram salvos em forma de objeto dentro do dbData, podemos acessar os atributos de cada 
			echo '</td>';
			echo '<td class="text-center text-white">';
			echo $object->dtRegister;
			echo '</td>';
			echo '</tr>';

		}
		
		echo '</table>';

	}

	
}
?>