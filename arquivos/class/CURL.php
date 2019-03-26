<?php 

class CURL{

	private $cep;
	private $link;
	


	//GETTERS AND SETTERS

	private function getCep(){

		return $this->cep;//pra funcionar a função o cep tem que ser somente números

	}

	private function getLink(){

		return $this->link;

	}


	private function setLink(){

		$cep = $this->getCep();//Criamos uma vairável porque não conseguimos até o momento chamar métodos no meio de uma string;

		$this->link = "https://viacep.com.br/ws/$cep/json/";//Tem que ser aspas duplas pra funcionar a interpolação de variáveis;

	}


	//FIM GETTERS AND SETTERS

	public function findAdress(){

		$this->setLink();//Inicializamos o atributo link com a url e o cep passado;

		$ch = curl_init($this->getLink());

		//curl_setopt(bilbiotecaUsada,constantedeRetorno, esperamosRetorno)-> Temos que especificar que queremos retorno para a função retornar as informações do endereço
		curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);//não verifica se o SSL ( secure socket layer ) é válido. SSL -> segurança digital que permite a comunicação encriptada entre aplicação e servidor

		//^^^^^Configuração das opções do curl^^^^^

		//Aqui disparamos o acesso para a url
		$response = curl_exec($ch);

		//fecha a conexão 
		curl_close($ch);

		$exploded = explode("CURL", $response);//é necessário fazer o implode porque $response recebe as informações do endereço e um objeto curl, portanto temos que separar as informações que nos são úteis das demais 

		return(json_decode($exploded[0],true));
		

	} 


	public function __construct($cep){

		$this->cep =  $cep;

		


	}

}


?>