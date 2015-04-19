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
					//posso pegar qualquer um que seja co-primo de 697
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

	#254 68 41 91 592 350
	# T   U  R  I  N   G
	public function createPrivateKey() {
		$resultPrimes = $this->helper->multiplyPrimeNumbers($this->keyValues->getNumeroPrimo1(), $this->keyValues->getNumeroPrimo2());
		$publicKey = $this->createPublicKey();

		$teste = $this->helper->calculateGDC($this->helper->calculateTotient($resultPrimes), $publicKey['e']);

		echo $num;
	}

	//public function descryptoWithPrivateKey();







	public function criptografa_descriptografa_simetrica() {
		$message = $this->keyValues->getMessage();
		echo "Texto original: " . $message . "\n";
		echo "Chave criptografada: " . base64_encode($message) . "\n";

		$message_criptografada = base64_encode($message);
		echo "Chave descriptografada: " . base64_decode($message_criptografada) . "\n";
	}

}

$exec = new CryptoControl(17, 41, "TURING");
$resposta = $exec->cryptoWithPublicKey();
print_r ($resposta);