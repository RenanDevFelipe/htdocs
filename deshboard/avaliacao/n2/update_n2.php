<?php

require_once '../../../core/core.php';

$bd = isset($_POST['bd']) ? $_POST['bd'] : '';
$data = isset($_POST['data']) ? $_POST['data'] : '';
$checkboxes = [
    'ponto_finalizacao_os' => isset($_POST['pedido']) ? $_POST['pedido'] : null,
    'ponto_lavagem_carro' => isset($_POST['material']) ? $_POST['material'] : null,
    'organizacao_material' => isset($_POST['almoxarifado']) ? $_POST['almoxarifado'] : null,
    'ponto_fardamento' => isset($_POST['fora_prazo']) ? $_POST['fora_prazo'] : null,
];

// Filtra apenas os checkboxes marcados
$checkedItems = array_filter($checkboxes);

// Prepara a consulta SQL
$updates = [];
foreach ($checkedItems as $key => $value) {
    // Subtrai 2 pontos do respectivo campo
    $updates[] = "$key = 0";
}

// Executa a atualização no banco de dados
if (!empty($updates)) {
    $sql = "UPDATE avaliacao_n2 SET " . implode(', ', $updates) . " WHERE id_tecnico_n2 = ? AND data_finalizacao = ?";
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
