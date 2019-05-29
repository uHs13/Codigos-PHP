<?php 

require_once("vendor/autoload.php");//require do autoloader do composer

$app = new \Slim\Slim();//instancia uma nova aplicação slim

$app->config('debug', true);//configurando como true mostra o log completo do erro

$app->get('/', function() {
   
   
	
});

$app->run();

 ?>