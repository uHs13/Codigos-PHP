<?php  
class Cadastro{//Nome da classe igual ao nome do arquivo;
	
	private $nome;//variável tem que ter $;
	private $email;
	private $senha;


	public function __construct($name, $email, $pass){
		
		$this->setNome($name);
		$this->setEmail($email);
		$this->setSenha($pass);
		
	}

	public function getNome():string{//declarar o tipo de retorno da função é um padrão do PHP7;
		if(isset($this->nome)) return $this->nome;
	}

	public function setNome($name){//getters e setters são utilizados para estabelecer restrições para o acesso e modificação de dados dos atributos das nossas classes;
		$this->nome = $name;
	}

	public function getEmail():string{
		if(isset($this->email)) return $this->email;
	}

	public function setEmail($em){
		$this->email = $em;
	}

	public function getSenha():string{
		if(isset($this->senha)) return $this->senha;
	}

	public function setSenha($pass){
		$this->senha = $pass;
	}

	public function __toString():string{
		if(isset($this)){
			return json_encode(array(
				
				'nome'=>$this->getNome(),	
				'Email'=>$this->getEmail(),
				'Senha'=>$this->getSenha()

			));
		}
	}


}

?>