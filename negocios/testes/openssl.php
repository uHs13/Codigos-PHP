<?php

require_once "sslsecrets.php";

$data = [
	
	"id_User"=>"1",
	"idSession_User"=>"3",
	"CPF"=>"15177863638"
	
];

$openssl = openssl_encrypt(json_encode($data), 'AES-128-CBC', SECRET, 0, SECRETIV);

echo nl2br("ENCRYPT:\n");
var_dump($openssl);

$decrypt = openssl_decrypt($openssl, 'AES-128-CBC', SECRET, 0, SECRETIV);

/* nl2br() - função utilizada para indicar ao browser a quebra de linha '\n' */
echo nl2br("\n\nDECRYPT\n");
var_dump($decrypt);


?>