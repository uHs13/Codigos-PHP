<?php 

define('SECRET',pack('a16','senha'));
define('SECRET_IV',pack('a16','senha'));


$data = [

	'login'=>'uHs13',
	'pass'=>'123'

];

// echo json_encode($data);

$openssl = openssl_encrypt(json_encode($data), 'AES-128-CBC', SECRET, 0,SECRET_IV);

echo 'ENCRIPT:'.$openssl;
echo "<br>";

$decrypt = openssl_decrypt($openssl, 'AES-128-CBC', SECRET, 0 , SECRET_IV);

echo 'DECRIPT:'.$decrypt;

?>