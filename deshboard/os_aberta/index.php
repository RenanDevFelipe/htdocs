<?php
require_once '../../autentication/index.php';
require_once '../../api/os_por_assunto/os_sem_acesso.php';
require_once '../../api/os_por_assunto/os_oscilacao.php';
require_once '../../api/os_por_assunto/os_lentidao.php';
require_once '../../api/os_por_assunto/os_instalacao.php';
require_once '../../api/os_por_assunto/os_troca_de_endereco.php';
require_once '../../api/os_por_assunto/os_troca_de_equipamento.php';
require_once '../../api/os_por_assunto/total_os_mes.php'
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/dashboard.css?v=2">
    <link rel="stylesheet" href="os_aberta.css?v=2">
    <title>O.S aberta por setor</title>
</head>

<body>
    <?php include_once '../../slide_menu/slide_bar_menu.php' ?>
    <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
        </div>

        <section class="os-por-assunto">
            <div class="title">
                <h1>O.S aberta por assunto</h1>
                <p>Total de O.S Mensal: <?php echo ' ' . $os_total ?></p>
            </div>

            <div class="list-geral-os">
                <div class="list-of-oss">
                    <div class="box-os">
                        <div class="id-os">
                            <p>ID: 28</p>
                        </div>

                        <div class="title-os">
                            <p>Sem Acesso</p>
                            <p><?php echo $sem_acesso_total?></p>
                        </div>
                    </div>

                    <div class="box-os">
                        <div class="id-os">
                            <p>ID: 23</p>
                        </div>

                        <div class="title-os">
                            <p>Oscilação</p>
                            <p><?php echo $oscilacao_total ?></p>
                        </div>
                    </div>

                    <div class="box-os">
                        <div class="id-os">
                            <p>ID: 27</p>
                        </div>

                        <div class="title-os">
                            <p>Lentidão</p>
                            <p><?php echo $lentidao_total?></p>
                        </div>
                    </div>

                    <div class="box-os">
                        <div class="id-os">
                            <p>ID: 10</p>
                        </div>

                        <div class="title-os">
                            <p>Instalação Fibra</p>
                            <p><?php echo $instalacao_total?></p>
                        </div>
                    </div>

                    <div class="box-os">
                        <div class="id-os">
                            <p>ID: 70</p>
                        </div>

                        <div class="title-os">
                            <p>Troca de endereço</p>
                            <p><?php echo $mud_endereco_total ?></p>
                        </div>
                    </div>

                    <div class="box-os">
                        <div class="id-os">
                            <p>ID: 26</p>
                        </div>

                        <div class="title-os">
                            <p>Troca de Equipamento</p>
                            <p><?php echo $equipamento_total?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
</body>
<script src="../../script/dashboard.js"></script>

</html>