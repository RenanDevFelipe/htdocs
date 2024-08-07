<?php
require_once '../../../autentication/index.php';
require_once 'require_media.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Avaliação de Técnicos</title>
    <link rel="stylesheet" href="../../../style/dashboard.css">
    <link rel="stylesheet" href="porcentagem.css?v=1">

</head>

<body>
    <?php include_once '../../../slide_menu/slide_bar_menu.php' ?>
    <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
            <i onclick="redirectToPage('../ranking_anual/')" class="bx bx-arrow-back"></i>
        </div>

        <section class="list-card-porcentagem">
            <div class="title">
                <h1>Média Anual do Técnico</h1>
            </div>

            <div class="container-list">
                <div class="container-card-porcentagem">
                    <?php foreach($colaboradores as $colaborador): ?>
                    <?php
                    // Valor do progresso
                        $media = $colaborador['media'];
                        $progress = $media * 10; // Exemplo de progresso, normalmente viria do seu banco de dados
                    ?>
                    <div class="cards">
                        <div>
                            <p><?php echo $colaborador['nome_colaborador']?></p>
                        </div>

                        <div>
                            <div class="progress-circle">
                                <div class="progress" style="--progress: <?php echo $progress; ?>%;" title="<?php echo $progress . '%'?>">
                                    <span><?php echo $media ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach?>
                </div>
            </div>
        </section>
    </section>
</body>
<script src="../../../script/dashboard.js"></script>

<script>
    function redirectToPage(url) {
            window.location.href = url;
        }
</script>

</html>