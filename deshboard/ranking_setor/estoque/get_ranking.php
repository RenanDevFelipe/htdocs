<?php 

require_once '../../../core/core.php';

// Obter o mês e ano atuais
$currentMonth = date('m');
$currentYear = date('Y');

// Selecionar os IDs e nomes dos colaboradores
$sql = $pdo->prepare('SELECT id_colaborador, nome_colaborador FROM colaborador');
$sql->execute();
$colaboradores = $sql->fetchAll();

// Array para armazenar as notas dos colaboradores
$notas_colaboradores = [];

foreach($colaboradores as $colaborador){
    // Consultar a soma das notas no estoque para o mês atual
    $sql = $pdo->prepare('
        SELECT SUM(pnt_total_estoque) as total_estoque
        FROM avaliacao_estoque
        WHERE id_tecnico_estoque = ? AND MONTH(data_finalizacao) = ? AND YEAR(data_finalizacao) = ?');
    $sql->execute([$colaborador['id_colaborador'], $currentMonth, $currentYear]);
    $nota = $sql->fetch(PDO::FETCH_ASSOC);

    // Armazenar o nome do colaborador e a nota, definindo 0 se não houver nota
    $notas_colaboradores[] = [
        'nome_colaborador' => $colaborador['nome_colaborador'],
        'total_estoque' => $nota['total_estoque'] !== null ? $nota['total_estoque'] : 0
    ];
}

// Classificar as notas em ordem decrescente
usort($notas_colaboradores, function($a, $b) {
    return $b['total_estoque'] <=> $a['total_estoque'];
});

// HTML para exibir os resultados
?>
