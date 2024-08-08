<?php 
require_once '../../../core/core.php';

$sql = $pdo->prepare('SELECT * FROM roles');
$sql->execute();
$roles = $sql->fetchAll()
?>