<?php

use Hcode\Page;
use Hcode\Model\Cart;
use Hcode\Model\User;
use Hcode\Model\Products;
use Hcode\Model\Category;
use Hcode\Model\Address;
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
		"products" => $cart->getProducts(),
		"error" => Utils::getSessionMsgError()

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

	$cart->getProductsCount();

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

$app->get("/checkout", function () {

	User::verifyLogin(false, 2);

	//shipping_method é um valor em array retornado do formulário que não tem utilidade para a aplicação. Com ele definido a safeEnetry retorna um erro
	if (isset($_GET["shipping_method"])) unset($_GET["shipping_method"]);

	$_GET = Utils::safeEntry($_GET);

	$address = new Address();

	$cart = Cart::getFromSession();

	if (isset($_GET["zipcode"])) {

		//recupera as informações do endereço a partir do cep informado no carrinho
		$address->setAddress($_GET["zipcode"]);

		//sobreescreve o endereço do carrinho
		$cart->setdeszipcode($_GET["zipcode"]);

		$cart->save();

		//atualiza o valor do frete
		$cart->calculateTotal();

	}

	$page = new Page();

	$page->setTpl("checkout", [

		"cart" => $cart->getValues(),
		"address" => $address->getValues(),
		"products" => $cart->getProducts(),
		"error" => Utils::getSessionMsgError()

	]);

});

$app->post("/checkout", function () {

	User::verifyLogin(false, 2);

	if (isset($_POST["shipping_method"])) {

		unset($_POST["shipping_method"]);

	}

	if ($_POST["woocommerce_checkout_place_order"]) {

		unset($_POST["woocommerce_checkout_place_order"]);

	}

	$user = User::getFromSession();

	$_POST["idperson"] = $user->getiduser();

	$_POST = Utils::safeEntry($_POST);

	foreach ($_POST as $key => $value) {

		if (strlen($value) === 0) {

			Utils::setSessionMsgError("Erro nos dados informados");

			Utils::redirect("/PHP/ecommerce/checkout?zipcode=3234030");

		}

	}

	exit;

	$address = new Address();

	$address->setData($_POST);

	$address->save();

});
