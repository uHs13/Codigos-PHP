<?php 

define('SECRET',pack('a16','senha'));
define('SECRET_IV',pack('a16','senha'));

$data = [

	'login'=>'userName',
	'pass'=>'userPassword'

];

$openssl = openssl_encrypt(json_encode($data), 'AES-128-CBC', SECRET, 0,SECRET_IV);

// echo $openssl;

// echo "<br>";

$decrypt = openssl_decrypt($openssl, 'AES-128-CBC', SECRET, 0 , SECRET_IV);

echo $decrypt;
