<?php 
	function somar($a, $b){
		return $a+$b;
	}

	function subtrair($a,$b){
		return $a-$b;
	}

	function multiplicar($a,$b){
		return $a*$b;
	}

	function dividir($a,$b){
		if($a && $b != 0){
			return $a/$b;
		}else{
			echo "<p style='color:red;'>Operacao com Zero</p>";
			return -1;
		}
	}

	function elevar($a, $b){
		return $a**$b;
	}

 ?>