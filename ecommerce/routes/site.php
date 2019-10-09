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

	$cart = Cart::getFromSession();

	$address = new Address();

	$page = new Page();

	$page->setTpl("checkout", [

		"cart" => $cart->getValues(),
		"address" => $address->getValues()

	]);

});

$app->get("/login", function () {

	User::logout();

	$page = new Page();

	$page->setTpl("login", [

		"error" => Utils::getSessionMsgError()

	]);

});

$app->post("/login", function () {

	$_POST = Utils::safeEntry($_POST);

	try {

		User::login($_POST["login"], $_POST["password"]);

		Utils::redirect("/PHP/ecommerce/checkout");

	} catch (Exception $e) {

		Utils::setSessionMsgError($e->getMessage());

		Utils::redirect("/PHP/ecommerce/login");

	}

});

$app->get("/logout", function () {

	User::logout();

	Utils::redirect("/PHP/ecommerce/");

});

$app->post("/register", function() {

	Utils::safeEntry($_POST);

	$user = new User();

	$user->setData([

		"desperson" => $_POST["name"],
		"deslogin" => $_POST["email"],
		"despassword" => $_POST["password"],
		"desemail" => $_POST["email"],
		"nrphone" => $_POST["phone"],
		"inadmin" => 0

	]);

	if ($user->verifyAttributes() && !$user->checkLoginExists()) {

		$user->save();

		$user->login($_POST["email"], $_POST["password"]);

		Utils::redirect("/PHP/ecommerce/checkout");

	} else {

		Utils::redirect("/PHP/ecommerce/login");

	}

});

$app->get('/forgot', function () {// Forgot about dre. Rota para tela de recuperação de senha
 
	$page = new Page();

	$page->setTpl("forgot");

});

$app->post('/forgot', function () {

	$user = User::getForgot($_POST['email'], false);

	Utils::redirect("/PHP/ecommerce/forgot/sent");

});

$app->get('/forgot/sent', function () {

	$page = new Page();

	$page->setTpl("forgot-sent");

});

$app->get('/forgot/reset', function () {

	$user = User::validForgotDecrypt($_GET['code']);

	$page = new Page();

	$page->setTpl("forgot-reset", array(
		
		"name"=>$user['desperson'],
		"code"=>$_GET['code']

	));

});

$app->post('/forgot/reset', function () {

	$forgot = User::validForgotDecrypt($_POST['code']);

	User::setForgotUsed($forgot['idrecovery']);

	$user = new User();

	$user->get((int)$forgot['iduser']);

	$password = password_hash($_POST["password"], PASSWORD_DEFAULT, [

 		"cost"=>12

 	]);

	$user->setPassword($password);

	$page = new Page();

	$page->setTpl("forgot-reset-success");

});
