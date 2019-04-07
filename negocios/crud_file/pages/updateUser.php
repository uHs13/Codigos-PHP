<!DOCTYPE html>
<html>
<head>
	<title>Update user</title>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Raleway:400,500" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/updateUser.css">
</head>

<body>

	<main>

		<form method="POST" class='search-form'>
		
			<input type="text" name="search" placeholder='E-mail'>
			<button class='btn-search'>Pesquisar</button>


		</form>

		<a href="../index.html">Voltar</a>

	</main>

</body>

</html>
<?php 

require_once "../config/Autoloader.php";
Autoloader::register();

if($_SERVER["REQUEST_METHOD"] === "POST"){//Se os dados vêm do formulário de pesquisa de usuário

	if(isset($_POST['search'] ) && $_POST['search'] != " " ){//verificação padrão dos dados recebidos via POST

		$valid = false;//variável de controle 

		$arq = new Arquivo('../file/users.csv','r+');
							//Já sabemos o propósito dessas duas linhas
		$users = $arq->readCsv();


		$em = $_POST['search']."\r\n";//temos que concatenar com "\r\n" porque no método write() da classe arquivo o último valor escrito em uma linha do arquivo tem o seu valor concatenado a uma quebra de linha ( "\r\n" ). "nome" != "nome\r\n". E não podemos tirar esse recurso porque é ele que mantem a organização do arquivo, cada registro em uma linha

		//users é o array que recebeu os dados de todas as linhas do arquivo
		foreach ($users as $user) {//foreach para percorrer cada linha do arquivo
			
			if($em == $user['email'."\r\n"]){/*como explicado na declaração da variável $em, a última linha recebe um "\r\n" junto a seu valor, isso também é valido para a primeira linha do arquivo, os headers. O valor do último header, nesse caso email, tem uma quebra de linha, logo o vetor vem com a seguinte estrutura chave valor para cada email:
			$user['email\r\n'] => 'valor' . Por conta disso temos que adaptar a comparação para acontecer da maneira correta.   

				O if compara se a linha que está sendo lida no foreach é a linha com os dados correspondentes aos passados no formulário de pesquisa. Podemos pesquisar pelo email sem problemas porque não existem dois emails iguais, isso é uma regra real dos emails.
			*/

				$name = $user['name'];//se for a linha com os dados corretos pegamos o nome, o email já temos, ele veio no POST.

				$html = "<form method='GET' class='form-edit'>";

				$html.="<input type='text' name='name' value='$name' class='inpt-edit'>";//exibimos os dados do usuário em dois inputs para que possam ter seus valores editados
				$html.="<input type='text' name='email' value='$em' class='inpt-edit'>";
				$html.="<button class='btn-save'>Salvar</button>";//após editar o usuário clica em salvar e os dados são enviados via GET para a mesma página ( assim como o POST, essa observação é só pra deixar claro mesmo )

				$html.="</form>";

				echo $html;

				$valid = true;

				
				break;


			}
			
			
		}


		if(!$valid){// se a vairável de controle não teve seu valor alterado, o email pesquisado não existe, logo o usuário não existe (usuário 1x1 email)

			echo "<script>confirm('Usuário não existe');</script>";

		}


	}




} else if($_SERVER["REQUEST_METHOD"] === "GET"){// se vem do formulário onde salvamos os dados. Fizemos um else if porque só podemos cair em uma das condições.

	if(isset($_GET['name']) && $_GET['name']!=" "){// verificação padrão dos dados recebidos do array super global

		if(isset($_GET['email']) && $_GET['email']!= " "){

			$arq = new Arquivo('../file/users.csv','r+');
								//instanciamos um objeto para ler todos os dados existentes no arquivo de usuários e salvar em um array de arrays
			$users = $arq->readCsv();


			$arq = new Arquivo('../file/users.csv','w+');// logo depois abrimos o mesmo arquivo para sobrescrever os dados

			$arq->write("name;email");// colocamos os headers

			$em = $_GET['email']."\r\n";

			foreach ($users as $user) {//passamos em cada um dos arrays do array users

				if($em == $user['email'."\r\n"]){//se for a linha com o usuário que foi editado

					$user = new User($_GET['name'],$_GET['email']);// instanciamos um Usuário com os valores recebidos via GET, os dados editados 

					$arq->write($user);// escrevemos no arquivo

				} else {// se for outra linha

					$user = new User($user['name'],$user['email'."\r\n"]);// se não for a linha do usuário editado podemos reescrever normalmente

					$arq->write($user);

				}
		
				
			}//fim foreach

			echo "<script>confirm('Usuario editado com sucesso')</script>";

		}//fim if($_GET['email'] != null && $_GET['email']!= " ")

	}//fim if($_GET['name']!= null && $_GET['name']!=" ")
	
}//fim  if($_SERVER["REQUEST_METHOD"] === "GET")


?>