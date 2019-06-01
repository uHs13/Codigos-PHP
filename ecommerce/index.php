<?php 

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


$app->post('/admin/login', function(){

	User::login($_POST['login'], $_POST['password']);

	header("Location: /admin");

	exit;

});

$app->run();

?>