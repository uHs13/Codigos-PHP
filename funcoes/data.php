<?php 
	echo date("d/m/Y H:i:s")."<br>";//dia/mes/ano hora/minuto/segundo. Colocar o timstamp fixa a hora no timestamp passado;
	echo time()."<br>";//mostra o timestamp, quantidade de segundos desde 1/1/1970 até a hora atual;
	$ts = strtotime("2001-09-11");//calcula o timestamp de uma data passada como parâmetro;
	echo date("l, d/m/Y", $ts)."<br>";//mostra a data do timestamp passado formatada do jeito escolhido
	
	$ts2 = strtotime("now");//now == data de hoje, +1 day == data de amanhã, +1 week == mesmo dia da semana que vem
	echo date("l, d/m/Y", $ts2)."<br>";  

	setlocale(LC_ALL, "pt_BR", "pt_BR.utf-8", "portuguese");//constante do PHP, padrão de data do país onde está. Tem 3 parametros porque é o formato do linux, utf-8 e windows;
	echo ucfirst(strftime("%A,  %d de %B de %Y.", $ts2));// Os parâmetros passados são padrões da documentação do PHP;
	//strftime mostra a data do servidor formatada com o padrão passado no setlocale;

?>