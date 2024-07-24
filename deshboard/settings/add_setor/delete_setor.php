<?php
require_once '../../../core/core.php'; // Certifique-se de que este caminho está correto

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $itemId = intval($_GET['id']);

    // Preparar e executar a consulta de deleção
    $sql = $pdo->prepare('DELETE FROM setor WHERE id_setor = ?');
    $sql->execute([$itemId]);

    if ($sql->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Item deletado com sucesso.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao deletar o item.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Requisição inválida.']);
}
?>