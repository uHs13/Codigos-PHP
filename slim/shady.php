<?php 

require_once("vendor/autoload.php");//autoloader do composer

setlocale(LC_ALL, "pt_BR", "pt_BR.utf-8", "portuguese");//constante do PHP, padrão de data do país onde está. Tem 3 parametros porque é o formato do linux, utf-8 e windows;


$app = new \Slim\Slim(array(
	'mode'=>'development'
));//inicializando o slim

$app->get('/',function(){// o que será executado na chamada dessa função

	echo json_encode(array(
		'Welcome'=>'Will the real Slim Shad... Slim Server please stand up?',
		'date'=>ucfirst(strftime("%A,  %d de %B de %Y.", strtotime("now"))),
		'time'=>date('H:i:s')
	));

});

//objeto com a configuração de todas as rotas
$app->get('/user/:name', function ($name) {
    echo "Olá, " . $name;
});

$app->post('/user/:name', function ($name) {
    echo "O nome tem ".strlen($name)." letras";
});

$app->run();//após declarar todas as rotas usamos o método run


?>