<?php
require_once '../../../core/core.php'; // Certifique-se de que este caminho está correto

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = intval($_POST['id_colaborador']);
    $nome = htmlspecialchars(trim($_POST['nome_colaborador']));
    $setor = htmlspecialchars(trim($_POST['setor_colaborador']));
    $id_ixc = htmlspecialchars(trim($_POST['id_ixc']));

    $sql = $pdo->prepare('SELECT * FROM colaborador WHERE nome_colaborador = ? AND setor_colaborador = ? AND id_ixc = ?');
    $sql->execute([$nome,$setor,$id_ixc]);

    if ($sql->rowCount() > 0) {
        echo json_encode(['success' => false, 'error' => 'colaborador já está cadastrado']);
    } else {
        $sql = $pdo->prepare('UPDATE colaborador SET nome_colaborador = ? , setor_colaborador = ? , id_ixc = ? WHERE id_colaborador = ?');
        $success = $sql->execute([$nome, $setor, $id_ixc, $userId]);
    }

    if ($success) {
        echo json_encode(['success' => true, 'success' => 'colaborador atualizado com sucesso']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Erro ao atualizar o colaborador']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Requisição inválida']);
}
