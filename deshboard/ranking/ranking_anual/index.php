<?php
require_once '../../../autentication/index.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../style/dashboard.css?v=5">
    <link rel="stylesheet" href="ranking_diario.css?v=4">
    <title>Ranking Diario</title>
</head>

<body>
    <?php include_once '../../../slide_menu/slide_bar_menu.php' ?>
    <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
            <i onclick="redirectToPage('../anual_porcentagem/')" class="bx bx-bar-chart-alt-2"></i>
        </div>

        <div id="content">
            <div class="content-box">
                <div class="loader-tres-pontinhos">

                    <span></span>
                    <span></span>
                    <span></span>

                </div>

                
            </div>
        </div>

    </section>


    <script>
        function redirectToPage(url) {
            window.location.href = url;
        }

        window.onload = function() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'load_content.php', true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('content').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        };

        
    </script>

    <script src="../../../script/dashboard.js"></script>

</html>