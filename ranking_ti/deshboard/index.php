<?php 
include '../autentication/index.php';
$name = $_SESSION['user_name'];
$setor = $_SESSION['user_setor']
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/index.css">
    <title>Document</title>
</head>
<body>
    <h1>Deshboard</h1>
    <h2><?php echo $name ?></h2>
    <h3><?php echo $setor ?></h3>
</body>
</html>