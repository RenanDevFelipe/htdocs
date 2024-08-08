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
                    <?php foreach ($colaboradores as $colaborador) : ?>
                        <?php
                        // Valor do progresso
                        $media = $colaborador['media'];
                        $progress = $media * 10; // Exemplo de progresso, normalmente viria do seu banco de dados
                        if($progress >= 0 && $progress <= 50){
                            $colorProgress = 'red';
                        }

                        elseif($progress > 50 && $progress <= 80){
                                $colorProgress = '#dc9900';
                        }

                        elseif($progress > 80 && $progress <= 99){
                            $colorProgress = '#008000';
                        }
                        else{
                            $colorProgress = '#00bfff';
                        }
                        ?>
                        <div class="cards">
                            <div>
                                <p><?php echo $colaborador['nome_colaborador'] ?></p>
                            </div>

                            <div>
                                <div class="progress-circle">
                                    <div class="progress" style="--progress: <?php echo $progress; ?>%; --colorProgress: <?php echo $colorProgress ?> ;" title="<?php echo 'Média: ' . $media ?>">
                                        <span><?php echo $progress . '%' ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
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