<?php

use Hcode\Model\User;
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

$app->get("/profile-orders-detail", function () {

	User::verifyLogin(false, 2);



});