<?php
require_once "../../../autentication/index.php";
require_once "listar_setor.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<style>
    .hidden-1{
        display: none;
    }
</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../style/settings.css?v=3">
    <link rel="stylesheet" href="../../../style/dashboard.css?v=2">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="add-setor.css">
    <title>Settings - Cadastrar Setores</title>
</head>

<body>
    <?php include_once '../../../slide_menu/slide_bar_menu.php' ?>
    <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
        </div>

        <section class="settings-add-colaborador">
            <div class="title-settings">
                <h1>Setores</h1>
            </div>

            <section style="width: 92%;">
                <div class="button-add-colaboradores">
                    <i class="bx bx-plus-circle" id="buttonAdd"></i>
                </div>
            </section>
            <section class="list-colaboradores">
                <?php foreach ($setores as $setor) : ?>
                    <div class='box-colaborador'>

                        <div class="perfil-colaborador">
                            <i class="bx bxs-widget"></i>
                            <p><?php echo $setor['nome_setor'] ?></p>
                        </div>

                        <div class="buttons-colaborador">

                            <a class="editar buttonEditar" data-id="<?php echo $setor['id_setor']?>">Editar</a>



                            <a class="delete-button excluir" data-id="<?php echo $setor['id_setor'] ?>">Deletar</a>

                        </div>
                    </div>
                <?php endforeach ?>
            </section>

            <section class="add-banco-de-dados">
                <div class="form-add-bd">
                    <div class="title-add">
                        <h1>Adicionar Setor</h1>
                    </div>

                    <form id="formSetor" method="POST">
                        <div class="box-form-setor">
                            <input type="text" name="nome_setor" id="nome_setor" placeholder="Nome do Setor">
                        </div>
                    </form>

                    <div class="buttons-add-cancelar">
                        <button type="submit" class="button-form" id="addSetor">Adicionar</button>
                        <button type="button" class="button-form" id="buttonCancelar">Cancelar</button>
                    </div>

                </div>
            </section>

            <section class="edit-colaborador hidden add-banco-de-dados">
                <div class="form-add-bd">
                    <div class="title-add">
                        <h1>Editar Setor</h1>
                    </div>

                    <form id="formSetorEdit" method="POST">
                        <div class="box-form-setor">
                            <input type="hidden" name="id_setor" id="editUserId">
                            <input type="text" name="nome_setor" id="editNome" placeholder="Nome do Setor">
                        </div>
                    </form>

                    <div class="buttons-add-cancelar">
                        <button type="submit" class="button-form" id="formEditColaborador">Salvar</button>
                        <button type="button" class="button-form" id="buttonCancelarEdit">Cancelar</button>
                    </div>

                </div>
            </section>

    </section>
</body>

<script src="../../../script/navegacao.js?v=2"></script>
<script src="enviar_riquisicao.js"></script>
<script src="../../../script/dashboard.js?v=1"></script>
<script src="deletar_setor.js"></script>
<script src="riquisição_editar.js"></script>

</html>