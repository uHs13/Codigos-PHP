<?php

use Hcode\Page;
use Hcode\Model\Products;


$app->get('/', function() {//ROTA DA PÁGINA PRINCIPAL
   	
	$product = Products::checkList(Products::listAll());
	
	$page = new Page();

   	$page->setTpl("index", [
   		'products' => $product
   	]);
   
});


?>