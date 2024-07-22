<?php 

$host = 'localhost';
$dbname = 'ranking';
$user = 'root';
$pass = '';


try {
$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user , $pass, [
    PDO::ATTR_ERRMODE              => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE   => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES     => false,
    PDO::ATTR_PERSISTENT           => true
]);


}

catch(PDOException $e){
    die("Erro ao conectar no banco de dados: " . $e->getMessage());
}

?>

