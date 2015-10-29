<?php

require_once "MathHelper.php";
require_once "../model/KeyValues.php";

/*Desafio LabSEC
  Aplicação para criptografia simétrica
  author: Rodolfo Lottin Pereira
  Data: 18/04/2015
*/

class CryptoControl {

	public $helper;
	public $keyValues;
	public $message;
	public $publicKey;
	public $resultPrimes;
	
	public function __construct ($primo1, $primo2, $message) {
		$this->helper = new MathHelper();
		$this->keyValues = new KeyValues($primo1, $primo2);
		$this->message = $message;
		$this->publicKey = $this->createPublicKey();
	}

	public function createPublicKey () {
		$resultPrimes = $this->helper->multiplyPrimeNumbers($this->keyValues->getNumeroPrimo1(), $this->keyValues->getNumeroPrimo2());
		$resultTotient = $this->helper->calculateTotient($resultPrimes);

		for ($i = 2; $i < $resultTotient; $i++) {
			if ($this->helper->isPrimeWithoutException($i)) {
				if ($this->helper->calculateGDC($resultTotient, $i) == 1) {
					$e = $i;
					break;
				}
			}
		}

		$publicKeyValues = array('n' => $resultPrimes, 'e' => $e);
		return $publicKeyValues;
	}

	public function cryptoWithPublicKey () {
		$cryptoText = null;

		for ($i = 0; $i < strlen($this->message); $i++) { 
			$count = 1;

			$eachWord = ord(substr($this->message, $i, $count));
			$cryptoWord = pow($eachWord, $this->publicKey['e']) % $this->publicKey['n'];

			$count++;

			$cryptoText .= " " . $cryptoWord;	
		}
		return substr($cryptoText, 1);
	}

	public function createPrivateKey () {
		$resultTotient = $this->helper->calculateTotient($this->helper->multiplyPrimeNumbers($this->keyValues->getNumeroPrimo1(), $this->keyValues->getNumeroPrimo2()));

		$count = null;;
		$i = null;

		while ($i !== 1) {
			$count++;
			$i = ($count * $this->publicKey['e']) % $resultTotient;
		}

		$p = $this->keyValues->getNumeroPrimo1();
		$q = $this->keyValues->getNumeroPrimo2();
		$d = $count;

		$privateKeyValues = array('p' => $p, 'q' => $q,	'd' => $d);
		return $privateKeyValues;
	}

	public function descryptoWithPrivateKey () {
		$privateKey = $this->createPrivateKey();
		$cryptoMessage = $this->cryptoWithPublicKey();
		$descryptoText = null;

		$pieces = explode(" ", $cryptoMessage);

		foreach ($pieces as $piece) {
			$eachPieceValue = bcmod(bcpow($piece, $privateKey['d']), $privateKey['p'] * $privateKey['q']);
			$descryptoText .= chr($eachPieceValue);
		}

		return $descryptoText;
	}
	/*
	public function simmetryc_crypto () {
		echo "Texto original: " . $this->message . "\n";
		echo "Texto criptografado: " . base64_encode($this->message) . "\n";

		$cryptoMessage = base64_encode($this->message);
		echo "Texto descriptografado: " . base64_decode($cryptoMessage) . "\n";
	}*/

	public function asimmetryc_crypto () {
		$cryptoText = $this->cryptoWithPublicKey();
		$privateKey = $this->createPrivateKey();
		$descryptoText = $this->descryptoWithPrivateKey();

		echo "Texto original: " . $this->message . "\n";
		echo "Chave pública: ";
		  	print_r($this->publicKey) . "\n";
		echo "Texto criptografado: " . $cryptoText . "\n";
		echo "Texto descriptografado: " . $descryptoText . "\n";
	}

}

$exec = new CryptoControl(59, 61, "A CJ é o terror delas!");
echo "Assimétrica" . "\n";
$respostaAsimmetryc = $exec->asimmetryc_crypto();
