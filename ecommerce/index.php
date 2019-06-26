<?php 
session_start();

require_once("vendor/autoload.php");//require do autoloader do composer
require_once("vendor/secrets.php");

use \Slim\Slim; 

$app = new Slim();//instancia uma nova aplicação slim

$app->config('debug', true);//configurando como true mostra o log completo do erro

$app->notfound(function () {// mensagem caso a rota não exista

	echo json_encode(array('Info'=>'Page not found'));

});

require_once("site.php");
require_once("admin.php");
require_once("adminCategory.php");
require_once("adminUser.php");
require_once("adminProduct.php");

$app->run();

?>