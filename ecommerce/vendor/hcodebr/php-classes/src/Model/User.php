<?php  

namespace Hcode\Model;

use Hcode\DB\Sql;
use Hcode\Model;

class User extends Model
{

	const SESSION = "User";

	public static function login($login, $password)
	{

		$sql = new Sql();

		//seleciona as tuplas do banco que têm o login igual ao passado como parâmetro
		$results = $sql->select('SELECT * FROM TB_USERS WHERE DESLOGIN = :LOG',	array(
			':LOG'=>$login
		));

		//caso não tenha nenhum uusário registrado com esse login
		if(count($results) === 0) throw new \Exception("Usuário inexistente ou senha inválida", 1);
		//é necessário colocar \Exception para indicar ao PHP que essa classe está no namespace principal do próprio PHP

		//atribui a tupla retornada pelo banco
		$data = $results[0];

		if(password_verify($password, $data['despassword']) === true){//caso o que foi digitado coincida com o que está salvo no banco

			$user = new User();

			//setData é um método da classe Model
			$user->setData($data);

			//criando sessão para o login realmente funcionar
			$_SESSION[User::SESSION] = $user->getValues();

			return $user;

		} else {

			 throw new \Exception("Usuário inexistente ou senha inválida", 1);
			 //é necessário colocar \Exception para indicar ao PHP que essa classe está no namespace principal do próprio PHP


		}

	}// login()

	public static function verifyLogin($inadmin = true) // método para verificar a validade da sessão
	{

		if(

			!isset($_SESSION[User::SESSION])//se a sessão não estiver definida
			||
			!($_SESSION[User::SESSION])// se a sessão estiver definida mas estiver vazia
			||
			!(int)$_SESSION[User::SESSION]['iduser'] > 0 // se estiver vazio e for feito o cast vira 0, logo só é um usuário válido se o iduser for > 0
			||
			(bool)$_SESSION[User::SESSION]['inadmin'] !== $inadmin //se não tiver permissão de acesso a página de adminstração

		){

			header('Location: admin/login');
			exit;

		}

	}// verifyLogin()

	public static function logout()
	{

		$_SESSION[User::SESSION] = NULL;

	}



}

?>