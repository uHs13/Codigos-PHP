<?php

use Hcode\Page;


$app->get('/', function() {//ROTA DA PÁGINA PRINCIPAL
   
   	$page = new Page();

   	$page->setTpl("index");
   
});


?>