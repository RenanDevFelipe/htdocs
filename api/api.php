<?php
require(__DIR__ . DIRECTORY_SEPARATOR . 'WebserviceClient.php');
$host = 'https://central.ticonnecte.com.br/webservice/v1';
$token = '210:91b6ee4353241acf996d3235e1c07a536a739f6e727dc8f51cf4a298ef8058b6';
$selfSigned = true;
$api = new IXCsoft\WebserviceClient($host, $token, $selfSigned);
date_default_timezone_set('America/Sao_Paulo');
?>