<?php 

$pessoa['nome'] = array();
$pessoa['idade'] = array(); 

array_push($pessoa['nome'],'Hector');
array_push($pessoa['idade'],'18');
array_push($pessoa['nome'],'Slim');
array_push($pessoa['idade'],'42');
array_push($pessoa['nome'],'Dmx');
array_push($pessoa['idade'],'44');



function mostraNome($array){
	foreach ($array['nome'] as $key=> $value) {
		echo $value." ";
		echo $array['idade'][$key];
		echo "<br>";

	}
}




mostraNome($pessoa);





?>