<?php

require_once '../../../autentication/index.php';
require_once 'get_ranking.php';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../style/dashboard.css">
    <link rel="stylesheet" href="ranking.css?v=1">
    <title>Ranking - Estoque</title>
</head>

<body>
    <?php require_once '../../../slide_menu/slide_bar_menu.php' ?>
    <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
        </div>

        <section class="top3-colocados">
            <div class="list-colocados">

                <?php if (isset($notas_colaboradores[1])) : ?>
                    <div class="top3-cards prata">
                        <p>2°</p>
                        <img src="./upload/teste_rankig.png" alt="" style="width: 110px; height: 110px;">
                        <b><?php echo $notas_colaboradores[1]['nome_colaborador']; ?></b>
                        <p class="nota"><?php echo $notas_colaboradores[1]['media_nota']; ?> ⭐</p>
                    </div>
                <?php endif; ?>

                <?php if (isset($notas_colaboradores[0])) : ?>
                    <div class="top3-cards golden">
                        <p>1°</p>
                        <img src="./upload/teste_rankig.png" alt="" style="width: 120px; height: 120px;">
                        <b><?php echo $notas_colaboradores[0]['nome_colaborador']; ?></b>
                        <p class="nota"><?php echo $notas_colaboradores[0]['media_nota']; ?> ⭐</p>
                    </div>
                <?php endif; ?>

                <?php if (isset($notas_colaboradores[2])) : ?>
                    <div class="top3-cards bronze">
                        <p>3°</p>
                        <img src="./upload/teste_rankig.png" alt="">
                        <b><?php echo $notas_colaboradores[2]['nome_colaborador']; ?></b>
                        <p class="nota"><?php echo $notas_colaboradores[2]['media_nota']; ?> ⭐</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <section class="classificados-list">
            <div class="listagem-boxes">
                <?php foreach ($notas_colaboradores as $index => $colaborador) : ?>
                    <div class="box-classificacao">


                        <div class="div-1">
                            <div><?php echo $index + 1; ?>º</div>
                            <img src="./upload/teste_rankig.png" alt="">
                            <b><?php echo $colaborador['nome_colaborador']; ?></b>
                        </div>

                        <div class="Pontos">
                            <p class="nota"><?php echo $colaborador['media_nota'] ?> ⭐</p>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        </section>

    </section>
</body>
<script src="../../../script/dashboard.js"></script>

</html>