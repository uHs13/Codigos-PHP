<?php

use Hcode\Page;
use Hcode\Model\Cart;
use Hcode\Model\Products;
use Hcode\Model\Category;
use Hcode\Utils\Utils;

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

	// var_dump($desurl);
	// exit;

	$product->getFromURL((String)$desurl);

	

	$page = new Page();

	$page->setTpl("product-detail", array(

		"product" => $product->getValues(),
		"categories" => $product->getCategories()

	));

});

$app->get("/cart", function () {

	$cart = Cart::getFromSession();

	$page = new Page();

	$page->setTpl("cart", [

		"cart" => $cart->getValues(),
		"products" => $cart->getProducts()

	]);

});

$app->get("/cart/:idproduct/add", function ($idproduct) {

	$product = new Products();

	$product->get((int)$idproduct);

	$cart = Cart::getFromSession();

	$qtd = (isset($_GET["qtd"])) ? (int)$_GET["qtd"] : 1;

	for ($i = 0; $i < $qtd; $i++) {

		$cart->addProduct($product);

	}

	header("Location: /PHP/ecommerce/cart");
	exit;

});

$app->get("/cart/:idproduct/minus", function ($idproduct) {

	$product = new Products();

	$product->get((int)$idproduct);

	$cart = Cart::getFromSession();

	$cart->removeProduct($product, false);

	header("Location: /PHP/ecommerce/cart");
	exit;

});

$app->get("/cart/:idproduct/remove", function ($idproduct) {

	$product = new Products();

	$product->get((int)$idproduct);

	$cart = Cart::getFromSession();

	$cart->removeProduct($product, true);

	header("Location: /PHP/ecommerce/cart");
	exit;

});

$app->post("/cart/freight", function () {

	$cart = Cart::getFromSession();

	Utils::safeEntry($_POST);

	$cart->setFreight($_POST["zipcode"]);

	header("Location: /PHP/ecommerce/cart");
	exit;

});

