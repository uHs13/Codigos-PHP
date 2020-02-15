<?php  

use Hcode\PageAdmin;
use Hcode\Model\User;
use Hcode\Model\Products;
use Hcode\Utils\Utils;


$app->get('/admin/products', function () {

	User::verifyLogin();

	$search = (isset($_GET['search'])) ? Utils::safeEntry($_GET['search']) : '';

	$page = (isset($_GET['page'])) ? Utils::safeEntry($_GET['page']) : 1;

	$product = new Products();

	if ($search != '') {

		$pagination = $product->getProductPageSearch($search, $page);

	} else {

		$pagination = $product->getProductPage($page);

	}

	$pages = [];

	for ($i = 0; $i < $pagination['pages']; $i++) {

		array_push($pages, [

			'text' => $i + 1,
			'href' => '/PHP/ecommerce/admin/products?'. http_build_query([
				'page' => $i + 1,
				'search' => $search
			])

		]);

	}

	$page = new PageAdmin();

	$page->setTpl('products', [
		'products' => $pagination["data"],
		'search' => $search,
		'pages' => $pages
	]);

});


$app->get('/admin/products/create', function () {

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl('products-create');

});


$app->post('/admin/products/create', function () {

	User::verifyLogin();

	$product = new Products();

	$product->setData($_POST);	

	$product->save();

	header('Location: /PHP/ecommerce/admin/products');
	exit;

});


$app->get('/admin/products/:idproduct', function ($idproduct) {

	User::verifyLogin();

	$page = new PageAdmin();

	$product = new Products();

	$product->get((int)$idproduct);

	$page->setTpl('products-update', [

		'product' => $product->getValues()

	]);

});


$app->post('/admin/products/:idproduct', function ($idproduct) {

	User::verifyLogin();

	$product = new Products();

	$product->get((int)$idproduct);

	$product->setData($_POST);

	$product->save();

	$product->setPhoto($_FILES['file']);

	header('Location: /PHP/ecommerce/admin/products');
	exit;


});


$app->get('/admin/products/:idproduct/delete', function ($idproduct) {

	User::verifyLogin();

	$product = new Products();

	$product->get((int)$idproduct);

	$product->delete();

	header('Location: /PHP/ecommerce/admin/products');
	exit;

});

?>