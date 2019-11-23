<?php
use Hcode\Page;
use Hcode\Model\User;
use Hcode\Utils\Utils;

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

$app->get("/profile", function () {

	User::verifyLogin(false, 2);

	$user = User::getFromSession();

	$page = new Page();

	$page->setTpl("profile", [

		"user" => $user->getValues(),
		"profileMsg" => "",
		"profileError" => ""

	]);

});

$app->post("/profile", function () {

	User::verifyLogin(false, 2);

	Utils::safeEntry($_POST);

	$userId = User::getFromSession()->getidperson();

	$user = new User();

	$user->get($userId);

	$user->setData(array_replace($user->getValues(), $_POST));

	$user->update();

	Utils::redirect("/PHP/ecommerce/profile");

});