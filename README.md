# crypto

Desafio LabSEC

Criação de uma aplicação para criptografia simétrica e assimétrica (RSA)

Aplicação ainda não está 100% pronta, porém já está funcionando.

Há uma passagem de parâmetros no arquivo CryptoControl.php nas últimas linhas. Para serem criadas novas chaves basta passar dois números primos na sua inicialização e o texto a ser criptografado em: $exec = new CryptoControl(19, 23, "Segunda-feira, 20 de abril de 2015. #Desafio LabSEC");

Feito isso só executar o arquivo por linha de comando: php CryptoControl.php

