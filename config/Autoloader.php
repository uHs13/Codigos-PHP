<?php 

class Autoloader{

	public static function register(){

		spl_autoload_register(function($class){

			if(file_exists("../classes". DIRECTORY_SEPARATOR. $class.'.php') === true){
				require_once("../classes". DIRECTORY_SEPARATOR. $class.'.php');
			}

		});
	}
}

?>