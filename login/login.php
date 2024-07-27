<?php
require_once '../core/core.php';
session_start();

if(isset($_POST['email_login'], $_POST['senha_login'])){
    $email = $_POST['email_login'];
    $senha = $_POST['senha_login'];

    $sql = $pdo->prepare("SELECT * FROM users WHERE email_user = ?");
    $sql->execute([$email]);
    $user = $sql->fetch(PDO::FETCH_ASSOC);

    if($user){
        if (password_verify($senha, $user['senha_user'])){
            // LOGIN BEM SUCEDIDO
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['user_name'] = $user['nome_user'];
            $_SESSION['user_email'] = $user['email_user'];
            $_SESSION['user_setor'] = $user['setor_user'];
            $_SESSION['user_role'] = $user['role'];

            $setor = $pdo->prepare('SELECT nome_setor FROM setor WHERE id_setor = ?');
            $setor->execute([$_SESSION['user_setor']]);

            $str = $setor->fetch(PDO::FETCH_ASSOC);

            $_SESSION['setor'] = $str['nome_setor'];

            echo json_encode(['success' => true, 'success' => 'Login realizado']);
            exit;

    } else{
            // SENHA INCORRETA
            echo json_encode(['sucess' => false, 'error' => 'E-mail e/ou senha incorretos']);
            exit;            
    }
    
 }else{

    // USUÀRIO NÂO ENCONTRADO
    echo json_encode(['success' => false, 'error' => 'Usuário não encontrado!!']);

 }
} else{
    echo json_encode(['sucess' => false, 'error' => 'Rquisição inválida']);
}

?>