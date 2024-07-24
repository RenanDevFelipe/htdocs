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
    <link rel="stylesheet" href="../../../style/dashboard.css?v=1">
    <title>Document</title>
</head>

<body>
    <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
        </div>
        <section>

            <?php
            foreach (zip($desc_os, $nomes_clientes, $fechamento_os, $id_os_ixc) as $pair) :
                list($desc, $cliente, $fechamento, $id) = $pair;
            ?>
                <p><?php echo $id ?></p>
                
                <p>
                    <?php echo $cliente ?>
                </p>

                <p><?php echo $desc ?></p>

                <p><?php echo $fechamento ?></p>

            <?php endforeach ?>
        </section>
    </section>


</body>

<script src="../../../script/dashboard.js?v=1"></script>

</html>