<?php
require_once '../core/core.php';
session_start();

if (isset($_POST['email_login'], $_POST['senha_login'])) {
    $email = $_POST['email_login'];
    $senha = $_POST['senha_login'];

    $sql = $pdo->prepare("SELECT * FROM users WHERE email_user = ?");
    $sql->execute([$email]);
    $user = $sql->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($senha, $user['senha_user'])) {
            // LOGIN BEM SUCEDIDO
            $_SESSION['user_name'] = $user['nome_user'];
            $_SESSION['user_email'] = $user['email_user'];
            $_SESSION['user_setor'] = $user['setor_user'];

            echo json_encode(['success' => true, 'success' => 'Login bem sucedido']);
            exit;
        } else {
            // SENHA INCORRETA
            echo json_encode(['sucess' => false, 'error' => 'E-mail e/ou senha incorretos']);
            exit;
        }
    } else {

        // USUÀRIO NÂO ENCONTRADO
        echo json_encode(['success' => false, 'error' => 'Preencha todos os campos por favor!!']);
    }
} else {
    echo json_encode(['sucess' => false, 'error' => 'Rquisição inválida']);
}
