<?php 

require_once 'config/Autoloader.php';

Autoloader::register();

$user = new Usuario('Heitor','heitorhenriquedias@gmail.com');

$file = new Arquivo('file/first.txt','a');

$file->write($user);
?>