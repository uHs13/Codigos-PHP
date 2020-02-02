<?php

use Hcode\PageAdmin;
use Hcode\Utils\Utils;
use Hcode\Model\User;
use Hcode\Model\Order;

$app->get("/admin/orders", function () {

	User::verifyLogin();

	$order = new Order();

	$page = new PageAdmin();

	$page->setTpl("orders", [

		"orders" =>  $order->getAll()

	]);

});

$app->get("/admin/orders/:idOrder", function ($idOrder) {

	User::verifyLogin();

	Utils::safeEntry($idOrder);

	$order = new Order();

	$page = new PageAdmin();

	$page->setTpl("order", [

		"order" => $order->getClientDetails($idOrder),
		"products" => $order->getProductDetails($idOrder),
		"cart" => $order->getCartDetails($idOrder)

	]);

});

$app->get("/admin/order/:idOrder/delete", function ($idOrder) {

	User::verifyLogin();

	Utils::safeEntry($idOrder);

	$order = new Order();

	$order->delete($idOrder);

	Utils::redirect("/PHP/ecommerce/admin/orders");

});

$app->get("/admin/order/:idOrder/status", function ($idOrder) {

	User::verifyLogin();

	Utils::safeEntry($idOrder);

	$order = new Order();

	$order->get($idOrder);

	$page = new PageAdmin();

	$page->setTpl("order-status", [

		"order" => $order->getValues(),
		"status" => $order->getStatus(),
		"msgSuccess" => Utils::getSessionMsgSuccess(),
		"msgError" => Utils::getSessionMsgError()

	]);

});

$app->post("/admin/order/:idOrder/status", function ($idOrder) {

	User::verifyLogin();

	Utils::safeEntry($idOrder);

	Utils::safeEntry($_POST);

	$order = new Order();

	$order->get($idOrder);

	$order->updateStatus($_POST["idstatus"]);

	Utils::redirect("/PHP/ecommerce/admin/order/$idOrder/status");

});