<?php 

class Autoload
{

	public static function register()
	{

			//Para indicar ao projeto onde ele deve buscar as classes temos que fazer o autoload;
		spl_autoload_register(function($nameClass){//função anonima com o nome da classe que está sendo chamada;

			//$dirClass = "class";//pasta onde o autoloader deve procurar as classes do projeto;


			$filename = "classes".DIRECTORY_SEPARATOR. $nameClass . '.php';//Filename não é só o nome do arquivo (ex.:'classe.php'), se refere a todo o caminho dele (Path);

			// echo $filename;

			if(file_exists($filename)){//Se o arquivo da classe chamada existir;

				require_once($filename);

			}

		});

	}

}


?>