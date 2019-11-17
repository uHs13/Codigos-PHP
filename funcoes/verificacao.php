<?php 

function faixaEtaria($idade){
	return ($idade<18)?"<p class='text-danger'>Menor</p>":"<p class='text-primary'>Maior</p>";//Operador Ternário;
	/*  
		if($idade<18){
			<p class='text-danger'>Menor</p>;
		}else{
			<p class='text-primary'>Maior</p>;
		}
	
	 */
}


function verificaidade($idade){//para ser uma função tem que retornar algum valor, se nao retornar é uma sub-rotina; usando return fica mais abstrato e podemos fazer mais coisas com o valor retornado;


	if($idade<=12){
		return "<p>Crianca</p>";
		
	}else if ($idade < 18){
		return "<p>Adolescente</p>";
		
	}else if ($idade <65){
		return "<p>Adulto</p>";
		
	}else{
		return "<p>Idoso</p>";
		
	}

}

function carteira($idade){
	switch ($idade) {
		case $idade>=18:
		return "<p class='text-success'>Autorizado</p>";
		break;


		default:
		return "<p class='text-danger'>Negado</p>";
		break;
	}
}




?>