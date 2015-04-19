<?php

/*Desafio LabSEC
  Aplicação para criptografia simétrica
  author: Rodolfo Lottin Pereira
  Data: 18/04/2015
*/

class CryptoControl {

	$numeroPrimo_1;
	$numeroPrimo_2;
	$textoParaDecifrar;
	$helper;
	$keyvalues;
	
	function __construct($primo1, $primo2, $textoParaDecifrar) {
		$this->$numeroPrimo_1 = $primo1;
		$this->$numeroPrimo_2 = $primo2;
		$this->$textoParaDecifrar = $texto;
		$this->helper = new MathHelper();
		$this->keyvalues = new KeyValues();
	}

	function getNumeroPrimo1() {
		return $this->numeroPrimo_1;
	}

	function setNumeroPrimo1($numeroPrimo) {
		return $this->numeroPrimo_1;
	}

	function getNumeroPrimo2() {
		return $this->numeroPrimo_2;
	}

	function setNumeroPrimo2($numeroPrimo) {
		return $this->numeroPrimo_2;
	}

	function getTextoParaDecifrar() {
		return $this->textoParaDecifrar;
	}

	function setTextoParaDecifrar($texto) {
		return $this->$texto;
	}

	function criptografa_descriptografa_simetrica($chave) {

		//imprimo texto original
		echo "Texto original: " . $chave . "\n";

		//imprimo texto criptografado
		echo "Chave criptografada: " . base64_encode($chave) . "\n";

		//texto criptografado
		$chave_criptografada = base64_encode($chave);

		//imprimo texto descriptografado
		echo "Chave descriptografada: " . base64_decode($chave_criptografada) . "\n";
	}


	function IsPrime($number) {
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

	function isPrimeWithoutException($number) {
		if ($number < 2)
		    return false;
		    
		    for ($i = 2; $i <= ($number / 2); $i++) {
		    	if($number % $i == 0)
		        	return false;
		    }
		return true;
	}

	function multiplica_primos($p, $q) {
		if ($this->IsPrime($p) && $this->IsPrime($q))
			$num = $p * $q;

		return $num;
	}

	function totient ($num) {
		$count = 0;

		for ($i = 1; $i < $num; $i++) { 
			if ($this->mdc($num, $i) == 1)
				$count++;
		}

		return $count;
	}

	function mdc ($a, $b) {
		$temp = 0;

		if ($a < $b) {
			$temp = $a;
			$a = $b;
			$b = $temp;
		}

		if ($a % $b == 0)
			return $b;

		return $this->mdc($a % $b, $b);
	}

	function createPublicKey ($primo1, $primo2) {
		//codigo duplicado
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

	function cryptoWithPublicKey($texto, $p, $q) {
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

	function createPrivateKey($p, $q) {
		$multPrimos = $this->multiplica_primos($p, $q);
		$publicKey = $this->createPublicKey($p, $q);

		$num = $this->mdc($this->totient($multPrimos), $publicKey['e']);

		echo $num;

	}

	//function descryptoWithPrivateKey();


}

$exec = new CryptoControl();
//$exec->criptografa_descriptografa_simetrica("João convidou Maria para comer pão.");
$resposta = $exec->createPrivateKey(17, 41);
echo $resposta;
