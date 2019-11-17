<?php 

namespace cliente;//determina o nome do namespace dessa em que está essa classe;

class Cadastro extends \Cadastro{//volta na pasta raiz e procura a classe cadastro;

	public function RegistraVenda(){

		echo "Foi vendido um produto para o sr.".$this->getNome().".";
	}

	public function MostraDetalhes(){
		$this->__toString();
	}

}

?>