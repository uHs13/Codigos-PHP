<?php 

class Autoloader{

	public static function register(){

		spl_autoload_register(function($class){

			if(file_exists("../classes". DIRECTORY_SEPARATOR. $class.'.php') === true){
				require_once("../classes". DIRECTORY_SEPARATOR. $class.'.php');
			}else{
				
				require_once("../classes/interface". DIRECTORY_SEPARATOR. $class.'.php');//Require obriga que o arquivo exista e que ele esteja funcionanado perfeitamente. Se uma desses condições não for satisfeita o PHP lança uma exceção (PHP7+) ou ou erro fatal (PHP < 7);
				//require once importa o arquivo uma vez só. Evita redundância na memória;
			}
			
		});
	}
}

?>