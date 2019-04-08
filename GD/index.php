<?php 

require_once "config/Autoloader.php";
Autoloader::register();

// $img = new GraphicDesign(250,250);

// $img->createDesign(67,50,"Firmeza Total");


// $img = new GraphicDesign();

// $img->createFromJpeg('_res/ice-cube-and-nwa.jpg','The World´s Most Dangerous Group',0);

$img = new GraphicDesign();

$img->generateThumbnail('_res/ice-cube-and-nwa.jpg');

?>