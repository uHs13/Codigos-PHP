<?php 
session_start();

require_once("vendor/autoload.php");//require do autoloader do composer
require_once("vendor/secrets.php");

use \Slim\Slim; 
use Hcode\Page;
use Hcode\PageAdmin;
use Hcode\Model\User;
use Hcode\Mailer;


$app = new Slim();//instancia uma nova aplicação slim

$app->config('debug', true);//configurando como true mostra o log completo do erro

$app->notfound(function () {// mensagem caso a rota não exista

	echo json_encode(array('Info'=>'Page not found'));

});

$app->get('/', function() {//ROTA DA PÁGINA PRINCIPAL
   
   	$page = new Page();

   	$page->setTpl("index");
   
});


$app->get('/admin', function() {//ROTA DA PÁGINA DE ADMINISTRAÇÃO
   	
	//antes de redirecionar para a página de administração temos que verificar se existe uma sessão válida e com permissão
	User::verifyLogin();

   	$page = new PageAdmin();

   	$page->setTpl("index");
   
});


$app->get('/admin/login', function() {//ROTA DA PÁGINA DE LOGIN DA ADMINISTRAÇÃO

	$page = new PageAdmin([
		
		"header"=>false,
		"footer"=>false

	]);

	$page->setTpl("login");
	
});


$app->post('/admin/login', function () {// verifica o login e inicia a sessão

	User::login($_POST['login'], $_POST['password']);

	header("Location: ../admin");

	exit;

});

$app->get('/admin/logout', function () {//rota para encerrar a sessão

	User::logout();

	header('Location: login');
	exit;

});


$app->get("/admin/users", function () {//Rota para listar todos os usuários

	User::verifyLogin();

	$users = User::listAll();

	$page = new PageAdmin();

	$page->setTpl("users",array(
		'users'=>$users
	));
 
});


$app->get("/admin/users/create", function () {//Rota para criar um novo usuário

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("users-create");

});


$app->get('/admin/users/:iduser/delete', function ($iduser) {//Rota para deletar

	User::verifyLogin();

	$user = new User();

	$user->get((int)$iduser);

	$user->delete();

	header("Location: /PHP/ecommerce/admin/users ");
	exit;

});


$app->get("/admin/users/:iduser", function ($iduser) {//Rota para atualizar um usuário

	User::verifyLogin();
	
	$user = new User();

	$user->get((int)$iduser);

	// var_dump($user);

	$page = new PageAdmin();

	$page->setTpl("users-update", array(

		'user'=>$user->getValues() // método da classe Model

	));

});


$app->post('/admin/users/create', function () {//Rota para salvar um usuário no banco

	User::verifyLogin();

	$user = new User();


	/* PROCEDIMENTO PROVISÓRIO PARA ENCRIPTAR A SENHA ANTES DE SALVAR */
	$_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1 : 0;

 	$_POST['despassword'] = password_hash($_POST["despassword"], PASSWORD_DEFAULT, [

 		"cost"=>12

 	]);

	$user->setData($_POST);

	// var_dump($_POST);

	$user->save();

	header("Location: ../users");

	exit;
	
});


$app->post('/admin/users/:iduser', function ($iduser) {//Rota para salvar alterações em um usuário no banco

	User::verifyLogin();
	
	$user = new User();

	$user->get((int)$iduser);

	$user->setData($_POST);

	// var_dump($user);
	$user->update();

	header("Location: ../users");
	exit;

});


$app->get('/admin/forgot', function () {// Forgot about dre. Rota para tela de recuperação de senha
 
	$page = new PageAdmin([
		
		"header"=>false,
		"footer"=>false

	]);

	$page->setTpl("forgot");

});


$app->post('/admin/forgot', function () {

	$user = User::getForgot($_POST['email']);

	header('Location: forgot/sent');
	exit;
	
});


$app->get('/admin/forgot/sent', function () {

	$page = new PageAdmin([
		
		"header"=>false,
		"footer"=>false

	]);

	$page->setTpl("forgot-sent");

});

$app->get('/admin/forgot/reset', function () {

	$user = User::validForgotDecrypt($_GET['code']);

	$page = new PageAdmin([
		
		"header"=>false,
		"footer"=>false

	]);

	$page->setTpl("forgot-reset", array(
		
		"name"=>$user['desperson'],
		"code"=>$_GET['code']

	));

});

$app->post('/admin/forgot/reset', function () {

	$forgot = User::validForgotDecrypt($_POST['code']);

	User::setForgotUsed($forgot['idrecovery']);

	$user = new User();

	$user->get((int)$forgot['iduser']);

	$password = password_hash($_POST["password"], PASSWORD_DEFAULT, [

 		"cost"=>12

 	]);

	$user->setPassword($password);

	$page = new PageAdmin([
		
		"header"=>false,
		"footer"=>false

	]);

	$page->setTpl("forgot-reset-success");

});

$app->run();

?>