<?php 

require_once '../../../core/core.php';

$data_finalizacao = date('Y-m-d');
$ponto_carro = 20;

$sql = $pdo->prepare('UPDATE avaliacao_n2 SET ponto_lavagem_carro = ? WHERE data_finalizacao = ?');
$sql->execute([$ponto_carro,$data_finalizacao]);

?>