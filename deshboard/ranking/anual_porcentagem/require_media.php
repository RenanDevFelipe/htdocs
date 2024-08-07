<?php 
require_once '../../../core/core.php';

// Obter a lista de colaboradores e seus setores
$query = $pdo->prepare("SELECT * FROM colaborador");
$query->execute();

$colaboradores = [];
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $setor = $pdo->prepare('SELECT nome_setor FROM setor WHERE id_setor = ?');
    $setor->execute([$row['setor_colaborador']]);
    $setores = $setor->fetch(PDO::FETCH_ASSOC);
    $colaboradores[] = array_merge($row, $setores);
}

// Obter o ano atual
$ano_atual = date('Y');

// Obter as avaliações dos técnicos para o ano atual
$query_n3 = $pdo->prepare("SELECT id_tecnico, nota_os, pontuacao_os FROM avaliacao_n3 WHERE DATE_FORMAT(data_finalizacao, '%Y') = ?");
$query_n3->execute([$ano_atual]);

$query_sucesso = $pdo->prepare("SELECT ponto_sucesso, id_tecnico FROM avaliacao_sucesso WHERE DATE_FORMAT(data_avaliacao, '%Y') = ?");
$query_sucesso->execute([$ano_atual]);

$query_rh = $pdo->prepare("SELECT pnt_total, id_tecnico, data_avaliacao FROM avaliacao_rh WHERE DATE_FORMAT(data_avaliacao, '%Y') = ?");
$query_rh->execute([$ano_atual]);

$query_estoque = $pdo->prepare("SELECT pnt_total_estoque, id_tecnico_estoque FROM avaliacao_estoque WHERE DATE_FORMAT(data_finalizacao, '%Y') = ?");
$query_estoque->execute([$ano_atual]);

$query_n2 = $pdo->prepare("SELECT ponto_total, id_tecnico_n2 FROM avaliacao_n2 WHERE DATE_FORMAT(data_finalizacao, '%Y') = ?");
$query_n2->execute([$ano_atual]);

$avaliacoes_sucesso = [];
while ($row_sucesso = $query_sucesso->fetch(PDO::FETCH_ASSOC)) {
    $avaliacoes_sucesso[] = $row_sucesso;
}

$avaliacoes_n3 = [];
while ($row_n3 = $query_n3->fetch(PDO::FETCH_ASSOC)) {
    $avaliacoes_n3[] = $row_n3;
}

$avaliacoes_rh = [];
while ($row_rh = $query_rh->fetch(PDO::FETCH_ASSOC)) {
    $avaliacoes_rh[] = $row_rh;
}

$avaliacoes_estoque = [];
while ($row_estoque = $query_estoque->fetch(PDO::FETCH_ASSOC)) {
    $avaliacoes_estoque[] = $row_estoque;
}

$avaliacoes_n2 = [];
while ($row_n2 = $query_n2->fetch(PDO::FETCH_ASSOC)) {
    $avaliacoes_n2[] = $row_n2;
}

// Combinar avaliações por técnico
$tecnicos_notas = [];
foreach ($avaliacoes_n3 as $avaliacao) {
    $id_tecnico = $avaliacao['id_tecnico'];
    $nota_os = $avaliacao['nota_os'];
    $pontuacao_os = $avaliacao['pontuacao_os'];
    
    if (!isset($tecnicos_notas[$id_tecnico])) {
        $tecnicos_notas[$id_tecnico] = [
            'total_nota_n3' => 0,
            'quantidade_n3' => 0,
            'total_nota_sucesso' => 0,
            'quantidade_sucesso' => 0,
            'total_nota_rh' => 0,
            'quantidade_rh' => 0,
            'total_nota_estoque' => 0,
            'quantidade_estoque' => 0,
            'total_nota_n2' => 0,
            'quantidade_n2' => 0,
            'total_pontuacao' => 0
        ];
    }
    
    $tecnicos_notas[$id_tecnico]['total_nota_n3'] += $nota_os;
    $tecnicos_notas[$id_tecnico]['total_pontuacao'] += $pontuacao_os;
    $tecnicos_notas[$id_tecnico]['quantidade_n3']++;
}

foreach ($avaliacoes_sucesso as $avaliacao_sucesso) {
    $id_tecnico = $avaliacao_sucesso['id_tecnico'];
    $ponto_sucesso = $avaliacao_sucesso['ponto_sucesso'];
    
    if (!isset($tecnicos_notas[$id_tecnico])) {
        $tecnicos_notas[$id_tecnico] = [
            'total_nota_n3' => 0,
            'quantidade_n3' => 0,
            'total_nota_sucesso' => 0,
            'quantidade_sucesso' => 0,
            'total_nota_rh' => 0,
            'quantidade_rh' => 0,
            'total_nota_estoque' => 0,
            'quantidade_estoque' => 0,
            'total_nota_n2' => 0,
            'quantidade_n2' => 0,
            'total_pontuacao' => 0
        ];
    }
    
    if ($ponto_sucesso > 0) {
        $tecnicos_notas[$id_tecnico]['total_nota_sucesso'] += $ponto_sucesso;
        $tecnicos_notas[$id_tecnico]['quantidade_sucesso']++;
        $tecnicos_notas[$id_tecnico]['total_pontuacao'] += $ponto_sucesso;
    }
}

