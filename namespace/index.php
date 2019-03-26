<?php 
	require_once("config.php");
	use cliente\Cadastro;//use namespace\classe

	$person = new Cadastro("Francisco Bioca","chico.bioca@gmail.com","fb1976");
	$person->RegistraVenda();


?>