<?php 

try{

	throw new Exception("An error occurred while processing the request", 404);//O número é usado para ajudar a identificar o tipo de erro que ocorreu
	


} catch (Exception $e) {

	echo json_encode(array(

		"message"=>$e->getMessage(),//métodos que já existem internamente dentro da classe Exception
		"code-line"=>$e->getLine(),
		"file"=>$e->getFile(),
		"error-code"=>$e->getCode()

	));

}

?>