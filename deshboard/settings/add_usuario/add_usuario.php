<?php 
 
 require_once '../../../core/core.php';

 if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(empty($_POST['nomeUser'])){
        echo json_encode(['success' => false, 'message' => 'Nome do usuário é obrigatório']);
        exit;
    }

    if(empty($_POST['emailUser']) || !filter_var($_POST['emailUser'], FILTER_VALIDATE_EMAIL)){
        echo json_encode(['success' => false, 'message' => 'E-mail inválido']);
        exit;
    }

    if(empty($_POST['passUser']) || strlen($_POST['passUser']) < 8){
        echo json_encode(['success' => false, 'message' => 'A senha deve ter pelo menos 8 caracteres.']);
        exit;
    }

    if(empty($_POST['roleUser'])){
        echo json_encode(['success' => false, 'message' =>  'Perfil é Obrigatório.']);
        exit;
    }

    if(empty($_POST['setorUser'])){
        echo json_encode(['success' => false, 'message' => 'O setor é obrigatório.']);
        exit;
    }

 }

?>