<?php 
include_once "../tools/bootstrap.php";
class BdPdo{

	private $conn;//Variável que estabelece a conexão com o Banco de Dados;
	private $statement;//Variável que vai armazenar a query;
	private $dbData=array();


	function __construct($dbName, $host,$user,$pass){

		$this->startConnection($dbName, $host,$user,$pass);

	}

	function __destruct(){
	}

	private function setConn($dbName, $host,$user,$pass){

		$this->conn = new PDO("mysql:dbname=$dbName;host=$host",$user,$pass);

	}

	private function setdbData($value){

		array_push($this->dbData,$value);
	
	}

	private function getdbData(){

		return $this->dbData;
	}

	private function startConnection($dbName, $host,$user,$pass){

		try{//Usar try{}catch(){} pra capturar qualquer erro que ocorra durante a conexão com o banco de dados;
		$this->setConn($dbName, $host,$user,$pass);
		
		
		}catch(PDOException $e){

			echo "Error: ".$e->getMessage();
			die();
		}
	
	}

	private function getData($query){

		$this->statement = $this->conn->prepare($query);

		$this->statement->execute();

		//$result = $this->statement->fetchAll(PDO::FETCH_ASSOC);
		foreach ($this->statement->fetchAll(PDO::FETCH_ASSOC) as $value) {
			
			$this->setdbData($value);
			
		}

	}

	public function toTable(){

		$this->getData("select login,dtRegister from Usuario order by login");

		echo "<table class='table table-dark table-bordered w-50 p-3 mx-auto align-middle mt-5 '>";
		echo '<tr class="text-center text-warning">';
		echo '<th>Login</th>';
		echo '<th>Data e Hora do Registro</th>';
		echo '</tr>';
		echo '<tr>';

		foreach ($this->getdbData() as  $array) {

			echo '<td class="text-center text-white">';
			echo $array['login'];//como os dados foram salvos em forma de objeto dentro do dbData, podemos acessar os atributos de cada 
			echo '</td>';
			echo '<td class="text-center text-white">';
			echo $array['dtRegister'];
			echo '</td>';
			echo '</tr>';

		}
		
		echo '</table>';

	}


}

?>