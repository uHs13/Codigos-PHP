<?php 

require_once 'config/Autoloader.php';

Autoloader::register();


if($_SERVER["REQUEST_METHOD"] === "POST"){
	
	//$_FILES[] é um array superglobal que serve específicamente para tratar  arquivos que foram enviados via upload
	//é onde está o arquivo temporário no servidor
	// $_FILES["fileUpload"] nome do input que recebeu o arquivo

	$upload = new UploadfromInput($_SERVER["REQUEST_METHOD"],$_FILES["fileUpload"],'_upload');
}


?>

<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>
		 <style>
				
				input{
					font-family: 'Raleway';
					color:white;
				}

				

				button{

					width:100px;
					height: 25px;
					border-radius: 3px;
					border: 1px solid black;
					background-color: white;
					font-family: 'Raleway';
					color:black; 

				}

				button:hover{

					border:1px solid white;
					cursor:pointer;

				}

				.tp{

					background-color: #333;
					border-radius: 2px;
					box-shadow: 2px 2px 10px black;
					width:415px;
					line-height: 50px;
					padding-left: 10px;
					
				}

		</style>
		<body>

			<main>
					
				<section class='tp'>
					
				<!-- enctype permite definirmos qual o tipo de informação estamos enviando pelo formulário. Por padrão o formulário envia apenas strings ( O método padrão de envio de dados de um formulário é o GET, esse método é limitado aos caracteres da tabela ASCII ), porém, neste caso estaremos enviando dados binários. Se não colocarmos esse atributo ( o atributo permite usar o padrão  UCS( Universal Multiple-Octet Coded Character Set ) ) o upload não funcionárá, o servidor reveberá apenas o nome do arquivo ao invés de seu conteúdo-->

						<form method='POST' enctype='multipart/form-data'>

						<input type='file' name='fileUpload'>

						<button>upload</button>

						</form>

				</section>




			</main>

		</body>

