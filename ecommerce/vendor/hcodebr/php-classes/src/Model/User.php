<?php  
namespace Hcode\Model;


use Hcode\DB\Sql;
use Hcode\Model;
use Hcode\Mailer;
use Hcode\Utils\Utils;


class User extends Model
{

	const SESSION = "User";

	public static function getFromSession()
	{

		$user = new User();

		if (

			isset($_SESSION[User::SESSION])
			&&
			//se for vazio, no cast pra inteiro vira 0
			(int)$_SESSION[User::SESSION]["iduser"] > 0

		) {

			$user->setData($_SESSION[User::SESSION]);

		}

		return $user;

	}
	//.getFromSession

	public static function checkLogin($inadmin = true)
	{

		if (

			!isset($_SESSION[User::SESSION])//se a sessão não estiver definida
			||
			!($_SESSION[User::SESSION])// se a sessão estiver definida mas estiver vazia
			||
			!(int)$_SESSION[User::SESSION]['iduser'] > 0 // se estiver vazio e for feito o cast vira 0, logo só é um usuário válido se o iduser for > 0

		) {

			return false;

		} else {

			if ($inadmin === true && (bool)$_SESSION[User::SESSION]["inadmin"] === true) {

				return true;

			} elseif ($inadmin === false) {

				return true;

			} else {

				return false;

			}

		}
		
	}

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

		if(password_verify($password, $data['despassword']) === true) {//caso o que foi digitado coincida com o que está salvo no banco

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

	}
	//.login

	public static function verifyLogin($inadmin = true, $location = 1, $redirect = true) // método para verificar a validade da sessão
	{

		$location = ((int)$location === 1) ? '/PHP/ecommerce/admin/login' : '/PHP/ecommerce/login';

		if(!User::checkLogin($inadmin)){

			if ($redirect) {

				header("Location: $location");
				exit;

			}

			return false;

		}

		return true;

	}
	//.verifyLogin

	public static function logout()//métooo para encerrar a sessão do usuário
	{

		$_SESSION[User::SESSION] = NULL;

	}
	//.logout

	public static function listAll()//método que retorna todos os usuários cadastrados no banco
	{

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_users u INNER JOIN tb_persons p ON u.idperson = p.idperson ORDER BY p.desperson");

	}// listAll()

	public function save()//método para salvar um usuário no banco
	{

		$sql = new Sql();

		$results = $sql->select('
			CALL sp_users_save(
			:pdesperson,
			:pdeslogin,
			:pdespassword,
			:pdesemail,
			:pnrphone,
			:pinadmin
			)
			',
			array(

				':pdesperson'=>$this->getdesperson(),
				':pdeslogin'=>$this->getdeslogin(),
				':pdespassword'=>Utils::encrypt($this->getdespassword()),
				':pdesemail'=>$this->getdesemail(),
				':pnrphone'=>$this->getnrphone(),
				':pinadmin'=>$this->getinadmin()

			));

		// var_dump($results);
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
			':pdespassword'=>Utils::encrypt($this->getdespassword()),
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
<<<<<<< HEAD
		$results = $sql->query("CALL sp_users_delete(:p_iduser)",array(
=======
		$sql->query("CALL sp_users_delete(:p_iduser)",array(
>>>>>>> 187a3166fe5429a77f620e146541a4d547135de3

			":p_iduser"=>$this->getiduser()

		));

	}

	public static function getForgot($email, $inadmin = true)
	{

		$sql = new Sql();

		$results = $sql->select("
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

			$data = $results[0];

			$results2 = $sql->select('CALL sp_userspasswordsrecoveries_create(:piduser, :pdesip)', array(

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
				

				if ($inadmin === true) {

					$link = "http://localhost/PHP/ecommerce/admin/forgot/reset?code=$code";	

				} else {

					$link = "http://localhost/PHP/ecommerce/forgot/reset?code=$code";

				}
				

				$mailer = new Mailer(
					$data['desemail'], //email destinatário
					$data['desperson'], //nome destinatário
					"The GS - Password Recovery", // assunto
                    "forgot", //nome do template
                    array(

                    	'name'=>$data['desperson'],
                    	'link'=>$link

                    ) //variáveis que vão no template
                );

				$mailer->send();

				return $data;

			}

		}

	}// getForgot()

	public static function validForgotDecrypt($code)
	{

		$idrecovery = openssl_decrypt(
			base64_decode($code), 
			'AES-128-CBC', 
			SECRET,
			0,
			SECRET_IV
		);

		$sql = new Sql();

		$results = $sql->select("

			SELECT * FROM tb_userspasswordsrecoveries pr
			INNER JOIN tb_users u using (iduser)
			INNER JOIN tb_persons p using (idperson)
			WHERE pr.idrecovery = :idrecovery AND 
			pr.dtrecovery is NULL AND
			date_add(pr.dtregister, INTERVAL 1 hour) >= NOW();

			", array(
				":idrecovery"=>$idrecovery
			));

		if (count($results) === 0) {

			throw new \Exception("Não foi possível recuperar a senha", 1);
			

		} else {

			return $results[0];

		}

	}//validForgotDecrypt

	public static function setForgotUsed($idrecovery)
	{

		$sql = new Sql();

		$sql->query("

			UPDATE tb_userspasswordsrecoveries 
			SET dtrecovery = NOW()
			WHERE idrecovery = :idrecovery;

			", array(
				":idrecovery" => $idrecovery
			));

	}//setForgotUsed

	public function setPassword($password)
	{

		$sql = new Sql();

		$sql->query("

			UPDATE tb_users 
			SET despassword = :password
			WHERE iduser = :iduser;

			", array(

				":password" => $password,
				":iduser" => $this->getiduser()

			));

	}
	//.setPassword

	public function verifyAttributes()
	{

		$array = [
			"desperson",
			"deslogin",
			"despassword",
			"desemail",
			"nrphone"
		];

		foreach ($array as $value) {

			if (strlen($this->getValues()[$value]) <= 0 || $this->getValues()[$value] === 0){

				return false;

				Utils::setSessionMsgError("Informe seus dados corretamente");

			};

		}

		return true;

	}
	//.verifyAttributes

	public function checkLoginExists()
	{

		$sql = new Sql();

		$results = $sql->select("SELECT iduser FROM tb_users WHERE deslogin = :login", [

			":login" => $this->getdeslogin()

		]);

		if (count($results) > 0) {

			Utils::setSessionMsgError("E-mail inválido");

		}

		return (count($results) > 0);

	}
	//.checkLoginExists

}//User

?>