<?php

require_once "MathHelper.php";
require_once "KeyValues.php";

/*Desafio LabSEC
  Aplicação para criptografia simétrica
  author: Rodolfo Lottin Pereira
  Data: 18/04/2015
*/

class CryptoControl {

	public $helper;
	public $keyValues;
	
	public function __construct ($primo1, $primo2, $message) {
		$this->helper = new MathHelper();
		$this->keyValues = new KeyValues($primo1, $primo2, $message);
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

		$publicKeyValues = array('n' => $resultPrimes,
									'e' => $e);
		return $publicKeyValues;
	}

	public function cryptoWithPublicKey() {
		$myPublicKey = $this->createPublicKey();
		$message = $this->keyValues->getMessage();
		$cryptoText = null;

		for ($i = 0; $i < strlen($message); $i++) { 
			$count = 1;

			$eachWord = ord(substr($message, $i, $count));
			$cryptoWord = pow($eachWord, $myPublicKey['e']) % $myPublicKey['n'];

			$count++;

			$cryptoText .= " " . $cryptoWord;	
		}
		return substr($cryptoText, 1);
	}

	public function createPrivateKey() {
		$resultPrimes = $this->helper->multiplyPrimeNumbers($this->keyValues->getNumeroPrimo1(), $this->keyValues->getNumeroPrimo2());
		$resultTotient = $this->helper->calculateTotient($resultPrimes);
		$publicKey = $this->createPublicKey();

		$count = null;;
		$i = null;

		while ($i !== 1) {
			$count++;
			$i = ($count * $publicKey['e']) % $resultTotient;
		}

		$d = $count;

		$privateKeyValues = array('n' => $resultPrimes,
									'd' => $d);
		return $privateKeyValues;
	}

	public function descryptoWithPrivateKey() {
		$privateKey = $this->createPrivateKey();
		$cryptoMessage = $this->cryptoWithPublicKey();
		$descryptoText = null;

		$pieces = explode(" ", $cryptoMessage);

		foreach ($pieces as $piece) {
			$eachPieceValue = bcmod(bcpow($piece, $privateKey['d']),$privateKey['n']);
			$descryptoText .= chr($eachPieceValue);
		}

		return $descryptoText;
	}

	public function simetric_crypto() {
		$message = $this->keyValues->getMessage();
		echo "Texto original: " . $message . "\n";
		echo "Chave criptografada: " . base64_encode($message) . "\n";

		$cryptoMessage = base64_encode($message);
		echo "Chave descriptografada: " . base64_decode($cryptoMessage) . "\n";
	}

}

$exec = new CryptoControl(17, 23, "TURING");
//$resposta = $exec->cryptoWithPublicKey();
$resposta = $exec->descryptoWithPrivateKey() . "\n";
print_r($resposta);