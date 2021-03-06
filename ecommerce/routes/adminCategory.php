<?php  

use Hcode\Model\User;
use Hcode\PageAdmin;
use Hcode\Page;
use Hcode\Model\Category;
use Hcode\Model\Products;
use Hcode\Utils\Utils;


$app->get('/admin/categories', function () {

	User::verifyLogin();

	$search = (isset($_GET['search'])) ? Utils::safeEntry($_GET['search']) : '';

	$page = (isset($_GET['page'])) ? Utils::safeEntry($_GET['page']) : 1;

	$category = new Category();

	if ($search != '') {

		$pagination = $category->getCategoryPageSearch($search, $page);

	} else {

		$pagination = $category->getCategoryPage($page);

	}

	$pages = [];

	for ($i = 0; $i < $pagination['pages']; $i++) {

		array_push($pages, [

			'text' => $i + 1,
			'href' => '/PHP/ecommerce/admin/categories?'. http_build_query([
				'page' => $i + 1,
				'search' => $search
			])

		]);

	}

	$page = new PageAdmin();

	$page->setTpl("categories", array(
		"categories" => $pagination["data"],
		"search" => $search,
		"pages" => $pages
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


$app->get('/admin/categories/:idcategory/products', function ($idcategory) {

	User::verifyLogin();
	
	$category = new Category();

	$category->get((int)$idcategory);

	$page = new PageAdmin();

	$page->setTpl('categories-products', [

		'category' => $category->getValues(),
		'productsNotRelated' => $category->getProducts(false),
		'productsRelated' => $category->getProducts(true)

	]);


});


$app->get('/admin/categories/:idcategory/products/:idproduct/add',
	function ($idcategory, $idproduct)
	{
		User::verifyLogin();

		$category = new Category();

		$category->get((int)$idcategory);

		$product = new Products();

		//fazer o cast sempre que for passar um parâmetro que precisa ser de determinado tipo
		$product->get((int)$idproduct);

		$category->addProduct($product);

		header("Location:/PHP/ecommerce/admin/categories/$idcategory/products");
		exit;

	});

$app->get('/admin/categories/:idcategory/products/:idproduct/remove',
	function ($idcategory, $idproduct)
	{

		User::verifyLogin();

		$category = new Category();

		$category->get((int)$idcategory);

		$product = new Products();

		//fazer o cast sempre que for passar um parâmetro que precisa ser de determinado tipo
		$product->get((int)$idproduct);

		$category->removeProduct($product);

		header("Location:/PHP/ecommerce/admin/categories/$idcategory/products");
		exit;

	});
