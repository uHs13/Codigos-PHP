<?php  

use Hcode\Model\User;
use Hcode\PageAdmin;
use Hcode\Page;
use Hcode\Model\Category;


$app->get('/admin/categories', function () {

	User::verifyLogin();

	$page = new PageAdmin();

	$categories = Category::listAll();

	$page->setTpl("categories", array(
		"categories" => $categories
	));

});


$app->get('/admin/categories/create', function () {

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("categories-create");

});


/* métodos de requisição HTTP: GET, POST, PUT, DELETE */
$app->post('/admin/categories/create', function () {

	User::verifyLogin();

	$category = new Category();

	$category->setData($_POST);

	$category->save();

	header('Location: ../categories');
	exit;

});


$app->get('/admin/categories/:idcategory/delete', function ($idcategory) {

	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$category->delete();

	header('Location: ../../categories');
	exit;

});


$app->get('/admin/categories/:idcategory', function ($idcategory) {

	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$page = new PageAdmin();

	$page->setTpl('categories-update', [

		'category' => $category->getValues()

	]);

});


$app->post('/admin/categories/:idcategory', function ($idcategory) {

	User::verifyLogin();

	$category = new Category();

	$category->get($idcategory);

	$category->setData(['descategory' => $_POST['descategory']]);

	$category->save();

	header('Location: ../categories');
	exit;

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

?>