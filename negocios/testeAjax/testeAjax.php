<?php 
	
	$nome =  "";

	$idade= "";

	if($_SERVER['REQUEST_METHOD'] === 'POST'){

		$nome  = $_POST['nome'];
		$idade = $_POST['idade'];

		echo json_encode(array($nome,$idade));

		return true;

	}

	if($_SERVER['REQUEST_METHOD'] === 'GET'){

		echo 'REQUISIÇÃO GET';

	}



?>