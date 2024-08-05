<?php 

require_once '../../../core/core.php';

// Obter o mês e ano atuais
$currentMonth = date('m');
$currentYear = date('Y');

// Selecionar os IDs e nomes dos colaboradores
$sql = $pdo->prepare('SELECT id_colaborador, nome_colaborador FROM colaborador');
$sql->execute();
$colaboradores = $sql->fetchAll();

// Array para armazenar as médias das notas dos colaboradores
$notas_colaboradores = [];

foreach($colaboradores as $colaborador){
    // Consultar a soma das notas e o número de avaliações para o mês atual
    $sql = $pdo->prepare('
        SELECT SUM(nota_os) as total_n3, COUNT(*) as num_avaliacoes
        FROM avaliacao_n3
        WHERE id_tecnico = ? AND MONTH(data_finalizacao) = ? AND YEAR(data_finalizacao) = ?');
    $sql->execute([$colaborador['id_colaborador'], $currentMonth, $currentYear]);
    $nota = $sql->fetch(PDO::FETCH_ASSOC);

    // Calcular a média das notas, definindo 0 se não houver notas
    $media_nota = $nota['num_avaliacoes'] > 0 ? $nota['total_n3'] / $nota['num_avaliacoes'] : 0;

    // Armazenar o nome do colaborador e a média das notas
    $notas_colaboradores[] = [
        'nome_colaborador' => $colaborador['nome_colaborador'],
        'media_nota' => $media_nota
    ];
}

// Classificar as médias em ordem decrescente
usort($notas_colaboradores, function($a, $b) {
    return $b['media_nota'] <=> $a['media_nota'];
});

// HTML para exibir os resultados
?>
