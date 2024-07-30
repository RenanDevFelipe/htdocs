<?php

require_once '../../../core/core.php';

$bd = isset($_POST['bd']) ? $_POST['bd'] : '';
$data = isset($_POST['data']) ? $_POST['data'] : '';
$checkboxes = [
    'pnt_pedido' => isset($_POST['pedido']) ? $_POST['pedido'] : null,
    'pnt_prazo' => isset($_POST['material']) ? $_POST['material'] : null,
    'pnt_etiqueta' => isset($_POST['almoxarifado']) ? $_POST['almoxarifado'] : null,
    'pnt_baixa_mat' => isset($_POST['fora_prazo']) ? $_POST['fora_prazo'] : null,
    'pnt_troca_equip' => isset($_POST['sem_etiqueta']) ? $_POST['sem_etiqueta'] : null,
    'pnt_transferencia' => isset($_POST['sem_identificacao']) ? $_POST['sem_identificacao'] : null,
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
    $sql = "UPDATE avaliacao_estoque SET " . implode(', ', $updates) . " WHERE id_tecnico_estoque = ? AND data_finalizacao = ?";
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
