<?php

/*Classe utilizada como modelo para as operações da classe principal (CryptoControl)
Recebendo números primos para criação das chaves
*/

class KeyValues {
	
	public $numeroPrimo_1;
	public $numeroPrimo_2;
	
	public function KeyValues($primo1, $primo2) {
		$this->numeroPrimo_1 = $primo1;
		$this->numeroPrimo_2 = $primo2;
	}

	public function getNumeroPrimo1() {
		return $this->numeroPrimo_1;
	}

	public function setNumeroPrimo1($primo1) {
		$this->numeroPrimo_1 = $primo1;
	}

	public function getNumeroPrimo2() {
		return $this->numeroPrimo_2;
	}

	public function setNumeroPrimo2($primo2) {
		$this->numeroPrimo_2 = $primo2;
	}
}
