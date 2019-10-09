<?php

use Hcode\Model\User;

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

?>