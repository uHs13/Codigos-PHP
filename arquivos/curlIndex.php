<?php 

require_once "config/Autoloader.php";
Autoloader::register();



if(isset($_POST['cep'])){
	
	$info = new CURL($_POST['cep']);
	$array = $info->findAdress();

}	


?>


<!DOCTYPE html>
<html>
<head>
	
	<title>Endereço</title>
	<link href="https://fonts.googleapis.com/css?family=Raleway:400,500" rel="stylesheet">

	<style>

		main{

			width:350px;
			border-radius: 3px;
			border:1px solid #eee;
			
			margin:0 auto;
			padding:10px 0;
			font-family:'Raleway';
			position: relative;
			box-shadow: 2px 2px 5px 1px #ababab;

		}

		h1{

			font-size: 14px;
			width:300px;
			display: flex;
			align-items: center;
			justify-content: center;
			margin:0 auto;
			margin-bottom: 15px;

		}
		

		input{

			display: block;
			width:300px;
			padding-left: 4px;
			margin:4px auto;
			height: 25px;
			border:1px solid #ddd;
			background-color: #fff;
			border-radius: 5px;
			font-family:'Raleway';
			color:#bbb;
		}

		button{

			display: flex;
			align-items: center;
			justify-content: center;
			margin: 5px auto;
			width: 100px;
			height: 30px;
			border:1px solid #fff;
			border-radius: 5px;
			font-family: 'Raleway';
			background-color: #fff;
			color:black;


		}

		button:hover{

			background-color: black;
			color:white;
			border:1px solid #000;
			box-shadow: 3px 3px 8px 1px #bbb;
			cursor:pointer;

		}


	</style>


</head>
<body>
	
	<main>

		<h1>Localizador de Endreços</h1>

		<form method="POST">

			<input type="text" name="cep" id='cep' placeholder="cep">
			<input type="text" name="logradouro" id='logradouro' disabled value="<?= isset($array['logradouro'])? $array['logradouro']:'Logradouro'?>">
			<input type="text" name="bairro" id='bairro' disabled value="<?= isset($array['bairro'])? $array['bairro']:'Bairro'?>">
			<input type="text" name="cidade" id='cidade' disabled value="<?= isset($array['localidade'])? $array['localidade']:'Cidade'?>">
			<input type="text" name="cidade" id='cidade' disabled value="<?= isset($array['uf'])? $array['uf']:'Estado'?>">
			
			<button>Find</button>

		</form>

	</main>

</body>
</html>
