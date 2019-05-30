<?php  

namespace Hcode;//especificar sempre o namespace que a classe está

use Rain\Tpl;

class Page
{

	//criado como privado para outras classes não terem acesso
	private $tpl;

	private $options = [];//array que vai armazenar os dados para criação do página

	//opções padrão para criação da página
	private $defaults = [

		//variáveis que passaremos para a criação do template
		'data'=> [

		],


	];


	//as variáveis que serão adicionadas as páginas vão variar de acordo com a rota, logo precisamos recebê-las como parâmetro de inicialização do objeto
	public function __construct($opts = array()) // Primeiro método a ser executado na classe
	{
		//array_merge -> função que junta dois arrays. Sobreescreve o primeiro com os dados passados no segundo e retorna o novo array ( Semelhante ao Object.assign do JavaScript ) 
		$this->options =  array_merge($this->defaults, $opts);

		$path = $_SERVER["DOCUMENT_ROOT"]."/PHP/ecommerce";

		// config
		$config = array(//configurando as opções do RainTpl
			
			"tpl_dir"   => $path."/views/",//pasta onde o rain vai procurar os arquivos HTML
			"cache_dir" => $path."/views-cache/",//página de cache onde o rain armazena os templates já com php
			"debug"     => false // set to false to improve the speed
		
		);

		Tpl::configure( $config );//passa as configurações iniciais para a classe Tpl

		// create the Tpl object
		$this->tpl = new Tpl;//adicionado como atributo da classe para podermos ter acesso em outros métodos

		$this->setData($this->options["data"]);

		//draw recebe o nome do arquivo que vamos carregar
		$this->tpl->draw("header");//arquivo que está dentro da pasta views

	}

	private function setData($data = array())
	{

		//os dados necessários para a inicialização da página vão estar na chave 'data' do atributo options da nossa classe, logo devemos percorre-lo e passar esses dados para a classe Tpl ( nesse caso para o nosso objeto Tpl )
		foreach ($data as $key => $value) {
			
			//atribuição das variáveis que vão aparecer no template
			$this->tpl->assign($key,$value);

		}

	}


	//função para trabalhar o conteúdo da página
	/*
		$name => nome do template,
		$data => variáveis que serão usandas na construção da página,
		$return => informa se queremos que retorne o html ou apenas carregue-o na tela
	*/
	public function setTpl($name, $data = array(), $return = false)
	{

		$this->setData($data);

		//caso seja necessário retornar vai ser retornado, se não só desenha na tela e ignora o return
		return $this->tpl->draw($name, $return);

	}


	public function __destruct() // último método a ser executado
	{

		$this->tpl->draw("footer");//arquivo que está dentro da pasta views

	}


}


?>