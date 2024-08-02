<?php

require_once '../../../core/core.php';

$bd = isset($_POST['bd']) ? $_POST['bd'] : '';
$data = isset($_POST['data']) ? $_POST['data'] : '';
$checkboxes = [
    'pnt_ponto' => isset($_POST['ponto']) ? $_POST['ponto'] : null,
    'pnt_atestado' => isset($_POST['atestado']) ? $_POST['atestado'] : null,
    'pnt_falta' => isset($_POST['falta']) ? $_POST['falta'] : null,
];

// Filtra apenas os checkboxes marcados
$checkedItems = array_filter($checkboxes);

// Prepara a consulta SQL
$updates = [];
foreach ($checkedItems as $key => $value) {
    // Subtrai 2 pontos do respectivo campo
    $updates[] = "$key = $key -2";
}
 
// Executa a atualização no banco de dados
if (!empty($updates)) {
    $sql = "UPDATE avaliacao_rh SET " . implode(', ', $updates) . " WHERE id_tecnico = ? AND data_avaliacao = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$bd, $data]); // 'is' significa que estamos esperando um inteiro e uma string

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Dados atualizados com sucesso.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar os dados: ' . $conn->error]);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Nenhum checkbox marcado.']);
}


?>
