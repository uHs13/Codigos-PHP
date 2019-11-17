<?php 

class Autoloader{

	public static function register(){


		spl_autoload_register(function($class){

			//Lembrando que o caminho é a partir de onde o arquivo que chamou o Autoloader está;
			$file = 'class/'.$class.'.php';

			if(file_exists($file)){

				require_once($file);

			} 

		});

	}


}

?>