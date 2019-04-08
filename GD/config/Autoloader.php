<?php 

class Autoloader{

	public static function register(){


		spl_autoload_register(function($class){

			//O caminho é a partir de onde o arquivo que chamou o autoloader está
			$file = 'class'.DIRECTORY_SEPARATOR.$class.'.php';

			if(file_exists($file)){

				require_once($file);

			}

		});

	}

}



?>