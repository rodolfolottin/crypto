<?php

require_once "MathHelper.php";
require_once "KeyValues.php";

/*Desafio LabSEC
  Aplicação para criptografia simétrica
  author: Rodolfo Lottin Pereira
  Data: 18/04/2015
*/

class CryptoControl extends KeyValues {

	public $helper;
	public $keyValues;
	
	public function __construct ($primo1, $primo2, $message) {
		$this->helper = new MathHelper();
		$this->keyValues = new KeyValues($primo1, $primo2, $message);
	}

	public function createPublicKey ($primo1, $primo2) {
		//utilizando codigo duplicado
		$num = $primo1 * $primo2;
		$multprimos = $this->multiplica_primos($primo1, $primo2);
		$totient = $this->totient($multprimos);

		for ($i = 2; $i < $totient; $i++) {
			if ($this->isPrimeWithoutException($i)) {
				if ($this->mdc($totient, $i) == 1) {
					$e = $i;
					break;
				}
			}
		}

		$publicKeyValues = array('n' => $multprimos,
									'e' => $e);
		return $publicKeyValues;
	}

	public function cryptoWithPublicKey($texto, $p, $q) {
		$myPublicKey = $this->createPublicKey($p , $q);
		$cryptoText = null;

		for ($i = 0; $i < strlen($texto); $i++) { 
			$count = 1;

			$eachWord = ord(substr($texto, $i, $count));
			$cryptoWord = pow($eachWord, $myPublicKey['e']) % $myPublicKey['n'];

			$count++;

			$cryptoText .= " " . $cryptoWord;	
		}
		return substr($cryptoText, 1);
	}

	public function createPrivateKey($p, $q) {
		$multPrimos = $this->multiplica_primos($p, $q);
		$publicKey = $this->createPublicKey($p, $q);

		$num = $this->mdc($this->totient($multPrimos), $publicKey['e']);

		echo $num;
	}

	//public function descryptoWithPrivateKey();

	public function criptografa_descriptografa_simetrica() {

		$message = $keyValues->getMessage();

		//imprimo texto original
		echo "Texto original: " . $message . "\n";

		//imprimo texto criptografado
		echo "Chave criptografada: " . base64_encode($message) . "\n";

		//texto criptografado
		$message_criptografada = base64_encode($message);

		//imprimo texto descriptografado
		echo "Chave descriptografada: " . base64_decode($message_criptografada) . "\n";
	}

}

$exec = new CryptoControl();
//$exec->criptografa_descriptografa_simetrica("João convidou Maria para comer pão.");
$resposta = $exec->criptografa_descriptografa_simetrica();
echo $resposta;