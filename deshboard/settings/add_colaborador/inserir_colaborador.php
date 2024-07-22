<?php
require_once '../../../core/core.php'; // Verifique o caminho para o arquivo de conexão

header('Content-Type: application/json');

$response = array('success' => false, 'message' => '');

// Verifica se a requisição é do tipo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se o campo 'nome_setor' foi enviado e não está vazio
    if (isset($_POST['nome_colaborador']) && !empty($_POST['nome_colaborador']) && isset($_POST['id_ixc']) && !empty($_POST['id_ixc'] && isset($_POST['nome_setor']) && !empty($_POST['nome_setor']) )) {
        // Escapa a entrada do usuário para evitar injeção de SQL
        $colaborador = htmlspecialchars(trim($_POST['nome_colaborador']));
        $idIxc = htmlspecialchars(trim($_POST['id_ixc']));
        $setor = htmlspecialchars(trim($_POST['nome_setor']));
        // Verifica se a variável $pdo está definida e conectada
        if (!isset($pdo)) {
            $response['message'] = 'Erro de conexão com o banco de dados.';
        } else {
            try {
                // Consulta para verificar se o setor já existe
                $sql = $pdo->prepare('SELECT * FROM colaborador WHERE nome_colaborador = ? AND id_ixc = ? AND setor_colaborador = ?');
                $sql->execute([$colaborador,$idIxc,$setor]);

                if ($sql->rowCount() > 0) {
                    $response['message'] = 'Colaborador já está cadastrado!';
                } else {
                    // Insere o novo setor no banco de dados
                    $insert = $pdo->prepare('INSERT INTO colaborador (nome_colaborador,id_ixc,setor_colaborador) VALUES (?,?,?)');
                    if ($insert->execute([$nome_colaborador,$id_ixc,$setor_colaborador])) {
                        $response['success'] = true;
                        $response['message'] = 'Colaborador adicionado com sucesso';
                    } else {
                        $response['message'] = 'Erro ao adicionar Colaborador!';
                    }
                }
            } catch (PDOException $e) {
                $response['message'] = 'Erro de conexão: ' . $e->getMessage();
            }
        }
    } else {
        // Campo 'nome_setor' está vazio
        $response['message'] = 'Preencha todos os campos por favor!';
    }
} else {
    // Requisição não é do tipo POST
    $response['message'] = 'Requisição inválida';
}

// Retorna a resposta em formato JSON
echo json_encode($response);
?>
