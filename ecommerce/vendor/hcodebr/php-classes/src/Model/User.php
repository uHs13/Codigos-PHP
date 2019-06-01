<?php  

namespace Hcode\Model;

use Hcode\DB\Sql;
use Hcode\Model;

class User extends Model
{


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

		$data = $results[0];

		if(password_verify($password, $data['despassword']) === true){

			$user = new User();
			$user->setidUser($data['iduser']);

		} else {

			 throw new \Exception("Usuário inexistente ou senha inválida", 1);

		}

	}





}

?>