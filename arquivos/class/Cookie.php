<?php 

class Cookie{

	private $name;
	private $content;

	//GETTERS AND SETTERS

	private function setName($value){

		$this->name = $value;

	}

	private function setContent($value){

		$this->content = $value;

	}


	private function getName(){

		return $this->name;

	}

	private function getContent(){

		return $this->content;

	}


	//FIM GETTERS AND SETTERS


	public function createCookie($time_in_seconds){

		//time() -> retorna o timestamp do momento da criação
		setcookie($this->getName(),json_encode($this->getContent()),time() + $time_in_seconds);


	}

	public function getCookie(){

		if(isset($_COOKIE[$this->getName()])){


			//$_COOKIE[] -> array super global que já contém os cookies que existem na máquina
			return json_decode($_COOKIE[$this->getName()]);
			/*sem passar o parâmetro true ( para converter em array ) a função nos retorna um objeto do tipo std_class (standard class). Para acessar seus atributos é simples:

				$var = json_decode($_COOKIE[$name]);
				
				$var->name;
				$var->age;
				
				name e age são chaves/atributos da variável que está sendo convertida

			*/
		} else {

			throw new Exception($this->getName()." don't exists");
			

		}

	}



	public function __construct($name,$content=""){

		$this->setName($name);
		$this->setContent($content);

	}

}	

?>