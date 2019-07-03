<?php

use Hcode\Page;
use Hcode\Model\Products;
use Hcode\Model\Category;


$app->get('/', function() {//ROTA DA PÁGINA PRINCIPAL
   	
	$product = Products::checkList(Products::listAll());
	
	$page = new Page();

   	$page->setTpl("index", [
   		'products' => $product
   	]);
   
});


$app->get("/category/:idcategory", function ($idcategory) {

	$category = new Category();

	$category->get((int)$idcategory);

	$page = new Page();

	$page->setTpl('category', [

		'category' => $category->getValues(),
		'products' => []

	]);

});
