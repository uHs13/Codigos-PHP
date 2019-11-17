<?php 

class Pessoa{

	protected $cpf;

	function __construct($nmrcpf){// método mágico construtor;
		echo "Construtor da classe ".get_class()."<br>";
		$this->setcpf($nmrcpf);

	}

	function __destruct(){//método destrutor;
		echo "Cancelando cpf Pessoa<br>";
	}

	function __toString():string{// método toString. Usado para serializar objetos;
		if(isset($this))return $this->getcpf(); 
	}

	public function getcpf(){
		if(isset($this->cpf))return $this->cpf;
	}

	public function setcpf($cpfuser){
		if(Pessoa::validacpf($cpfuser)){
			$this->cpf = $cpfuser;
		}else{//quando a função já retorna um booleano não é preciso fazer nada do tipo:
			//return false; o falso já é retornado normal pela função, só precisa fazer o código da condição;
			throw new Exception("enter a valid number", 1);
		}
	}

	public static function validacpf($cpf):bool{//Determina o tipo de retorno como booleano;

		//Verifica se um número foi informado; 
		if(empty($cpf) ){
			return false;
		}


        // Elimina possível mascara;
		$cpf = preg_match('/[0-9]/', $cpf)?$cpf:0;

		$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

        // Verifica se o número de digitos informados é igual a 11;	     
		if (strlen($cpf) != 11) {
			
			throw new Exception("invalid lenght", 1);
			return false;
		}

        //Verifica se nenhuma das sequências inválidas abaixo foi informada. Caso sim retorna falso;

		else if ($cpf == '00000000000' || 
			$cpf == '11111111111' || 
			$cpf == '22222222222' || 
			$cpf == '33333333333' || 
			$cpf == '44444444444' || 
			$cpf == '55555555555' || 
			$cpf == '66666666666' || 
			$cpf == '77777777777' || 
			$cpf == '88888888888' || 
			$cpf == '99999999999') {
			return false;

         //Calcula os digitos verificadores para validar o cpf; 	  	
	} else {   

		for ($t = 9; $t < 11; $t++) {

			for ($d = 0, $c = 0; $c < $t; $c++) {
				$d += $cpf{$c} * (($t + 1) - $c);
			}
			$d = ((10 * $d) % 11) % 10;
			if ($cpf{$c} != $d) {
				return false;
				
			}
		}

		return true;
	}
}//Fim do método validacpf();

public static function cpfRandom($mascara = "0") {//Inicio método cpfRandom();
	$n1 = rand(0, 9);
	$n2 = rand(0, 9);
	$n3 = rand(0, 9);
	$n4 = rand(0, 9);
	$n5 = rand(0, 9);
	$n6 = rand(0, 9);
	$n7 = rand(0, 9);
	$n8 = rand(0, 9);
	$n9 = rand(0, 9);
	$d1 = $n9 * 2 + $n8 * 3 + $n7 * 4 + $n6 * 5 + $n5 * 6 + $n4 * 7 + $n3 * 8 + $n2 * 9 + $n1 * 10;
	$d1 = 11 - (self::mod($d1, 11) );
	if ($d1 >= 10) {
		$d1 = 0;
	}
	$d2 = $d1 * 2 + $n9 * 3 + $n8 * 4 + $n7 * 5 + $n6 * 6 + $n5 * 7 + $n4 * 8 + $n3 * 9 + $n2 * 10 + $n1 * 11;
	$d2 = 11 - (self::mod($d2, 11) );
	if ($d2 >= 10) {
		$d2 = 0;
	}
	$retorno = '';
	if ($mascara == 1) {
		$retorno = '' . $n1 . $n2 . $n3 . "." . $n4 . $n5 . $n6 . "." . $n7 . $n8 . $n9 . "-" . $d1 . $d2;
	} else {
		$retorno = '' . $n1 . $n2 . $n3 . $n4 . $n5 . $n6 . $n7 . $n8 . $n9 . $d1 . $d2;
	}
	return $retorno;

}//Fim método cpfRandom();

private static function mod($dividendo, $divisor) {//Inicio método mod();
	
	return round($dividendo - (floor($dividendo / $divisor) * $divisor));

}//Fim método mod()

public static function cnpjRandom($mascara = "1") {//Inicio método cnpjRandom();
	$n1 = rand(0, 9);
	$n2 = rand(0, 9);
	$n3 = rand(0, 9);
	$n4 = rand(0, 9);
	$n5 = rand(0, 9);
	$n6 = rand(0, 9);
	$n7 = rand(0, 9);
	$n8 = rand(0, 9);
	$n9 = 0;
	$n10 = 0;
	$n11 = 0;
	$n12 = 1;
	$d1 = $n12 * 2 + $n11 * 3 + $n10 * 4 + $n9 * 5 + $n8 * 6 + $n7 * 7 + $n6 * 8 + $n5 * 9 + $n4 * 2 + $n3 * 3 + $n2 * 4 + $n1 * 5;
	$d1 = 11 - (self::mod($d1, 11) );
	if ($d1 >= 10) {
		$d1 = 0;
	}
	$d2 = $d1 * 2 + $n12 * 3 + $n11 * 4 + $n10 * 5 + $n9 * 6 + $n8 * 7 + $n7 * 8 + $n6 * 9 + $n5 * 2 + $n4 * 3 + $n3 * 4 + $n2 * 5 + $n1 * 6;
	$d2 = 11 - (self::mod($d2, 11) );
	if ($d2 >= 10) {
		$d2 = 0;
	}
	$retorno = '';
	if ($mascara == 1) {
		$retorno = '' . $n1 . $n2 . "." . $n3 . $n4 . $n5 . "." . $n6 . $n7 . $n8 . "/" . $n9 . $n10 . $n11 . $n12 . "-" . $d1 . $d2;
	} else {
		$retorno = '' . $n1 . $n2 . $n3 . $n4 . $n5 . $n6 . $n7 . $n8 . $n9 . $n10 . $n11 . $n12 . $d1 . $d2;
	}
	return $retorno;
}//Fim método cnpjRandom();

}//Fim classe Pessoa;


?>
