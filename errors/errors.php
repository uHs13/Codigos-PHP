<?php 

	//Função para manipular erros. A diferença desse método pro try/catch é que os blocos try/catch só são usados onde eles são definidos, já a função de manipulação de erros é executada pelo PHP em qualquer lugar que ocorra um erro
function error_handler($code,$message,$file,$line){

	echo json_encode(array(

		"Code"=>$code,
		"Message"=>$message,
		"File"=>$file,
		"Line"=>$line

	));

}



//Após criar  a função temos que mostrar pro PHP que é ela que deve ser chamada toda vez que ocorrer um erro
				//nome da função criada
set_error_handler('error_handler');



$result = 13/0;

?>