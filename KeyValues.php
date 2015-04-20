<?php

class KeyValues {
	
	public $numeroPrimo_1;
	public $numeroPrimo_2;
	public $message;
	
	public function KeyValues($primo1, $primo2, $message) {
		$this->numeroPrimo_1 = $primo1;
		$this->numeroPrimo_2 = $primo2;
		$this->message = $message;
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

	public function getMessage() {
		return $this->message;
	}

	public function setMessage($message) {
		$this->message = $message;
	}
}