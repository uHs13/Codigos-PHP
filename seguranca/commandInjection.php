<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	echo "<pre style='font-size:20px;'>";

	$cmd = escapeshellcmd('mkdir NOVAPASTA && dir');

	var_dump($cmd);

	system('mkdir CRIANDOPASTA && dir');

	echo "</pre>";

	// $cmd = $_POST['cmd'];
	//identifica sinais de comando ( \ , && ) e coloca um caracter para impedir que a linha seja interpretada como um comando

	// var_dump($comando);

}

?>

<form method='POST'>
	
	<input type="text" name="cmd">
	<button>Enviar</button>


</form>
