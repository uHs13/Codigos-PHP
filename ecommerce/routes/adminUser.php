<?php  

use Hcode\PageAdmin;
use Hcode\Model\User;
use Hcode\Utils\Utils;

$app->get("/admin/users", function () {//Rota para listar todos os usuários

	User::verifyLogin();

	$search = (isset($_GET['search'])) ? Utils::safeEntry($_GET['search']) : '';

	$page = (isset($_GET['page'])) ? Utils::safeEntry($_GET['page']) : 1;

	if ($search != '') {

			$pagination = User::getUserPageSearch($search, $page);

	} else {

		$pagination = User::getUserPage($page);

	}

	$pages = [];

	for ($i = 0; $i < $pagination['pages']; $i++) {

		array_push($pages, [

			'text' => $i + 1,
			'href' => '/PHP/ecommerce/admin/users?'. http_build_query([
				'page' => $i + 1,
				'search' => $search
			])

		]);

	}

	$page = new PageAdmin();

	$page->setTpl('users',array(
		'users' => $pagination['data'],
		'search' => $search,
		'pages' => $pages,
	));
 
});


$app->get("/admin/users/create", function () {//Rota para criar um novo usuário

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("users-create");

});


$app->get('/admin/users/:iduser/delete', function ($iduser) {//Rota para deletar

	User::verifyLogin();

	$user = new User();

	$user->get((int)$iduser);

	$user->delete();

	header("Location: /PHP/ecommerce/admin/users ");
	exit;

});


$app->get("/admin/users/:iduser", function ($iduser) {//Rota para atualizar um usuário

	User::verifyLogin();
	
	$user = new User();

	$user->get((int)$iduser);

	// var_dump($user);

	$page = new PageAdmin();

	$page->setTpl("users-update", array(

		'user'=>$user->getValues() // método da classe Model

	));

});


$app->post('/admin/users/create', function () {//Rota para salvar um usuário no banco

	User::verifyLogin();

	$user = new User();


	/* PROCEDIMENTO PROVISÓRIO PARA ENCRIPTAR A SENHA ANTES DE SALVAR */
	$_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1 : 0;

 	$_POST['despassword'] = password_hash($_POST["despassword"], PASSWORD_DEFAULT, [

 		"cost"=>12

 	]);

	$user->setData($_POST);

	$user->save();

	header("Location: ../users");

	exit;
	
});


$app->post('/admin/users/:iduser', function ($iduser) {//Rota para salvar alterações em um usuário no banco

	User::verifyLogin();

	$user = new User();

	$user->get((int)$iduser);

	$user->setData($_POST);

	// var_dump($user);
	$user->update();

	header("Location: ../users");
	exit;

});
