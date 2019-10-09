<?php

use Hcode\PageAdmin;
use Hcode\Model\User;

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
