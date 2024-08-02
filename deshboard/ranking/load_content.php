<?php 

require_once "../../core/core.php";

sleep(2);

/// Obter a lista de colaboradores e seus setores
$query = $pdo->prepare("SELECT * FROM colaborador");
$query->execute();

$colaboradores = [];
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $setor = $pdo->prepare('SELECT nome_setor FROM setor WHERE id_setor = ?');
    $setor->execute([$row['setor_colaborador']]);
    $setores = $setor->fetch(PDO::FETCH_ASSOC);
    $colaboradores[] = array_merge($row, $setores);
}

// Obter as avaliações dos técnicos
$query_n3 = $pdo->prepare("SELECT id_tecnico, nota_os, pontuacao_os FROM avaliacao_n3");
$query_n3->execute();

$avaliacoes_n3 = [];
while ($row_n3 = $query_n3->fetch(PDO::FETCH_ASSOC)) {
    $avaliacoes_n3[] = $row_n3;
}

// Calcular soma e média das notas por técnico
$tecnicos_notas = [];
foreach ($avaliacoes_n3 as $avaliacao) {
    $id_tecnico = $avaliacao['id_tecnico'];
    $nota_os = $avaliacao['nota_os'];
    
    if (!isset($tecnicos_notas[$id_tecnico])) {
        $tecnicos_notas[$id_tecnico] = ['total_nota' => 0, 'quantidade' => 0];
    }
    
    $tecnicos_notas[$id_tecnico]['total_nota'] += $nota_os;
    $tecnicos_notas[$id_tecnico]['quantidade']++;
}

foreach ($tecnicos_notas as $id_tecnico => $notas) {
    $tecnicos_notas[$id_tecnico]['media'] = $notas['total_nota'] / $notas['quantidade'];
}

// Conteúdo dinâmico
$content = '<section class="dashboard-tecnicos-ranking">';

foreach ($colaboradores as $colaborador) {
    $id_tecnico = $colaborador['id_colaborador']; // Assumindo que o id_colaborador é o id_tecnico
    
    $media_nota = isset($tecnicos_notas[$id_tecnico]) ? $tecnicos_notas[$id_tecnico]['media'] : 'N/A';
    
    $content .= '
    <div class="box-tecnico">
        <div id="tecnico">
            <i class="bx bx-user-circle"></i>
            <span>' . $colaborador['nome_colaborador'] . '</span>
            <span>' . $media_nota . '</span>
        </div>
    </div>';
}

$content .= '</section>';

echo $content;

?>
