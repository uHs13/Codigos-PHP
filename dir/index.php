<?php 

require_once "config/Autoloader.php";

Autoloader::register();

// echo json_encode( Dir::filesInfo('_res'));
$dir = '_exclude';
// Dir::createDir('_exclude');
Dir::removeDir($dir);
// echo json_encode(Dir::filesInfo($dir));








?>