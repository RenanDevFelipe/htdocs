<?php 

require_once '../../../core/core.php';

$sql = $pdo->prepare('SELECT * FROM users');
$sql->execute();
$users = $sql->fetchAll();
?>