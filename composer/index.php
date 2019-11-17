<?php 

require __DIR__ . '/vendor/autoload.php';


$log = new Monolog\Logger('Heitor');
$log->pushHandler(new Monolog\Handler\StreamHandler('app.log', Monolog\Logger::WARNING));
$log->addWarning('Um momento amigo...');

echo "Testando o autoload do Composer";

?>