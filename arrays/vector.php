<?php 

function somaTodos(int ...$valores):string{
	return array_sum($valores);
}

$valores = somaTodos(5,10,15,20,25,30);

var_dump($valores);




 ?>