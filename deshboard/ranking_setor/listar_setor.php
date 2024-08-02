<?php 
require_once '../../core/core.php';

$sql = $pdo->prepare('SELECT * FROM setor');
$sql->execute();

if($sql->rowCount() < 1){
    echo 'Nenhum setor Cadastrado';
} else{
    $setores = $sql->fetchAll();
}
?>