<?php 

require_once "../core/core.php";
require_once "../api/os_finalizada_do_dia.php";
require_once "../api/os_aberta_do_dia.php";

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

// Conteúdo dinâmico
$content = '
<section class="Deashboard-home-os">
    <div class="os-identidficador" id="osAbertaDia">
        <p class="title-os">O.S Abertas</p>
        <h1 id="quantidade-os">' . $total_os_do_dia->total . '</h1>
    </div>
    <div class="os-identidficador" id="osFechadaDia">
        <p class="title-os">O.S Finalizadas</p>
        <h1 id="quantidade-os">' . $total_os_finalizada_do_dia->total . '</h1>
    </div>
</section>
<section class="dashboard-tecnicos-ranking">';

foreach ($colaboradores as $colaborador) {
    $content .= '
    <div class="box-tecnico">
        <div id="tecnico">
            <i class="bx bx-user-circle"></i>
            <span>' . $colaborador['nome_colaborador'] . '</span>
        </div>
        <div class="avaliar">
            <i class="bx bx-star"></i>
            <a href="./avaliacao/redirect.php?id_colaborador=' . $colaborador['id_ixc'] . '">Avaliar</a>
        </div>
    </div>';
}

$content .= '</section>';

echo $content;
?>
