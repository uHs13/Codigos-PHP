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

			<label for='cpf'><span>CPF</span></label>
			<input type="text" name="cpf" id="cpf" placeholder="Apenas Números">

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

if($_SERVER["REQUEST_METHOD"] === "POST"){

	if($_POST['name'] != null && $_POST['name'] != " "){

		if($_POST['email'] != null && $_POST['email'] != " "){

			if($_POST['cpf'] != null && $_POST['cpf'] != " "){

				$user = new User($_POST['name'],$_POST['email'],$_POST['cpf']);

				$path = '../file/users.csv';


				if(!file_exists($path)){

	

					$file = new Arquivo($path,'a+');
					$file->write('name;email;cpf');

				}

				$file = new Arquivo($path,'a+');

				$file->write($user);

				echo "
					<script>

						confirm('Cadastro realizado com sucesso');

					</script>


				";

			}

		}

	}

}



unset($_POST['name']);


?>