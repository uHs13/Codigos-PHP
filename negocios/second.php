<?php 
require_once "../funcoes/verificacao.php";
require_once("../tools/bootstrap.php");

echo "<div class='w-25 p-3  form-group mx-auto'>";
echo "<form method='GET' >";
echo "<select name='vlrInicial' class='form-control form-control-sm mt-2'>";

for ($i=1;$i<=49;$i++){//selection com for do PHP;

	echo'<option value="'.$i.'">'.$i.'</option>';

}

echo "</select>";


echo "<select name='vlrFinal' class='form-control form-control-sm mt-2 '>";

for ($i=50;$i<=100;$i++){

	echo'<option value="'.$i.'">'.$i.'</option>';

}
echo "<div class='mx-auto'>";
echo "<input class='btn btn-success mx-auto mt-2  btn-lg w-100 p-1' type='submit' value='Enviar'/>";
echo "</div>";

echo "</select>";

echo "</form>";

echo "</div>";

if(isset($_GET['vlrInicial']) && isset($_GET['vlrFinal'])){

	

	echo "<table class='table table-striped w-50 p-3 mx-auto align-middle'>";
	echo "<tr class='text-center'>";
	echo "<th >Idade</th>";
	echo "<th >Estado</th>";
	echo "<th >Faixa</th>";
	echo "<th >Habilitacao</th>";
	echo "</tr>";


	for($idade=$_GET['vlrInicial'];$idade<=$_GET['vlrFinal'];$idade++){

		echo "<tr class='text-center'>";


		echo "<td >";
		echo $idade;
		echo "</td>";

		echo "<td >";
		echo faixaEtaria($idade);
		echo "</td>";

		echo "<td >";
		echo verificaidade($idade);
		echo "</td>";

		echo "<td >";
		echo carteira($idade);
		echo "</td>";

	}
	unset($idade, $_GET, $i);
	echo "</tr>";
	echo "</table>";
	echo "<div class='mt-3  mb-3' style='margin-left:45%;'>";
	echo "<a href='../negocios' class='btn btn-primary'>Voltar</a>";
	echo "</div>";



}else{
	echo "<div class='mx-auto'>";
	echo "<p class='text-center text-info'>Selecione dois valores</p>";
	echo "</div>";
}

?>