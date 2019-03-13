<?php 

class Dir{

	private $name;


	//GETTERS AND SETTERS
	public function setName($value){//public function name(){...}

		$this->name = $value;
	}

	public function getName(){

		return $this->name;

	}

	//FIM GETTERS AND SETTERS

	public function __construct($name=""){

		$this->setName($name);

	}


	public static function createDir($name){

    	if(!is_dir($name)){//Se o diretório não existir

			mkdir($name);//é criado um com o nome passado na pasta onde está o script;
			
			return true;//se criou retorna true;

		}//lembrando que uma função só retorna um valor, mas temos dois return. Isso ocorre porque somente um deles é exeutado, se entrar no if vai retornar true e sair da função, false caso contrário;

		return false;//se não criou retorna false;

	}//fim createDir

	public static function removeDir($name){//public static function -> funções estáticas, podemos chamar sem instanciar um objeto;

		if(is_dir($name)){


			rmdir($name);

			return true;//se conseguir remover o diretório retorna true
		}	

		//se não conseguiu retorna false;
		return false;

	}//fim removeDir

	public static function filesInfo($dir){

		//scandir retorna um array com os arquivos presentes no diretório e alguns sinais de diretório como . e .. ;
		$arqFiles = scandir($dir);

		$data = array();//variável que vai armazenar as informações de cada arquivo;

		//Para cada um dos arquivos encontrados
		foreach ($arqFiles as $file) {

			//in_array(onde,o_que_identificar)
			//nesse caso, se não for o ponto nem os dois pontos passando pelo foreach
			if(!in_array($file, array('.','..'))){

				//nome do diretório, separador e o nome do arquivo da vez
				$filename = $dir . DIRECTORY_SEPARATOR . $file;

				//Recebe informações sobre o arquivo
				$info = pathinfo($filename);

				//retorna o tamanho do arquivo em bytes;
				//cast para transformar o valor inteiro em string (string)filesize($filename). Outra opção é o strval();

				$info['size'] = filesize($filename);

				$info['modified'] = date('d/m/Y H:i:s',fileatime($filename));

				//Em php \ é escape, para colocar \ temos que digitar \\ 
				$info['url'] ='http://localhost/PHP/dir/'.str_replace('\\','/',$filename);
				array_push($data,$info);


			}

		}

		return $data;

	}

}//fim Dir

?>