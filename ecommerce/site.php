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

	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	$category = new Category();

	$category->get((int)$idcategory);

	$pagination = $category->getProductPage($page);

	$pages = [];

	for ($i=1; $i <= (int)$pagination["pages"]; $i++) { 

		array_push($pages, [

			"link" => "../category/".$category->getidcategory()."?page=$i",
			"page" => $i

		]);

	}

	$page = new Page();

	$page->setTpl('category', [

		'category' => $category->getValues(),
		'products' => $pagination["data"],
		'pages' => $pages

	]);

});

$app->get("/products/:desurl", function ($desurl) {

	$product = new Products();

	$product->getFromURL((String)$desurl);

	// var_dump($product->getCategories());
	// exit;

	$page = new Page();

	$page->setTpl("product-detail", array(

		"product" => $product->getValues(),
		"categories" => $product->getCategories()

	));

});
