<?php 

$pasta = 'arquivos';

if(!is_dir($pasta)){
	mkdir($pasta);
	echo "$pasta criada com sucesso";
} else {

	rmdir($pasta);//rmdir remove uma pasta
	echo "$pasta removida";

}




?>