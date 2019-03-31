
<?php 

include_once "../config/Autoloader.php";
Autoloader::register();

$file = new Arquivo('../file/users.csv','r+');

print_r($file->readCsv());


?>