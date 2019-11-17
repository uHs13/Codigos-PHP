<?php 

function getName($name){

	if(!$name){

		throw new Exception("Insert a valid name",400);//lança exceções

	}

	echo ucfirst($name).'<br>';

}



try{ //usado para facilitar a captura de potenciais exceções. Cada bloco try precisa necessariamente  ter ao menos um bloco catch ou finally correspondente

	getName('heitor');

	getName('');

} catch (Exception $e){ //bloco usado para capturar exceções


	echo '<span style="color:red">'.$e->getMessage().' || code:'.$e->getCode().'</span><br>';	

} finally { // esse bloco é executado mesmo se houver um lançamento de uma exceção e antes que a execução normal do código continue


	echo "Carrying out the finally block";

}

?>