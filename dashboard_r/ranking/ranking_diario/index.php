<?php
require_once '../../../autentication/index.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../style/dashboard.css?v=3">
    <link rel="stylesheet" href="ranking_diario.css?v=5">
    <title>Ranking Diario</title>
</head>

<body>
    <?php include_once '../../../slide_menu/slide_bar_menu.php' ?>
    <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
        </div>

        <div id="filter">
            <input type="date" id="date-input" name="date">
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
        window.onload = function() {
            var dateInput = document.getElementById('date-input');
            
            // Load content on page load with the current date
            loadContent(new Date().toISOString().slice(0, 10)); 

            dateInput.addEventListener('change', function() {
                var selectedDate = this.value;
                if (selectedDate) {
                    loadContent(selectedDate);
                }
            });

            function loadContent(date) {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'load_content.php?date=' + date, true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        document.getElementById('content').innerHTML = xhr.responseText;
                    }
                };
                xhr.send();
            }
        };
    </script>

    <script src="../../../script/dashboard.js"></script>

</html>
