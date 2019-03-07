<?php 

class Autoloader{

	public static function register(){

		spl_autoload_register(function($class_name){

			$file ="class".DIRECTORY_SEPARATOR.$class_name.'.php';


			if(file_exists($file)){//deixar apenas o $file como argumento. Tudo que for referente ao caminho do arquivo alterar na atribuição de valor da variável;

				require_once($file);

			}

		});

	}



}


?>