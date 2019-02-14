<?php 

function anonima($varAnom){
	echo "Entrou na função";
	echo '<br>';
	
	$varAnom();
}

/*anonima(function(){

	echo "Entrou na função anonima";

});*/


$funcao = function($frase){

	var_dump($frase);

};

$funcao("Look");

?>