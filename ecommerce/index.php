<?php 

require_once("vendor/autoload.php");//require do autoloader do composer

use \Slim\Slim; 
use Hcode\Page;

$app = new Slim();//instancia uma nova aplicação slim

$app->config('debug', true);//configurando como true mostra o log completo do erro

$app->get('/', function() {
   
   	$page = new Page();

   	$page->setTpl("index");
   
});

$app->run();

 ?>