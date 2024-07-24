<?php
require_once "../../../autentication/index.php";
require_once "../../../slide_menu/slide_bar_menu.php";
require_once "../../../api/listar_os.php";
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../style/dashboard.css?v=2">
    <link rel="stylesheet" href="index.css">
    <title>Document</title>
</head>

<body>
    <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
        </div>
        <section class="dashboard-tecnicos-ranking">

            <?php
            foreach (zip($desc_os, $nomes_clientes, $fechamento_os, $id_os_ixc, $id_cliente) as $pair) :
                list($desc, $cliente, $fechamento, $id, $id_cliente) = $pair;
            ?>
                <div class="box-tecnico">
                    <div id="tecnico">
                        <div>
                            <p> <?php echo $id ?> </p>
                            <p> <?php echo $fechamento ?> </p>                          
                        </div>
                        <p> <?php echo $id_cliente . ' - ' . $cliente ?> </p>                      
                    </div>
                    <div class="avaliar">
                        <div>
                            <i class="bx bx-collection"></i>
                            <a href="./avaliacao/redirect.php?id_colaborador=<?php echo $colaboradores['id_ixc'] ?>">Detalhes</a>
                        </div>
                        <div>
                            <i class="bx bx-star"></i>
                            <a href="./avaliacao/redirect.php?id_colaborador=<?php echo $colaboradores['id_ixc'] ?>">Avaliar</a>
                        </div>
                    </div>
                </div>

            <?php endforeach ?>
        </section>
    </section>


</body>

<script src="../../../script/dashboard.js?v=1"></script>

</html>