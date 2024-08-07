<?php
require_once '../../../core/core.php'; // Verifique o caminho para o arquivo de conexão

header('Content-Type: application/json');

$response = array('success' => false, 'message' => '');
$missing_fields = array();

$idOS = $_GET['idOS'];

// Verifica se a requisição é do tipo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se todos os campos necessários estão presentes e não estão vazios
    $required_fields = array(
        'descOS_'.$idOS,
        'fechamentoOS_'.$idOS,
        'formId_'.$idOS,
        'notaOS_'.$idOS,
        'pontuacaoOS_'.$idOS,
        'setor_'.$idOS,
        'idTecnico_'.$idOS
    );

    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            $missing_fields[] = $field;
        }
    }

    if (empty($missing_fields)) {
        // Escapa a entrada do usuário para evitar injeção de SQL
        $obs = htmlspecialchars(trim($_POST['obs_'.$idOS]));
        $desc = htmlspecialchars(trim($_POST['descOS_'.$idOS]));
        $fechamento = htmlspecialchars(trim($_POST['fechamentoOS_'.$idOS]));
        $formId = htmlspecialchars(trim($_POST['formId_'.$idOS]));
        $notaOS = htmlspecialchars(trim($_POST['notaOS_'.$idOS]));
        $pontuacao = htmlspecialchars(trim($_POST['pontuacaoOS_'.$idOS]));
        $setor = htmlspecialchars(trim($_POST['setor_'.$idOS]));
        $dataAvaliacao = date('Y-m-d');
        $idTecnico = htmlspecialchars(trim($_POST['idTecnico_'.$idOS]));

        try {
            // Consulta para verificar se o colaborador já existe
            $sql = $pdo->prepare('SELECT * FROM avaliacao_n3 WHERE id_os = ?');
            $sql->execute([$idOS]);

            if ($sql->rowCount() > 0) {
                $response['message'] = 'Avaliação ja existe!';
            } else {
                // Insere o novo colaborador no banco de dados
                $insert = $pdo->prepare('INSERT INTO avaliacao_n3 (id_os, desc_os, pontuacao_os, nota_os, data_finalizacao_os, data_finalizacao, id_tecnico, id_setor) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
                if ($insert->execute([$idOS, $desc, $pontuacao, $notaOS, $fechamento, $dataAvaliacao, $idTecnico, $setor])) {
                    $response['success'] = true;
                    $response['message'] = 'Avaliação feita com sucesso!';
                } else {
                    $response['message'] = 'Erro ao avaliar!';
                }
            }
        } catch (PDOException $e) {
            $response['message'] = 'Erro de conexão: ' . $e->getMessage();
        }
    } else {
        // Campo necessário não foi preenchido
        $response['message'] = 'Preencha todos os campos por favor!';
        $response['missing_fields'] = $missing_fields;
    }
} else {
    // Requisição não é do tipo POST
    $response['message'] = 'Requisição inválida';
}

// Retorna a resposta em formato JSON
echo json_encode($response);
?>
