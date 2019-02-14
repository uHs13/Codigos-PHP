<?php 
/**
  class nomeClasse{
	private/public/protected $var;
 	function __construct(){}//construtor;
 	function __destruct(){}//destrutor;
  }
	ALT+F3 -> SELECIONA TODAS AS PALAVRAS IGUAIS DE UMA VEZ PRA REFATORAR;
	// array_push(onde, oq);
*/
	require_once "../tools/bootstrap.php";
	class Movel{

		private $nome;
		private $dimensoes;
		private $cor;
		private $locais;

  	function __construct($nome,$dimensoes,$coloracao,$lugar){//metodo construtor
  		$this->nome = $nome;
  		$this->dimensoes = $dimensoes;
  		$this->cor = $coloracao;
  		$this->locais=$lugar;

  	}
  	
  	function __destruct(){//metodo destrutor
  		echo "<p class='text-center text-danger'>".$this->nome." "."destruida(o)</p>";
  	}

  	function getNome(){
  		if(isset($this->nome))return $this->nome;
  	}

  	function getdimensoes(){
  		if(isset($this->dimensoes))return $this->dimensoes;
  	}

  	function getCor(){
  		if(isset($this->cor))return $this->cor;
  	}

  	function getLocais(){
  		if(isset($this->locais))return $this->locais;
  	}


   function toTable(){

    if(isset($this)){
     echo "<table class='table table-striped table-bordered w-50 p-3 mx-auto align-middle mt-5'>";
  			//echo "<thead><tr><th><p class='text-center'>Dados</p></th></tr></thead>";
     echo "<tbody>";
     echo "<tr class='text-center'>";
     echo "<th scope='row' class='text-success'>Nome</th>";
     echo "<td>";	
     echo $this->getNome();
     echo "</td>";
     echo "</tr>";
     echo "<tr class='text-center'>";
     echo "<th scope='row' class='text-success'>Dimensoes</th>";
     echo "<td>";
     echo $this->getdimensoes();
     echo "</td>";
     echo "</tr>";
     echo "<tr class='text-center'>";
     echo "<th scope='row' class='text-success'>Coloracao</th>";
     echo "<td>";
     echo $this->getCor();
     echo "</td>";
     echo "</tr>";
     echo "<tr class='text-center'>";
     echo "<th scope='row' class='text-success'>Local</th>";
     echo "<td>";
     echo $this->getLocais();
     echo "</td>";
     echo "</tr>";
     echo "</tbody>";
     echo "</table>";
   }

 }

}

?>
<?php 
  //nome, dimensao, cor, locais
echo "<div class='w-25 p-3  form-group mx-auto'>";
echo "<form method='GET'>";
echo "<input name='nome' placeholder='Nome' class='form-control mt-2'>";
echo "<input name='dimensao' placeholder='Dimensoes' class='form-control mt-2'>";
echo "<input name='cor' placeholder='Cor' class='form-control mt-2'>";
echo "<input name='local' placeholder='Local' class='form-control mt-2'>";
echo "<input type='submit' value='Cadastrar' class='btn btn-success mx-auto mt-2 btn-lg w-100 p-1'>";
echo "</form>";
echo "</div>";
  $Cadeira = new Movel('cadeira','1.58','marrom','copa');
  $Cadeira->toTable();
if(isset($_GET['nome']) && isset($_GET['dimensao'])){
 if(isset($_GET['cor']) && isset($_GET['local'])){
  $Mesa = new Movel($_GET['nome'],$_GET['dimensao'],$_GET['cor'],$_GET['local']);
  $Mesa->toTable(); 
  unset($Mesa);	
}

}else{
 echo "<p class='text-center text-info'>Cadastre um Móvel</p>";
}
echo "<a href='../classes' class='btn btn-primary' style='margin-left:47%;'>Voltar</a>";

?>