foreach ($avaliacoes_rh as $avaliacao_rh) {
    $id_tecnico = $avaliacao_rh['id_tecnico'];
    $pnt_total = $avaliacao_rh['pnt_total'];
    
    if (!isset($tecnicos_notas[$id_tecnico])) {
        $tecnicos_notas[$id_tecnico] = [
            'total_nota_n3' => 0,
            'quantidade_n3' => 0,
            'total_nota_sucesso' => 0,
            'quantidade_sucesso' => 0,
            'total_nota_rh' => 0,
            'quantidade_rh' => 0,
            'total_nota_estoque' => 0,
            'quantidade_estoque' => 0,
            'total_nota_n2' => 0,
            'quantidade_n2' => 0,
            'total_pontuacao' => 0
        ];
    }
    
    $tecnicos_notas[$id_tecnico]['total_nota_rh'] += $pnt_total;
    $tecnicos_notas[$id_tecnico]['quantidade_rh']++;
    $tecnicos_notas[$id_tecnico]['total_pontuacao'] += $pnt_total;
}

foreach ($avaliacoes_estoque as $avaliacao_estoque) {
    $id_tecnico = $avaliacao_estoque['id_tecnico_estoque'];
    $pnt_total_estoque = $avaliacao_estoque['pnt_total_estoque'];
    
    if (!isset($tecnicos_notas[$id_tecnico])) {
        $tecnicos_notas[$id_tecnico] = [
            'total_nota_n3' => 0,
            'quantidade_n3' => 0,
            'total_nota_sucesso' => 0,
            'quantidade_sucesso' => 0,
            'total_nota_rh' => 0,
            'quantidade_rh' => 0,
            'total_nota_estoque' => 0,
            'quantidade_estoque' => 0,
            'total_nota_n2' => 0,
            'quantidade_n2' => 0,
            'total_pontuacao' => 0
        ];
    }
    
    $tecnicos_notas[$id_tecnico]['total_nota_estoque'] += $pnt_total_estoque;
    $tecnicos_notas[$id_tecnico]['quantidade_estoque']++;
    $tecnicos_notas[$id_tecnico]['total_pontuacao'] += $pnt_total_estoque;
}

foreach ($avaliacoes_n2 as $avaliacao_n2) {
    $id_tecnico = $avaliacao_n2['id_tecnico_n2'];
    $ponto_total = $avaliacao_n2['ponto_total'];
    
    if (!isset($tecnicos_notas[$id_tecnico])) {
        $tecnicos_notas[$id_tecnico] = [
            'total_nota_n3' => 0,
            'quantidade_n3' => 0,
            'total_nota_sucesso' => 0,
            'quantidade_sucesso' => 0,
            'total_nota_rh' => 0,
            'quantidade_rh' => 0,
            'total_nota_estoque' => 0,
            'quantidade_estoque' => 0,
            'total_nota_n2' => 0,
            'quantidade_n2' => 0,
            'total_pontuacao' => 0
        ];
    }
    
    $tecnicos_notas[$id_tecnico]['total_nota_n2'] += $ponto_total;
    $tecnicos_notas[$id_tecnico]['quantidade_n2']++;
    $tecnicos_notas[$id_tecnico]['total_pontuacao'] += $ponto_total;
}

// Calcular a média das notas e total de pontuação para cada técnico
foreach ($tecnicos_notas as $id_tecnico => &$notas) {
    $media_n3 = $notas['quantidade_n3'] > 0 ? $notas['total_nota_n3'] / $notas['quantidade_n3'] : 0;
    $media_sucesso = $notas['quantidade_sucesso'] > 0 ? $notas['total_nota_sucesso'] / $notas['quantidade_sucesso'] : 0;
    $media_rh = $notas['quantidade_rh'] > 0 ? $notas['total_nota_rh'] / $notas['quantidade_rh'] : 0;
    $media_estoque = $notas['quantidade_estoque'] > 0 ? $notas['total_nota_estoque'] / $notas['quantidade_estoque'] : 0;
    $media_n2 = $notas['quantidade_n2'] > 0 ? $notas['total_nota_n2'] / $notas['quantidade_n2'] : 0;

    // Ajustar médias para a escala de 10
    $media_n3 = min($media_n3, 10);
    $media_sucesso = min($media_sucesso, 10);
    $media_rh = min($media_rh, 10);
    $media_estoque = min($media_estoque, 10);
    $media_n2 = min($media_n2, 10);

    $notas['media'] = round(($media_n3 + $media_sucesso + $media_rh + $media_estoque + $media_n2) / 5, 2);
}

// Associar médias e pontuações aos colaboradores
foreach ($colaboradores as &$colaborador) {
    $id_tecnico = $colaborador['id_colaborador'];
    $colaborador['media'] = isset($tecnicos_notas[$id_tecnico]) ? $tecnicos_notas[$id_tecnico]['media'] : 0;
    $colaborador['total_pontuacao'] = isset($tecnicos_notas[$id_tecnico]) ? $tecnicos_notas[$id_tecnico]['total_pontuacao'] : 0;
}
unset($colaborador); // Desvincular referência

// Ordenar colaboradores pela maior média e pela soma dos pontos (em caso de empate)
usort($colaboradores, function($a, $b) {
    // Primeiro critério: média em ordem decrescente
    if ($a['media'] != $b['media']) {
        return $b['media'] <=> $a['media'];
    }
    // Segundo critério: soma dos pontos em ordem decrescente
    return $b['total_pontuacao'] <=> $a['total_pontuacao'];
});
?>