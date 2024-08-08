<?php
require_once '../../../autentication/index.php';
require_once '../../../core/core.php';

$sql = $pdo->prepare('SELECT nome_colaborador FROM colaborador WHERE  id_colaborador = ?');
$sql->execute([$_GET['bd']]);
$colaborador = $sql->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../style/dashboard.css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="avalicao_estoque.css?v=2">
    <title>Avaliação - Estoque</title>
</head>

<body>
    <?php include_once '../../../slide_menu/slide_bar_menu.php'; ?>

    <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
        </div>

        <section>
            <div class="avaliacao-estoque">
                <h1>Avaliação</h1>
            </div>
        </section>

        <section class="section-estoque">


            <form class="form-avaliacao-estoque" id="formAvaliacaoEstoque" method="POST">
                <b>Retire o ponto de acordo <br> com o dia que desejar</b>

                <div class="box-estoque">
                    <input type="hidden" name="bd" value="<?php echo $_GET['bd'] ?>">
                    <input type="text" name="colaborador" id="colaborador" disabled value="<?php echo $colaborador['nome_colaborador'] ?>">
                    <input type="date" name="data" id="data">
                </div>

                <div class="box-estoque display-flex">
                    <div class="box-input-check">
                        <div><b>Pedido</b></div>
                        <input type="checkbox" name="pedido" value="pedido">
                        <label for="pedido">-2 pontos Pedido</label>
                    </div>
                    <div class="box-input-check">
                        <div><b>Material</b></div>
                        <input type="checkbox" name="material" value="material">
                        <label for="material">-2 Pontos Baixa de material</label>
                    </div>
                    <div class="box-input-check">
                        <div><b>Almoxarifado</b></div>
                        <input type="checkbox" name="almoxarifado" value="almoxarifado">
                        <label for="almoxarifado">-2 Pontos Transferência de material</label>
                    </div>
                </div>

                <div class="box-estoque display-flex">
                    <div>
                        <b>Devolução de material</b> <br>
                        <div class="box-input-check">
                            <input type="checkbox" name="fora_prazo" value="fora_prazo">
                            <label for="fora_prazo">-1 Fora do prazo</label>
                        </div>
                        <div class="box-input-check">
                            <input type="checkbox" name="sem_etiqueta" value="sem_etiqueta">
                            <label for="sem_etiqueta">-1 Sem etiqueta de identificação</label>
                        </div>
                    </div>
                    <div>
                        <b>Troca de Equipamento</b> <br>
                        <div class="box-input-check">
                            <input type="checkbox" name="sem_identificacao" value="sem_identificacao">
                            <label for="sem_identificacao">-2 Sem identificação do problema</label>
                        </div>
                    </div>
                </div>

                <div class="div-button">
                    <button type="submit" class="button-avaliar-estoque">Salvar</button>
                    <a href="/deshboard/" class="button-avaliar-estoque red">Voltar</a>
                </div>
            </form>
        </section>
    </section>
</body>

<script src="../../../script/dashboard.js"></script>
<script src="enviar_riquisição.js"></script>

</html>