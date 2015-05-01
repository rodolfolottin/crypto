<?php

/**Classe com funções comumente utilizadas pela classe principal (CryptoControl)
Funções para verificar se um número é primo, para multiplicar números primos, função totient de euler e máximo divisor comum
*/

class MathHelper {

	public function IsPrime($number) {
		try {
		    if ($number < 2)
		    	throw new Exception($number . " não é primo" . "\n");
		    
		    for ($i = 2; $i <= ($number / 2); $i++) {
		    	if($number % $i == 0)
		        	throw new Exception($number . " não é primo" . "\n");
		    }
		} catch (Exception $e) {
			die("Exceção capturada: " . $e->getMessage());
		}
		return true;
	}

	public function isPrimeWithoutException($number) {
		if ($number < 2)
		    return false;
		    
		    for ($i = 2; $i <= ($number / 2); $i++) {
		    	if($number % $i == 0)
		        	return false;
		    }
		return true;
	}

	public function multiplyPrimeNumbers($number1, $number2) {
		if ($this->IsPrime($number1) && $this->IsPrime($number2))
			$result = $number1 * $number2;

		return $result;
	}

	public function calculateTotient($number) {
		$result = 0;

		for ($i = 1; $i < $number; $i++) { 
			if ($this->calculateGDC($number, $i) == 1)
				$result++;
		}

		return $result;
	}

	public function calculateGDC ($number1, $number2) {
		$temp = 0;

		if ($number1 < $number2) {
			$temp = $number1;
			$number1 = $number2;
			$number2 = $temp;
		}

		if ($number1 % $number2 == 0)
			return $number2;

		return $this->calculateGDC($number1 % $number2, $number2);
	}
}
