<?php 

namespace Hcode\DB;
				  
				  //Tem que colocar \ em todo lugar que aparece PDO ( porque? boa pergunta... )
class Sql extends \PDO{

	private $connection;
	public $errorArray = array();

	public function __construct(){

		$this->setConnection();

	}//fim construct

	private function setConnection(){
	//Método que liga a nossa classe ao banco de dados

		$this->connection = new \PDO('mysql:host=127.0.0.1;dbname=db_ecommerce','root','Heitor13');

	}//Fim setConnection


	private function getConnection(){
	// Estrutura de funções visibilidade function nome(){...}

		return $this->connection;

	}//fim getConnection

	public function query($rawQuery,$parameters = array()){//Prepara a query e a executa

		//Statement é a variável que guarda a query que está sendo preparada para ir para o banco;
		$statement = $this->getConnection()->prepare($rawQuery);//Para mandar uma query pra dentro do banco precisamos prepara-la, inicializar seus parâmetros.

		$this->setParameters($statement,$parameters);//Chamamos o método da nossa classe que vincula os parâmetros da query com os seus respectivos valores;

		if(!$statement->execute()){
				
			$this->errorArray = $statement->errorInfo();//retorna um log com o erro ocorrido
			return false;	
		}

		return $statement;


	}//fim query

	private function setParameters($statement,$parameters = array() ){
	//criamos um método para iniciar os parâmetros da query porque é uma etapa presente nas ações para inserir , alterar ou ler dados do banco; Se vamos usar um trecho de código mais de uma vez convém criarmos um método;

		foreach ($parameters as $key => $value){

			//Statement é a variável que guarda a query que está sendo preparada para ir pro banco;
			$this->setParam($statement,$key,$value);
			//Vinculamos cada um dos parâmetros da query com o seu valor;
		}

		

	}//fim setParameters

	private function setParam($statement,$key,$value){
	//Precisamos desse método porque nem todas as vezes vamos passar vários parâmetros para a query;

		//Nesse método estamos vinculanco o parâmetro da query com o seu valor;
		$statement->bindParam($key,$value);
		
		
		
	}//fim setParam

	//Select
	public function select($rawQuery, $parameters = array()):array{
	//declaração de tipo de retorno da função;

		$dataSet = $this->query($rawQuery,$parameters);
		
		//caso ocorra algum erro é retornado o log do mesmo
		if(!$dataSet) return $this->errorArray;
		
		return $dataSet->fetchAll(\PDO::FETCH_ASSOC);

	}//Fim select



}


 ?>