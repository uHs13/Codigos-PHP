<?php  
require_once("vendor/autoload.php");

use \Slim\Slim;
use Produtos\DB\Sql;

$app = new Slim();

$app->config('debug', true);

/* undefined route */
$app->notfound(function () {

	echo json_encode(array('info'=>'page not found'));

});

/* main route */
$app->get('/', function () {

	

});

$app->run();

?>