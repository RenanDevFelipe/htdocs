<?php
require_once "../../../autentication/index.php";
require_once "../../../slide_menu/slide_bar_menu.php";
require_once "../../../api/listar_os.php";
require_once "../../../api/os_aberta_do_dia.php";

$mostrar = 0;
?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../style/dashboard.css?v=4">
    <link rel="stylesheet" href="index.css?v=4">
    <title>Document</title>
</head>

<body>
    <section class="body-os home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
            <p><strong>Total de OS:</strong> <?php echo $os_fin->total ?></p>
        </div>
        <section class="dashboard-tecnicos-ranking">

            <?php
            foreach (zip($desc_os, $nomes_clientes, $fechamento_os, $id_os_ixc, $id_cliente, $abertura_os, $id_assunto) as $pair) :
                list($desc, $cliente, $fechamento, $id, $id_cliente, $abertura_os, $id_assunto) = $pair;
            ?>
                <div>
                    <div class="box-tecnico">
                        <div id="tecnico">
                            <div>
                                <p> <?php echo $id ?> </p>
                                <p> <?php echo $fechamento ?> </p>
                            </div>
                            <p> <?php echo $id_cliente . ' - ' . $cliente ?> </p>
                        </div>
                        <div class="avaliar">
                            <div id="abrirDetalhes">
                                <i class="bx bx-collection"></i>
                                <a>Detalhes</a>
                            </div>
                            <div>
                                <i class="bx bx-star"></i>
                                <a href="">Avaliar</a>
                            </div>
                        </div>

                    </div>
                    <div class="box-detalhes">
                        <div class="row-id-os">
                            <p><strong>ID: </strong><?php echo $id ?></p>
                        </div>
                        <div class="row-assunto-os">
                            <p><strong>Assunto da OS: </strong><?php echo $id_assunto ?></p>
                        </div>
                        <div class="row-data-abertura">
                            <p><strong>Data de abertura: </strong><?php echo $abertura_os ?></p>
                        </div>
                        <div class="row-data-fechamento">
                            <p><strong>Data de fechamento: </strong><?php echo $fechamento ?></p>
                        </div>
                        <div class="row-desc-os">
                            <p><strong>Descrição da OS: </strong><?php echo $desc ?></p>
                        </div>
                    </div>
                    <div class="box-checklist">
                        <form method="post">
                            <div>
                                <label for="execucao">A ordem de serviço estava com o Status em "Execução"? </label>
                                <input type="checkbox" name="execucao" id="execucao">
                            </div>
                            <div>
                                <label for="ipv6">O IPv6 foi ativado no roteador do cliente? </label>
                                <input type="checkbox" name="ipv6" id="ipv6">
                            </div>
                            <div>
                                <label for="potencia">Foi aferida a potência do Sinal, na casa do cliente e na CTO? Frequência 1490nm.</label>
                                <input type="checkbox" name="potencia" id="potencia">
                            </div>
                            <div>
                                <label for="ipv6">A potência do sinal óptico ficou na margem de sinal permitido = ou <  que -25db?</label>
                                <input type="checkbox" name="ipv6" id="ipv6">
                            </div>
                        </form>
                    </div>
                </div>



            <?php endforeach ?>
            <div>
                <?php echo $erro_mensagem ?>
            </div>
        </section>
    </section>


</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('#abrirDetalhes');
        const boxes = document.querySelectorAll('.box-detalhes');

        buttons.forEach((button, index) => {
            button.addEventListener('click', function() {
                const selectedBox = boxes[index];

                // Oculta todas as caixas
                boxes.forEach(box => {
                    if (box !== selectedBox) {
                        box.classList.remove('active');
                    }
                });

                // Alterna a classe 'active' na caixa clicada
                selectedBox.classList.toggle('active');
            });
        });
    });
</script>

<script src="../../../script/dashboard.js?v=1"></script>

</html>