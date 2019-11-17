<?php 

require_once "config/Autoloader.php";
Autoloader::register();

$cookie_name  = 'UserData';
$cookie = new Cookie($cookie_name);

$var = $cookie->getCookie();
//get cookie nos retorna um objeto do tipo std_class
echo json_encode($var);

?>