<!DOCTYPE html>
<html>
<head>
	<title>Delete User</title>
	<link href="https://fonts.googleapis.com/css?family=Raleway:400,500" rel="stylesheet">
	<link rel="stylesheet" href="../css/deleteUser.css">
</head>
<body>

	<main>
		
		<section>

			<h3>Deletar usuário</h3>

		</section>


		<form method='POST'>
			
			<input type="text" name="search"  placeholder="E-mail">
			<button class='btn-search'>Pesquisar</button>

		</form>


		<?php 

		require_once '../config/Autoloader.php';
		Autoloader::register();

		if( $_SERVER['REQUEST_METHOD'] === 'POST' ){

			if(isset($_POST['search']) && $_POST['search'] != " " ){

				$valid = false;

				$file = new Arquivo('../file/users.csv','r+');

				$users = $file->readCsv();

				$em = $_POST['search']."\r\n";

				foreach ($users as $user) {

					if($em == $user['email'."\r\n"]){

						$name = $user['name'];
						
						$html = "<form method='GET' class='form-edit'>";

						$html.="<input type='text' name='name' value='$name' class='inpt-edit'>";//exibimos os dados do usuário em dois inputs para que possam ter seus valores editados
						$html.="<input type='text' name='email' value='$em' class='inpt-edit'>";
						$html.="<button class='btn-delete'>Deletar</button>";//após editar o usuário clica em salvar e os dados são enviados via GET para a mesma página ( assim como o POST, essa observação é só pra deixar claro mesmo )

						$html.="</form>";

						echo $html;

						$valid = true;

						
						break;

					}

				}

				if(!$valid){

					echo "<script>confirm('Usuário não existe');</script>";

				}

			} 

		} else if ($_SERVER['REQUEST_METHOD'] === 'GET'){

			if(isset($_GET['name']) && $_GET['name']!= " " ){

				if(isset($_GET['email']) && $_GET['email']!= " " ){

					
					$arq = new Arquivo('../file/users.csv','r+');
								//instanciamos um objeto para ler todos os dados existentes no arquivo de usuários e salvar em um array de arrays
					$users = $arq->readCsv();


					$arq = new Arquivo('../file/users.csv','w+');// logo depois abrimos o mesmo arquivo para sobrescrever os dados

					$arq->write("name;email");// colocamos os headers

					$em = $_GET['email']."\r\n";

					foreach ($users as $user) {//passamos em cada um dos arrays do array users

						if(!($em == $user['email'."\r\n"])){//se for a linha com o usuário que foi editado
							$user = new User($user['name'],$user['email'."\r\n"]);// se não for a linha do usuário editado podemos reescrever normalmente

							$arq->write($user);

						}
						
					}//fim foreach

					echo "<script>confirm('Usuario deletado com sucesso')</script>";


				}


			}

		}


		?>

		<a href="../">Voltar</a>

	</main>

</body>
</html>
<body>

	