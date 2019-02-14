<?php 
	define("OGLoc","Oglocked");//Nome, valor de uma constante;

	define("SHUTDOWN",['-s','-t',3000]);//por convenção utilizamos o nome todo em capslock;

	//echo SHUTDOWN[2];
	//echo PHP_VERSION; mostra a versão do PHP instalada no PC
	echo __FILE__;
	echo "<br>";
	echo PHP_OS;
	echo "<br>";
	echo PHP_INT_SIZE;
	echo "<br>";
	echo $_SERVER['SCRIPT_NAME'];//pega o caminho percorrido para acessar o arquivo - caminho depois do protocolo e do dominio;
	echo "<br>";
	echo( $_SERVER['REMOTE_ADDR']);//mostra o ip do cliente que acessou o servidor;
 ?>