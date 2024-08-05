<?php 

require_once "../../../core/core.php";

sleep(2);

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

// Obter o mês atual
$mes_atual = date('Y-m');

// Obter as avaliações dos técnicos para o mês atual
$query_n3 = $pdo->prepare("SELECT id_tecnico, nota_os, pontuacao_os FROM avaliacao_n3 WHERE DATE_FORMAT(data_finalizacao, '%Y-%m') = ?");
$query_n3->execute([$mes_atual]);

$query_sucesso = $pdo->prepare("SELECT ponto_sucesso, id_tecnico FROM avaliacao_sucesso WHERE DATE_FORMAT(data_avaliacao, '%Y-%m') = ?");
$query_sucesso->execute([$mes_atual]);

$query_rh = $pdo->prepare("SELECT pnt_total, id_tecnico, data_avaliacao FROM avaliacao_rh WHERE DATE_FORMAT(data_avaliacao, '%Y-%m') = ?");
$query_rh->execute([$mes_atual]);

$query_estoque = $pdo->prepare("SELECT pnt_total_estoque, id_tecnico_estoque FROM avaliacao_estoque WHERE DATE_FORMAT(data_finalizacao, '%Y-%m') = ?");
$query_estoque->execute([$mes_atual]);

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
            'total_pontuacao' => 0
        ];
    }
    
    if ($ponto_sucesso > 0) {
        $tecnicos_notas[$id_tecnico]['total_nota_sucesso'] += $ponto_sucesso;
        $tecnicos_notas[$id_tecnico]['quantidade_sucesso']++;
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
            'total_pontuacao' => 0
        ];
    }
    
    $tecnicos_notas[$id_tecnico]['total_nota_rh'] += $pnt_total;
    $tecnicos_notas[$id_tecnico]['quantidade_rh']++;
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
            'total_pontuacao' => 0
        ];
    }
    
    $tecnicos_notas[$id_tecnico]['total_nota_estoque'] += $pnt_total_estoque;
    $tecnicos_notas[$id_tecnico]['quantidade_estoque']++;
}

// Calcular a média para cada técnico
foreach ($tecnicos_notas as $id_tecnico => $notas) {
    $media_n3 = $notas['quantidade_n3'] > 0 ? $notas['total_nota_n3'] / $notas['quantidade_n3'] : 0;
    $media_sucesso = $notas['quantidade_sucesso'] > 0 ? $notas['total_nota_sucesso'] / $notas['quantidade_sucesso'] : 0;
    $media_rh = $notas['quantidade_rh'] > 0 ? $notas['total_nota_rh'] / $notas['quantidade_rh'] : 0;
    $media_estoque = $notas['quantidade_estoque'] > 0 ? $notas['total_nota_estoque'] / $notas['quantidade_estoque'] : 0;

    $tecnicos_notas[$id_tecnico]['media'] = round(($media_n3 + $media_sucesso + $media_rh + $media_estoque) / 4, 2);
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

// Separar os 3 primeiros colocados
$top_3 = array_slice($colaboradores, 0, 3);
$restantes = array_slice($colaboradores, 3);

// Conteúdo dinâmico para os 3 primeiros colocados
$top_3_content = '<section class="dashboard-tecnicos-top-3">';
$counter = 1; // Inicializar contador

foreach ($top_3 as $colaborador) {
    $media_nota = $colaborador['media'];
    $soma_pontuacao = $colaborador['total_pontuacao'];

    // Gerar uma classe única para cada colaborador
    $class_suffix = 'top-3-' . $counter;
    
    $top_3_content .= '
        <div class="box-tecnico-top3 ' . $class_suffix . '">
            <div id="tecnico-top3">
                <img src="./assets/deafult-user.png">
                <span>' . $colaborador['nome_colaborador'] . '</span>          
            </div>
            <div class="box-notas-top3">
                <div>
                    <span>Média das Notas: </span>
                    <span>' . $media_nota . '</span> 
                </div>
                <div>
                    <span>Soma das Pontuações: </span>
                    <span>' . $soma_pontuacao . '</span>
                </div>
            </div>
        </div>
    ';
    $counter++; // Incrementar contador
}

$top_3_content .= '</section>';

// Conteúdo dinâmico para os demais colaboradores
$restantes_content = '<section class="dashboard-tecnicos-ranking">';
$lugar = 4;
foreach ($restantes as $colaborador) {
    $media_nota = $colaborador['media'];
    $soma_pontuacao = $colaborador['total_pontuacao'];
    
    $restantes_content .= '
    <div class="box-tecnico">
        <div>
            <div>
                <span>'. $lugar . '°' .' </span>
            </div>
            <div id="tecnico">
                <i class="bx bx-user-circle"></i>
                <span>' . $colaborador['nome_colaborador'] . '</span>          
            </div>
        </div>
        <div class="box-notas">
            <div>
                <span>Média das Notas:  </span>
                <span>' .  $media_nota . '</span> 
            </div>
            <div>
                <span>Soma das Pontuações: </span>
                <span>' . $soma_pontuacao . '</span>
            </div>
        </div>
    </div>';
    $lugar++;
}

$restantes_content .= '</section>';

// Exibir o conteúdo
echo $top_3_content;
echo $restantes_content;

?>
