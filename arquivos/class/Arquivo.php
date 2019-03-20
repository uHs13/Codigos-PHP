<?php 

class Arquivo{

	private $fileName;//Guarda o nome do arquivo que vai ser aberto; 
	private $filePointer;//Guarda o ponteiro pro arquivo;

	//GETTERS AND SETTERS

	public function getFileName(){

		return $this->fileName;

	}

	public function setFileName($name){

		$this->fileName = $name;

	}

	public function getFilePointer(){

		return $this->filePointer;

	}

	public function setFilePointer($mode){

		if(isset($this->fileName)){//só conseguimos abrir se o caminho do arquivo tiver sido especificado

			$this->filePointer = fopen($this->fileName,$mode);

			return true;


		}else{

			throw new Exception("Error opening file");
			
			return false;
		}
	}
	//FIM GETTERS AND SETTERS

	public function __construct($path,$mode){

		$this->setFileName($path);

		$this->setFilePointer($mode);

	}

	public function __destruct(){

		fclose($this->filePointer);

	}


	public function write($value){

		fwrite($this->getFilePointer(),$value."\r\n" );//Tem que ser com aspas duplas o \r\n 

		return true;
	}

	public function readCsv():array{

		//Precisamos conferir se o arquivo existe porque não dá pra ler o invisível/nada;
		if(file_exists($this->getFileName())){

			//abre o arquivo em modo de leitura
			$this->setFilePointer('r+');

			//fgets lê uma linha por vez
			//Adicionamos a primera linha do arquivo ( snome das coluna ) em um array
			$headers = explode(';',fgets($this->getFilePointer()));

			//Armazena os dados de todas as linhas das tabelas 
			$fileData = array();

			while($Filerows = fgets( $this->getFilePointer() ) ){
				
				//transformamos a linha do arquivo (string com elementos separados por ;) em um array
				$row = explode(';',$Filerows);
				//('valor1','valor2',...)
				

				//Criamos a variável que vai armazenar as relações chave=>valor da linha
				//tem que ser esvaziada a depois de cada passada do while para armazenar somente dados da mesma linha
				$rowData = array();

				//para cada elemento do $row ( cada valor encontrado na linha )
				foreach( $row as $key=> $value ){

					/*
					    Relacionamos o valor encontrado na posição do array $row com o valor da mesma posição do array $headers, pois cada elemento do header representa uma coluna e cada elemento do array $row representa um valor dessa coluna 
						
						Ao armazenar dessa forma, para cada vez que o while passar, adicionamos ao array
						$rowData uma relação 'nomeColuna'=>'valor'.

					*/

					$rowData[ $headers[$key] ] = $value ; 
					//a cada vez vai sendo adicionada uma nova chave com um novo valor
					//1x  ('header'=>'valor_da_row')
					//2x  ('header'=>'valor_da_row', 'header'=>'valor_da_row')


				}//fim foreach
				
				//Ao final do foreach ( depois de termos relacionado cada elemento de $row com o nome da sua coluna de origem) colocamos o array com os dados da linha em um outro array, esse que armazena todas as linhas do arquivo

				array_push($fileData,$rowData);

			}//fim while	

			//Depois do while $fileData armazena as relações chave=>valor de todas as linhas do .csv
			//retornamos o array com todos as linhas do arquivo ((dados linha 1),(dados linha 2),...)
			return $fileData;

		}else{//Se não der pra abir o arquivo saimos da função

			return false;

		}

	}//fim read


	public function destroy(){

		unlink($this->fileName);//apaga o arquivo que o objeto aponta

		return true;

	}//fim destroy	


	public function createSeveral($dir,$array){

		foreach($array as $fileName){

			$this->__construct($dir.'/'.$fileName,'w+');


		}


	}//fim createSeveral

	public function showImage(){

		$base64 = base64_encode(file_get_contents($this->getFileName()));//tranforma em base64 o arquivo que o objeto abriu

		$fileInfo = new finfo(FILEINFO_MIME_TYPE);//mime type é usado para determinar qual o tipo do arquivo que está sendo usado

		$mimeType = $fileInfo->file($this->getFileName());//Pegamos o mime type do arquivo 

		$base64encode = 'data:'.$mimeType.';base64,'.$base64;//montamos o padrão de exibição do base64;

		return $base64encode;

	}


}

?>