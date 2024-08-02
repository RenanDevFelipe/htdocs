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
    <link rel="stylesheet" href="avaliacao_n2.css">
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
                        <div><b>Ordem de serviço</b></div>
                        <input type="checkbox" name="pedido" value="pedido">
                        <label for="pedido">-10 pontos O.S não finalizada</label>
                    </div>
                    <div class="box-input-check">
                        <div><b>Lavagem</b></div>
                        <input type="checkbox" name="material" value="material">
                        <label for="material">-20 Carro não Lavado</label>
                    </div>
                    <div class="box-input-check">
                        <div><b>Organização</b></div>
                        <div>
                            <input type="checkbox" name="almoxarifado" value="almoxarifado">
                            <label for="almoxarifado">-10 Pontos material desorganizado</label>
                        </div>
                        <div>
                            <input type="checkbox" name="almoxarifado" value="almoxarifado">
                            <label for="almoxarifado">-10 Sem fardamento</label>
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
<script src="avaliacao_n2.js"></script>

</html>