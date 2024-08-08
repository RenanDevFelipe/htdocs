<?php
require_once '../../../autentication/index.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../style/dashboard.css?v=5">
    <link rel="stylesheet" href="ranking_diario.css?v=5">
    <title>Ranking Mensal</title>
</head>

<body>
    <?php include_once '../../../slide_menu/slide_bar_menu.php' ?>
    <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
            <i onclick="redirectToPage('../mensal_porcentagem/')" class="bx bx-bar-chart-alt-2"></i>
        </div>

        <div id="filter">
            <input type="month" id="date-input" name="date">
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

        function loadContent(date) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'load_content.php?data=' + date, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('content').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        window.onload = function() {
            var dateInput = document.getElementById('date-input');

            // Load content on page load with the current date
            var today = new Date().toISOString().slice(0, 7); // format YYYY-MM
            loadContent(today);

            dateInput.addEventListener('change', function() {
                var selectedDate = this.value;
                if (selectedDate) {
                    loadContent(selectedDate);
                }
            });
        };
    </script>

    <script src="../../../script/dashboard.js"></script>

</html>
