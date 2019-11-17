<?php 

require_once 'config/Autoloader.php';

Autoloader::register();


if(isset($_POST['link'])){

	$img = Arquivo::download($_POST['link'],'_download');

	//Dir::filesInfo('_res')[3]['url']
	//http://localhost/PHP/dir/_res/racionais.jpg

	echo"

		<style>
		body{

			background: url($img) no-repeat left top fixed;
			background-size:cover;
		}
		</style>

	";
}
	


?>



<!DOCTYPE html>
<html>
<head>
	<title>Download</title>
	<link href="https://fonts.googleapis.com/css?family=Raleway:400,500" rel="stylesheet">
	<style>
		

		main{

			/*Para centralizar usando margin:0 auto temos que determinar uma largura para o elemento*/
			width:40%;
			margin:0 auto;
			border:1px solid  rgb(195,195,195);
			font-family: 'Raleway';
			text-align: center;
			padding-bottom:20px; 
			border-radius: 5px;
			position: absolute;
			top:10%;
			left:30%;
			box-shadow: 3px 3px 8px 1px #bbb;
			background-color: #fff;



		}



		header{

			color:rgb(243,243,243);
		
			font-size: 20px;
			font-weight: 500;
			margin-top:10px;
			margin-bottom:20px;
			background-color: rgb(164,155,208);
			line-height: 40px;/*40px*/
		}


		input{

			height:20px; 
			outline: none;
			border-radius: 2px;
			border:1px solid rgb(149,147,153);
			margin-left: 0 3px;
			padding:2px;
			font-family: 'Raleway';
			font-size: 14px;
			font-weight: 500;
			padding-left: 5px; 
			color:rgb(175,174,179);


		}


		button{

			border:1px solid rgb(175,168,215);
			color:rgb(175,170,221);
			outline: none;
			line-height: 23px;

			border-radius: 3px;
			background-color: #fff;
			
		}

		button:hover{

			border:1px solid rgb(168,163,218);
			color:white;
			background-color: rgb(168,163,218);
			cursor:pointer;
			

		}



	




	</style>
</head>
<body>
	
	<main>

	<header>Transferência</header>
	<form method='POST'>	
		
		<label for='link'>Url da imagem</label>
		<input type="text" id='link' name='link'>
		<button>Download</button>

	</form>
	

	</main>


</body>
</html>