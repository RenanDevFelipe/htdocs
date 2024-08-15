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
    <link rel="stylesheet" href="avalicao_estoque.css?v=3">
    <title>Avaliação - RH</title>
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
                <b>Retire o ponto de acordo <br> com o mês que desejar</b>

                <div class="box-estoque">
                    <input type="hidden" name="bd" value="<?php echo $_GET['bd'] ?>">
                    <input type="text" name="colaborador" id="colaborador" disabled value="<?php echo $colaborador['nome_colaborador'] ?>">
                    <input type="month" name="data" id="data">
                </div>

                <div class="box-estoque display-flex">
                    <div class="box-input-check">
                        <div><b>Ponto</b></div>
                        <input type="checkbox" id="ponto" name="ponto" value="ponto">
                        <label for="ponto">-2 pontos</label>
                    </div>
                    <div class="box-input-check">
                        <div><b>Atestado</b></div>
                        <input type="checkbox" id="atestado" name="atestado" value="atestado">
                        <label for="atestado">-2 Pontos </label>
                    </div>
                    <div class="box-input-check">
                        <div><b>Falta não justificada</b></div>
                        <input type="checkbox" id="falta" name="falta" value="falta">
                        <label for="falta">-2 Pontos</label>
                    </div>


                    <div class="box-input-check">
                        <div><b>Ponto</b></div>
                        <input type="checkbox" id="ponto+" name="ponto+" value="ponto+">
                        <label for="ponto+">+2 pontos</label>
                    </div>
                    <div class="box-input-check">
                        <div><b>Atestado</b></div>
                        <input type="checkbox" id="atestado+" name="atestado+" value="atestado+">
                        <label for="atestado+">+2 Pontos </label>
                    </div>
                    <div class="box-input-check">
                        <div><b>Falta não justificada</b></div>
                        <input type="checkbox" id="ponto+" name="falta+" value="falta+">
                        <label for="falta+">+2 Pontos</label>
                    </div>

                </div>
                <div class="div-button">
                    <button type="submit" class="button-avaliar-estoque blue">Salvar</button>
                    <a href="/deshboard/" class="button-avaliar-estoque red">Voltar</a>
                </div>

            </form>
        </section>
    </section>
</body>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
    var formAvaliacaoEstoque = document.getElementById('formAvaliacaoEstoque');

    formAvaliacaoEstoque.addEventListener('submit', function(event) {
        event.preventDefault(); // Impede o envio padrão do formulário

        $.ajax({
            type: 'POST',
            url: 'update_estoque.php', // O URL do seu script PHP
            data: $(this).serialize(), // Serializa os dados do formulário
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Sucesso',
                        text: response.message,
                        icon: 'success'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Erro', response.message, 'error'); // Exibe a mensagem de erro detalhada
                }
            },
            error: function (xhr, status, error) {
                Swal.fire('Erro', 'Erro ao atualizar os dados: ' + error, 'error');
            }
        });
    });
});

</script>

<script src="../../../script/dashboard.js"></script>

</html>