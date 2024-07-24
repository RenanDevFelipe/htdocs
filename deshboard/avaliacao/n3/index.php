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
            foreach ($nomes_clientes as $cliente) :

            ?>
                <p>
                    <?php echo $cliente ?>
                </p>

            <?php endforeach ?>
        </section>
    </section>


</body>

<script src="../../../script/dashboard.js?v=1"></script>

</html>