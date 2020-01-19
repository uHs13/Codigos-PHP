<?php

use Hcode\Model\User;
use Hcode\Model\Order;
use Hcode\Model\Cart;
use Hcode\Page;
use Hcode\Utils\Utils;

$app->get("/profile-orders", function () {

	User::verifyLogin(false, 2);

	$page = new Page();

	$user = User::getFromSession();

	$page->setTpl("profile-orders", [

		"orders" => $user->getOrders()

	]);

});

$app->get("/profile/orders/:id", function ($id) {

	User::verifyLogin(false, 2);

	$id = Utils::safeEntry($id);

	$page = new Page();

	$order = new Order();

	$order->get($id);

	$cart = new Cart();

	$cart->get($order->getidcart());

	$cart->calculateTotal();

	$page->setTpl("profile-orders-detail", [

		"order" => $order->getValues(),
		"products" => $cart->getProducts(),
		"cart" => $cart->getValues()

	]);

});