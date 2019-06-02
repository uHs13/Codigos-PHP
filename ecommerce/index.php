<?php 
session_start();
require_once("vendor/autoload.php");//require do autoloader do composer

use \Slim\Slim; 
use Hcode\Page;
use Hcode\PageAdmin;
use Hcode\Model\User;

$app = new Slim();//instancia uma nova aplicação slim

$app->config('debug', true);//configurando como true mostra o log completo do erro

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


$app->post('/admin/login', function(){// verifica o login e inicia a sessão

	User::login($_POST['login'], $_POST['password']);

	header("Location: ../admin");

	exit;

});

$app->get('/admin/logout',function(){//rota para encerrar a sessão

	User::logout();

	header('Location: login');
	exit;

});

$app->run();

?>