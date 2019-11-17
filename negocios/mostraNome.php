<?php

require_once("../tools/bootstrap.php");

echo "<form class='w-25 p-3 form-group mx-auto mt-3' style='margin-left:20%;'>";
echo "<div class=''>";
echo "<input type='text' name='nome' placeholder='nome' class='form-control mt-2'>";
echo "<input type='text' name='sobrenome' placeholder='sobrenome' class='form-control mt-2'>";
echo "<input type='text' name='idade' placeholder='idade' class='form-control mt-2'>";
echo "<input type='submit' value='Cadastrar' class='btn btn-success mx-auto mt-2 btn-lg w-100 p-1'>";
echo "</div>";
echo "</form>";


//Como não foi definido um action no formulário, o padrão é a URL da página que é em $_GET[];
if(isset($_GET['nome'])&& isset($_GET['sobrenome'])){//get - vetor , index - nome do input, value - o que for digitado;
	//$aux = array_unique($_GET);
	if (isset($_GET['idade'])) {
		$array = array();
		array_push($array,[$_GET['nome'],$_GET['sobrenome'],$_GET['idade']]);	
		foreach($array as $key => $unique){
			echo "<table class='table table-striped w-50 p-3 mx-auto align-middle'>";
			echo "<tr class='text-center'>";
			echo "<th >Nome</th>";
			echo "<th >Sobrenome</th>";
			echo "<th >Idade</th>";
			echo "</tr>";
			echo "<tr>";
			foreach($unique as $key => $value){
				echo "<td  class='text-center'>";
				echo $value;
				echo "</td>";
			}



		}
		echo "</tr>";
		echo "</table>";
	}

}else{
	echo "<p class='text-center text-info mt-4'>Digite Nomes</p>";
}

echo "<a href='../negocios' class='btn btn-primary' style='margin-left:47%;'>Voltar</a>";


?>