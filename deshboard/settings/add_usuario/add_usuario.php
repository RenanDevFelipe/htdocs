<?php

require_once '../../../core/core.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (empty($_POST['nomeUser'])) {
        echo json_encode(['success' => false, 'message' => 'Nome do usuário é obrigatório']);
        exit;
    }

    if (empty($_POST['emailUser']) || !filter_var($_POST['emailUser'], FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'E-mail inválido']);
        exit;
    }

    if (empty($_POST['passUser']) || strlen($_POST['passUser']) < 8) {
        echo json_encode(['success' => false, 'message' => 'A senha deve ter pelo menos 8 caracteres.']);
        exit;
    }

    if (empty($_POST['roleUser'])) {
        echo json_encode(['success' => false, 'message' =>  'Perfil é Obrigatório.']);
        exit;
    }

    if (empty($_POST['setorUser'])) {
        echo json_encode(['success' => false, 'message' => 'O setor é obrigatório.']);
        exit;
    }

    // CAPTURAR DATAS DO FORM
    $nome_user = htmlspecialchars($_POST['nomeUser']);
    $email_user = htmlspecialchars($_POST['emailUser']);
    $senha_user = password_hash($_POST['passUser'], PASSWORD_DEFAULT);
    $role = htmlspecialchars($_POST['roleUser']);
    $setor_user = htmlspecialchars($_POST['setorUser']);

    try {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email_user = :email_user");
        $stmt->execute(['email_user' => $email_user]);
        if ($stmt->fetchColumn() > 0) {
            echo json_encode(['success' => false, 'messages' => ["Email já cadastrado."]]);
            exit;
        }

        // Insert user data into the database
        $sql = "INSERT INTO users (nome_user, email_user, senha_user, role, setor_user) VALUES (:nome_user, :email_user, :senha_user, :role, :setor_user)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'nome_user' => $nome_user,
            'email_user' => $email_user,
            'senha_user' => $senha_user,
            'role' => $role,
            'setor_user' => $setor_user
        ]);

        echo json_encode(['success' => true, 'message' => 'Usuário adicionado com sucesso.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erro ao adicionar usuário: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método de requisição inválido.']);
}
?>
