<?php 

class Arquivo{

	private $fileName;//Guarda o nome do arquivo que vai ser aberto; 
	private $filePointer;//Guarda o ponteiro pro arquivo;
	//GETTERS ANS SETTERS

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
		
		}else{

			throw new Exception("Error opening file");
			
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


	}



}

?>