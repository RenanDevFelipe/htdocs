<?php
require_once '../../../core/core.php'; // Certifique-se de que este caminho está correto

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $userId = intval($_POST['id_user']);
    $nome = htmlspecialchars(trim($_POST['nomeUser']));
    $emailUser = htmlspecialchars(trim($_POST['emailUser']));
    $role = htmlspecialchars(trim($_POST['roleUser']));
    $setorUser = htmlspecialchars(trim($_POST['setorUser']));

    if (!empty($_POST['passUser'])) {

            $passUser = password_hash($_POST['passUser'], PASSWORD_DEFAULT);
       
            $sql = $pdo->prepare('UPDATE users SET nome_user = ?, email_user = ?, senha_user = ?, role = ?, setor_user = ? WHERE id_user = ?');
            $success = $sql->execute([$nome, $emailUser, $passUser, $role, $setorUser, $userId]);
    

        if ($success) {
            echo json_encode(['success' => true, 'success' => 'Usuário atualizado com sucesso']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Erro ao atualizar o usuário']);
        }
    } else {

            $sql = $pdo->prepare('UPDATE users SET nome_user = ?, email_user = ?, role = ?, setor_user = ? WHERE id_user = ?');
            $success = $sql->execute([$nome, $emailUser, $role, $setorUser, $userId]);

        if ($success) {
            echo json_encode(['success' => true, 'success' => 'Setor atualizado com sucesso']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Erro ao atualizar o setor']);
        }
    }

    
} else {
    echo json_encode(['success' => false, 'error' => 'Requisição inválida']);
}
