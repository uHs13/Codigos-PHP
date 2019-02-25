<?php  
	/*
	$ip  = $_SERVER["REMOTE_ADDR"];
	var_dump($ip);
	echo "</br>";
	$path = $_SERVER["SCRIPT_NAME"];
	var_dump($path);
	*/

	$frase = "<div style='color:red;'>O homem na estrada recomeca sua vida.</div>";
	//echo "Racionais: $frase";//interpolação de variável;	
	echo strtoupper($frase);// upper case; -> não pega ç, letras com acentuação
	echo"</br>";
	echo strtolower($frase);
	echo"</br>";
	echo ucwords($frase);//primeira letra de cada palavra maiuscula
	echo"</br>";
	echo ucfirst("amanhece mais um dia");//primeira letra da primera palavra maiuscula
	echo "</br>";
	echo"</br>";
	echo str_replace(".", ", sua finalidade a sua liberdade", $frase);
	echo "</br>";
	$kw = "estrada";
	$find = strpos($frase, $kw);
	var_dump($find);
	echo "</br>";
	echo "</br>";
	$x = substr($frase, 0, $find);//segundo e terceiro argumentos são numeros;
	var_dump($x); 
	echo "</br>";
	echo "</br>";
	$x2 = substr($frase,$find,strlen($frase));
	echo("<br>");
	echo $x2;
	echo("<br>");
	echo var_dump("Frase");//string
	echo var_dump(13);//int
	echo var_dump(13.13);//float
	echo var_dump(true);//bool
	echo "<a href='../negocios'>Voltar</a><br>";
	
	$x =13;

	function mostraX(){
		 global $x;
		 echo $x;
	}
	
	mostraX();

	?>
