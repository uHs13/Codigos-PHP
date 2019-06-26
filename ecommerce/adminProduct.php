<?php  

use Hcode\PageAdmin;
use Hcode\Model\User;
use Hcode\Model\Products;


$app->get('/admin/products', function () {

	$page = new PageAdmin();

	$products = Products::listAll();

	$page->setTpl('products', [
		'products' => $products
	]);

});

?>