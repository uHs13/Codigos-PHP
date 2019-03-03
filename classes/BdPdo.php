<?php 
include_once "../tools/bootstrap.php";
class BdPdo{

	private $conn;//Variável que estabelece a conexão com o Banco de Dados;
	private $statement;//Variável que vai armazenar a query;
	private $dbData=array();//array que armazena o DataSet das consultas;
	private $statementStarted = false;//armazena um booleano que indica se o statement já foi preaprado. False == não, True == sim;

	function __construct($dbName, $host,$user,$pass){

		$this->startConnection($dbName, $host,$user,$pass);

	}

	function __destruct(){
	}

	private function setConn($dbName, $host,$user,$pass){

		$this->conn = new PDO("mysql:dbname=$dbName;host=$host",$user,$pass);

	}

	private function getConn(){

		return $this->conn;

	}
	private function setdbData($value){

		array_push($this->dbData,$value);

	}

	private function getStatement(){

		return $this->statement;
	
	}

	private function getdbData(){

		return $this->dbData;
	}

	private function startConnection($dbName, $host,$user,$pass){

		try{//Usar try{}catch(){} pra capturar qualquer erro que ocorra durante a conexão com o banco de dados;
		$this->setConn($dbName, $host,$user,$pass);
		
		$this->getConn()->beginTransaction();//Inicia a transação que controla as operações, permite ou cancela. Isso é uma camada de segurança a mais contra erros de inserção ou remoção;
		
		}catch(PDOException $e){

		echo "Error: ".$e->getMessage();
		die();
		
		}
	
	}

	private function swapStatement(){//Função que troca o valor da variável $statementStarted. Essa variável vai indicar se o Statement já foi preparado. Se sim vai ser true, não false. Precisamos verificar esse estado pois só podemos chamar o statement->execute() caso o statement já tenha sido preparado;

		$this->statementStarted = !$this->statementStarted; 

	}


	private function setStatement($query){//Como essa linha de preparar o statement é repetida, convém criarmos um método;

		$this->statement = $this->conn->prepare($query);

	}

	private function execStatement(){

		if($this->statementStarted){//Só podemos executar um statement se ele já tiver sido preparado.
			
			$this->getStatement()->execute();

			$this->swapStatement();

		}else{
			
			return;

		}

	}

	private function prepareRetriev($query){//Função que prepara uma query de consulta de dados;


		$this->setStatement($query);

		$this->swapStatement();//Agora que o statement foi preparado podemos trocar o valor da $statementStarted;

		$this->execStatement();//Statement é o camando SQL, ( Query );
		
		$this->swapStatement();//Troca o valor da statement para garantir que outras consultas não vão ser realizadas com o mesmo statement. Mesmo que seja mesma consulta o processo todo tem que ser refeito.

	}

	//Como a query de insert vai ser a mesma toda vez, as únicas alterações serão os valores dos atributos, não precisamos receber a query por parâmetro, somente os valores a serem inseridos;
	private function prepareInsert($log,$pss){//Função que prepara uma query de inserção de dados;

		// A query fica "engessada" dentro da função;
		//insert into nomeTabela(atributos) values(valores)
		$this->setStatement("insert into usuario(login,pass) values (:LOGIN,:PASSWORD)");

		$this->getStatement()->bindParam(':LOGIN',$log);
		
		$this->getStatement()->bindParam(':PASSWORD',$pss);

		$this->swapStatement();

		$this->execStatement();
	

	}

	private function prepareUpdate($id,$pass){
		//update nomeTabela set atributo=valor where condicoes
		$this->setStatement("Update usuario set pass = :PASS where idUsuario = :ID");
		
		$this->getStatement()->bindParam(":PASS",$pass);

		$this->getStatement()->bindParam(":ID",$id);

		$this->swapStatement();

		$this->execStatement();



	}	

	private function prepareRemove($id){
		//delete from nomeTabela where condicoes
		$this->setStatement("delete from usuario where idUsuario= :ID");

		$this->getStatement()->bindParam(":ID",$id);

		$this->swapStatement();

		$this->execStatement();

		//$this->getConn()->rollback(); -> Cancela a transação

		//$this->getConn()->commit(); -> Confirma a transção e permite deletarmos um registro
	}

	private function getData($query){//função que consulta dados existentes no banco; 

		$this->prepareRetriev($query);//Com a query passada consultamos o banco de dados
		
		//$result = $this->statement->fetchAll(PDO::FETCH_ASSOC);
		foreach ($this->getStatement()->fetchAll(PDO::FETCH_ASSOC) as $value) {
			
			$this->setdbData($value);
			
		}

	}


	public function userstoTable(){//Retorna os dados dos usuários cadastrados no banco em forma de tabela;

		$this->getData("select login,dtRegister,pass from Usuario order by login");

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

	public function newUser($login,$pass){//Cadastra um novo usuário no banco;

		$this->prepareInsert($login,$pass);
	
	}

	public function updateUser($id,$pass){

		$this->prepareUpdate($id,$pass);
	}

	public function deleteUser($id){

		$this->prepareRemove($id);
	}
}

?>