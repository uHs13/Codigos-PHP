<?php 
require_once "../config/Autoloader.php";

Autoloader::register();

/*$hector = new Gangsta(Pessoa::cpfRandom());//como Gangsta é filho de Pessoa, na hora de construir o objeto vão ser chamados os construtores das duas classes;
echo $hector."<br>";
unset($hector);
echo'<br>-------------------------------------------<br>';
$heitor = new Pessoa(15177863638);
echo $heitor.'<br>';
unset($heitor);*/

$uno = new CarroVeiculo("golzin g4");
$uno->ligar()."<br>";
$uno->acelerar(130)."<br>";
$uno->frear();
echo $uno."<br>";

 ?>