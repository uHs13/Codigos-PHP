<?php 

class Autoloader{

	public static function register(){

		spl_autoload_register(function($class){

			$file = '../class/'.$class.'.php';

			if(file_exists($file)){
				require_once($file);
			}


		});



	}



}


?>