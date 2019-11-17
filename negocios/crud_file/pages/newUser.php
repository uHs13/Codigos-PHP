<!DOCTYPE html>
<html>
<head>
	<title>New user</title>
	<link href="https://fonts.googleapis.com/css?family=Raleway:400,500" rel="stylesheet">
	<link rel='stylesheet' href='../css/newUser.css'>
</head>
<body>

	<main>

		<form method="POST">

			<section class='form-title'>
				<h3>Novo Usuário</h3>
			</section>

			<label for='name'><span>Nome</span></label>
			<input type="text" name="name" id="name" >

			<label for='email'><span>Email</span></label>
			<input type="email" name="email" id="email" >

			

			<button>Cadastrar</button>

			

		</form>

		<section class='option-box'>
			
			<a href="../index.html">Voltar</a>

		</section>


	</main>

</body>
</html>

<?php 

include_once "../config/Autoloader.php";
Autoloader::register();

if($_SERVER["REQUEST_METHOD"] === "POST"){//Se o tipo de requisição de dados feita foi POST, ou seja, o formulário de criação de usuário, então podemos proceder.

	if(isset($_POST['name']) && $_POST['name'] != " "){//verificamos se as chaves do array super global $_POST estão definidas e com valores 

		if(isset($_POST['email']) && $_POST['email'] != " "){

			

				$user = new User($_POST['name'],$_POST['email']);//Instanciamos um novo User com os dados para ficar mais simples gravar as informações no nosso arquivo

				$path = '../file/users.csv';//guardamos o caminho do arquivo em uma variável


				if(!file_exists($path)){//caso esse diretório não exista ele é criado

	
					$file = new Arquivo($path,'a+');
					$file->write('name;email');

				}

				$file = new Arquivo($path,'a+');//inicializamos um objeto Arquivo, lembrando que Arquivo é a nossa classe manipuladora

				$file->write($user);// Escrevemos o usuário no arquivo. Podemos fazer isso por conta do método mágico __toString() da classe User

				echo "
					<script>

						confirm('Cadastro realizado com sucesso');

					</script>


				";

			

		}

	}

}





?>