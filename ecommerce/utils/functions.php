<?php

use Hcode\Model\User;

function formatPrice(float $price)
{

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

	return ucfirst($user->getdeslogin());

}
//.getUserName

?>