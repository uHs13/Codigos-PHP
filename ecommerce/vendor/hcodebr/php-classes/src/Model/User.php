<?php  

namespace Hcode\Model;

use Hcode\DB\Sql;
use Hcode\Model;

class User extends Model
{

	const SESSION = "User";
	define('SECRET', pack('a16','encryptpass'));
	define('SECRET_IV', pack('a16','encryptpass'));

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

	public static function logout()//métooo para encerrar a sessão do usuário
	{

		$_SESSION[User::SESSION] = NULL;

	}// logout()

	public static function listAll()//método que retorna todos os usuários cadastrados no banco
	{

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_users u INNER JOIN tb_persons p ON u.idperson = p.idperson ORDER BY p.desperson");

	}// listAll()

	public function save()//método para salvar um usuário no banco
	{

		$sql = new Sql();

		$results = $sql->select('CALL sp_users_save(:pdesperson,:pdeslogin,:pdespassword,:pdesemail,:pnrphone,:pinadmin)',array(

			':pdesperson'=>$this->getdesperson(),
			':pdeslogin'=>$this->getdeslogin(),
			':pdespassword'=>$this->getdespassword(),
			':pdesemail'=>$this->getdesemail(),
			':pnrphone'=>$this->getnrphone(),
			':pinadmin'=>$this->getinadmin()

		));

		$this->setData($results[0]);

	}// save()

	public function get($iduser)
	{

		$sql = new Sql();

		$results = $sql->select('SELECT * FROM tb_users u INNER JOIN tb_persons p ON u.idperson = p.idperson WHERE u.iduser = :iduser', array(

			':iduser'=>$iduser
		));

		// var_dump($results);

		$this->setData($results[0]);

	}// get()

	public function update()
	{

		$sql = new Sql();

		$results = $sql->select('CALL sp_usersupdate_save(:piduser,:pdesperson,:pdeslogin,:pdespassword,:pdesemail,:pnrphone,:pinadmin)',array(
			':piduser'=>$this->getiduser(),
			':pdesperson'=>$this->getdesperson(),
			':pdeslogin'=>$this->getdeslogin(),
			':pdespassword'=>$this->getdespassword(),
			':pdesemail'=>$this->getdesemail(),
			':pnrphone'=>$this->getnrphone(),
			':pinadmin'=>$this->getinadmin()

		));

		$this->setData($results[0]);

	}// update()

	public function delete()
	{

		$sql = new Sql();

		//usando o método query porque não é necessário retornar nada
		$sql->query("CALL sp_users_delete(:p_iduser)",array(

			":p_iduser"=>$this->getiduser()

		));

	}

	public static function getForgot($email)
	{

		$sql = new Sql();

		$result = $sql->select("
			SELECT p.idperson,
			p.desperson,
			p.desemail,
			p.nrphone,
			p.dtregister,
			u.iduser,
			u.deslogin,
			u.despassword,
			u.inadmin,
			u.dtregister
			from tb_persons p
			inner join tb_users u 
			on p.idperson = u.idperson 
			where p.desemail = :email;
		", array(
			":email"=>$email
		));


		if (count($results) === 0) {
			
			throw new \Exception("Não foi possível recuperar a senha", 1);

		} else {

			$data = results[0];

			$results2 = $sql->select('CALL sp_userspasswordsrecoveries(:piduser, :pdesip)', array(

				":piduser"=>$data['iduser'],
				":pdesip"=>$_SERVER['REMOTE_ADDR']

			));

			if (count($results2) === 0) {

				throw new \Exception("Não foi possível recuperar a senha", 1);
				
			} else {

				$dataRecoveries = $results2[0];

				$code = base64_encode(openssl_encrypt(
					$dataRecoveries['idrecovery'], 
					'AES-128-CBC', 
					SECRET, 
					0, 
					SECRET_IV
				));



			}

		}

	}// getForgot()

}

?>