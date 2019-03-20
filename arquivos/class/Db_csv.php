<?php 

class Db_csv{

	private $sql;
	private $file;
	private $usersArray;
	//Getters and Setters

	private function getSql(){

		return $this->sql;

	}

	private function initSql(){

		$this->sql = new Sql();//Sql é a nossa classe que usa PDO

	}

	private function getFile(){

		return $this->file;
	
	}

	private function initFile($path,$mode){

		$this->file = new Arquivo($path,$mode);

	}

	private function getUsersArray(){

		return $this->usersArray;

	}

	private function setUsersArray($query){

		$this->usersArray = $this->getSql()->select($query);

	}
	//Fim Getters and Setters


	//Métodos

	private function buildHeaders(){

		$headers = array();

		//Percorre o primeiro elemento do array de usuários apenas pegando o nome das chaves para adicionar no arquivo de destino como nome das colunas
		foreach ($this->getUsersArray()[0] as $key => $value) {
			
			array_push($headers,$key);


		}

		//Adiciona o nome das chaves no arquivo usando a função implode
		//implode('simbolo',$array) junta os elementos do array em uma string utilizando o simbolo como separador 

		$this->getFile()->write(implode(';',$headers));

	}

	private function insertData(){

		$Data = array();

		//percorre os elementos do array de usuários
		foreach($this->getUsersArray() as $user){

			//para cada elemento percorre todas as chaves e valores ('login'=>'Xzibit','pass'=>'X') existentes 
			foreach($user as $key => $value){

				//adiciona o valor de cada chave no array
				//array_push($Data,'Xzibit'); array_push($Data,'X');
				//faz esse processo para todos os conjuntos chave=>valor que encontrar 
				array_push($Data,$value);

			}

			//escreve o array com os dados dentro do arquivo;
			$this->getFile()->write(implode(';',$Data));

			//limpa o array para garantir que dados de registros diferentes não se misturem
			$Data = array();

		}

	}

	public function builtCsv(){
		//chama as duas funções anteriores para construir o arquivo .csv com os dados retornados pelo banco

		$this->buildHeaders();
		$this->insertData();

	}

	//Fim métodos


	public function __construct($filePath,$openingMode,$query){

		$this->initSql();
		$this->initFile($filePath,$openingMode);
		$this->setUsersArray($query);
		$this->builtCsv();

	}


}


?>