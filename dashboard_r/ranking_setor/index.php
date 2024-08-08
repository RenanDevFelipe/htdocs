<?php
require_once '../../autentication/index.php';
require_once 'listar_setor.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/dashboard.css">
    <link rel="stylesheet" href="ranking.css">
    <title>Document</title>
</head>
<body>
    <?php include_once '../../slide_menu/slide_bar_menu.php' ?>
    <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
        </div>

        <section class="settings-add-colaborador">
            <div class="title-settings">
                <h1>Ranking - Setores</h1>
            </div>

            <section style="width: 92%;">
            </section>
            <section class="list-colaboradores">
                <?php foreach ($setores as $setor) : ?>
                    <div class='box-colaborador'>

                        <div class="perfil-colaborador">
                            <i class="bx bxs-widget"></i>
                            <a href="redirect.php?id_setor=<?php echo $setor['id_setor'] ?>"><?php echo $setor['nome_setor'] ?></a>
                        </div>
                    </div>
                <?php endforeach ?>
            </section>
    </section>
</body>
<script src="../../script/dashboard.js"></script>
</html>