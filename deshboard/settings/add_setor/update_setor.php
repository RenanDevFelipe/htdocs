<?php
require_once '../../../core/core.php'; // Certifique-se de que este caminho está correto

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = intval($_POST['id_setor']);
    $nome = htmlspecialchars(trim($_POST['nome_setor']));

    $sql = $pdo->prepare('SELECT * FROM setor WHERE nome_setor = ?');
    $sql->execute([$nome]);

    if ($sql->rowCount() > 0) {
        echo json_encode(['success' => false, 'error' => 'Setor já está cadastrado']);
    } else {
        $sql = $pdo->prepare('UPDATE setor SET nome_setor = ? WHERE id_setor = ?');
        $success = $sql->execute([$nome, $userId]);
    }

    if ($success) {
        echo json_encode(['success' => true, 'success' => 'Setor atualizado com sucesso']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Erro ao atualizar o setor']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Requisição inválida']);
}
