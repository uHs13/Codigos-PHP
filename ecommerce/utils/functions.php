<?php

use Hcode\Model\User;
use Hcode\Model\Cart;

function formatPrice($price)
{

	if (!$price > 0) $price = 0;

	return number_format($price, 2, ',', '.');

}
//.formatPrice

function checkLogin(bool $inadmin = false, $redirect = 1)
{

	return User::verifyLogin($inadmin, $redirect, false);

}
//.formatPrice

function getUserName()
{

	$user = User::getFromSession();

	return $user->getdeslogin();

}
//.getUserName

function getCartTotal()
{

	$cart = Cart::getFromSession();

	$cart->getProducts();

	$cart->calculateTotal();

	return formatPrice($cart->getTotal());

}
// .getCartTotal

function getCartProductsQuantity()
{

	$cart = Cart::getFromSession();

	return $cart->getProductsCount();

}
// .getProductsQuantity

?>