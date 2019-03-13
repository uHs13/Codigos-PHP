<?php 

class Autoloader{

	public static function register(){

		spl_autoload_register(function($class){//spl_autoload_register(function($class){...});

			$file ='class/'.DIRECTORY_SEPARATOR.$class.'.php';//O diretório que é a partir do lugar onde o arquivo que chamou está;

			if(file_exists($file)){

				require_once($file);
			}


		});

	} 

}



?>