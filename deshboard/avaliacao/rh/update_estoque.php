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

// Extrair mês e ano da data recebida via POST
$data_parts = explode('-', $data);
$year = $data_parts[0];
$month = $data_parts[1];

// Prepara a consulta SQL
$updates = [];
foreach ($checkedItems as $key => $value) {
    // Subtrai 2 pontos do respectivo campo
    $updates[] = "$key = $key - 2";
}

// Executa a atualização no banco de dados
if (!empty($updates)) {
    $sql = "UPDATE avaliacao_rh SET " . implode(', ', $updates) . " WHERE id_tecnico = ? AND MONTH(data_avaliacao) = ? AND YEAR(data_avaliacao) = ?";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$bd, $month, $year])) {
        echo json_encode(['success' => true, 'message' => 'Dados atualizados com sucesso.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar os dados: ' . $stmt->errorInfo()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Nenhum checkbox marcado.']);
}

?>
