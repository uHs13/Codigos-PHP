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

require_once("utils/functions.php");
require_once("routes/site.php");
require_once("routes/siteUser.php");
require_once("routes/siteOrders.php");
require_once("routes/admin.php");
require_once("routes/adminCategory.php");
require_once("routes/adminUser.php");
require_once("routes/adminProduct.php");

$app->run();

?>