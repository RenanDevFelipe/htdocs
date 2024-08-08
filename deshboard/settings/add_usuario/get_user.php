<?php
require_once '../../../core/core.php'; // Certifique-se de que este caminho está correto

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $userId = intval($_GET['id']);

    $sql = $pdo->prepare('SELECT * FROM users WHERE id_user = ?');
    $sql->execute([$userId]);
    $user = $sql->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo json_encode(['success' => true, 'data' => $user]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Usuário não encontrado']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Requisição inválida']);
}
?>