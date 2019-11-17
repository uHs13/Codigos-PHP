<?php 

$date = new DateTime(); //objeto date;

echo $date->format('l, d/m/Y')."<br>";//chamando um método do objeto date;

$periodo = new DateInterval("P90D");//guarda um período de dias determinado pelo numero entre o P e o D;

$date->add($periodo);//adiciona o periodo determinado no objeto DateInterval com a data atual;

echo $date->format('l, d/m/Y')."<br>";//mostra a data formatada e com mais o período escolhido;

$date->sub($periodo);//subtrai um periodo da data em que o DateTime está;

echo $date->format('l, d/m/Y')."<br>";

echo get_class($date);//retorna o nome da classe do objeto;
?>