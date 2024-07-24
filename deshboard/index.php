<?php
require_once "../core/core.php";
include '../autentication/index.php';
require_once "../api/os_finalizada_do_dia.php";
require_once "../api/os_aberta_do_dia.php"
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style/os_identificador.css">
    <title>Rápida, Prática e Descomplicada</title>
</head>

<body>
    <?php include_once '../slide_menu/slide_bar_menu.php' ?>
    <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
        </div>

        <section class="Deashboard-home-os">

            <div class="os-identidficador" id="osAbertaDia">
                <p class="title-os">O.S Abertas</p>
                <h1 id="quantidade-os"><?php echo $total_os_do_dia->total ?></h1>
            </div>

            <div class="os-identidficador" id="osFechadaDia">
                <p class="title-os">O.S Finalizadas</p>
                <h1 id="quantidade-os"><?php echo $total_os_finalizada_do_dia->total ?></h1>
            </div>
        </section>
        <section class="dashboard-tecnicos-ranking">
            <?php
            $query = $pdo->prepare("SELECT * FROM colaborador");
            $query->execute();

            while ($colaboradores = $query->fetch(PDO::FETCH_ASSOC)) {
                $setor = $pdo->prepare('SELECT nome_setor FROM setor WHERE id_setor = ?');
                $setor->execute([$colaboradores['setor_colaborador']]);
                $setores = $setor->fetch(PDO::FETCH_ASSOC)
            ?>


                <div class="box-tecnico">
                    <div id="tecnico">
                        <i class="bx bx-user-circle"></i>
                        <span><?php echo $colaboradores['nome_colaborador'] ?></span>
                    </div>
                    <div class="avaliar">
                        <i class="bx bx-star"></i>
                        <a href="">Avaliar</a>
                    </div>
                </div>

            <?php
            }
            ?>

        </section>
    </section>
</body>

<script src="/script/dashboard.js?v=1"></script>

</html>