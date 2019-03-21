<?php 

class UploadfromInput{

	private $requestMethod;//tipo de requisição enviada pelo formulário HTML
	private $fileinfo;//array com as informações do arrquivo que vamos fazer upload
	private $dirName;//nome do diretório onde serão armazenados os arquivos que fizermos upload

	//getters and setters
	public function getReqMtd(){

		return $this->requestMethod;

	}

	private function setReqMtd($method){

		$this->requestMethod = $method;

	}

	public function getFileinfo($key){

		//retornamos o conteúdo de uma posiçã específica do array
		return $this->fileinfo[$key];

	}

	private function setFileinfo($array){

		$this->fileinfo =$array;

	}

	public function getDirName(){

		return $this->dir;

	}

	private function setDirName($dir){

		$this->dir = $dir;

	}
	
	//Fim getters and setters


	public function changeBackImage(){

		if($this->getReqMtd() === 'POST'){
		//Se as informações( binário do arquivo ) estiverem sendo passadas via post

			
			//Caso tenha ocorrido algum erro ao carregar o arquivo temos que abortar o upload
			//Se ocorreu um erro a chave com erro recebe o erro e o upload não funciona
			if($this->getFileinfo('error')){
				
				if(!$this->getFileinfo('name')){
					echo '<p style="color:#333;font-weight:bold;font-family:Raleway">SELECIONE UMA IMAGEM</p>';

					return; 
				}else{

					throw new Exception($this->getFileinfo('error'));

				}

				
				

			}//fim if


			//criamos o diretório onde iremos guardar os arquivos que fizemos o upload
			$this->createImagesDir();

			//Colocamos o arquivo dentro do diretório criado
			//move_uploaded_file(onde está o arquivo temporário, pasta de destino)
			if(Arquivo::upload($this->getFileinfo('tmp_name'),$this->getDirName().DIRECTORY_SEPARATOR.$this->getFileinfo('name'))){



				//$this->getFileinfo('name') -> nome original do arquivo
				//Se o upload acontecer com sucesso a função retorna true, false caso contrário


				$arq = new Arquivo($this->getDirName().DIRECTORY_SEPARATOR.$this->getFileinfo('name'),'r');


				//colocamos a imagem como background da página
				$this->buildBackground($arq->showImage());


			}//fim if


		}//fim if($this->getReqMtd() === 'POST')


	}//fim changeBackImage


	//Cria o diretório onde vamos armazenar todas os arquivos que fizemos upload
	public function createImagesDir(){

		Dir::createDir($this->getDirName());

		return true;
	}//fim createImagesDir


	//função que define uma imagem como background da página
	public function buildBackground($base64){

		echo "<style>

		body{

			background: url($base64) no-repeat left top fixed ;
			background-size:cover;
		}

		</style>";
		
		return true;

	}//fim buildBackground


	public function __construct($requestMethod,$arrayFileInfo,$dir){

		$this->setReqMtd($requestMethod);
		$this->setFileinfo($arrayFileInfo);
		$this->setDirName($dir);
		$this->changeBackImage();

	}

}

?>