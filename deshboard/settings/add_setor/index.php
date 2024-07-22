<?php
require_once "../../../autentication/index.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../style/settings.css?v=2">
    <link rel="stylesheet" href="../../../style/dashboard.css?v=1">
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
                <div class='box-colaborador'>

                    <div class="perfil-colaborador">
                        <i class="bx bx-user-circle"></i>
                        <p>Jefferson Luiz</p>
                    </div>

                    <div class="buttons-colaborador">
                        <div class="button-colaborador editar">
                            <a href="" class="editar">Editar</a>
                        </div>

                        <div class="button-colaborador excluir">
                            <a href="">Deletar</a>
                        </div>
                    </div>
                </div>

                <div class='box-colaborador'>

                    <div class="perfil-colaborador">
                        <i class="bx bx-user-circle"></i>
                        <p>Jefferson Luiz</p>
                    </div>

                    <div class="buttons-colaborador">
                        <div class="button-colaborador editar">
                            <a href="" class="editar">Editar</a>
                        </div>

                        <div class="button-colaborador excluir">
                            <a href="">Deletar</a>
                        </div>
                    </div>
                </div>

                <div class='box-colaborador'>

                    <div class="perfil-colaborador">
                        <i class="bx bx-user-circle"></i>
                        <p>Jefferson Luiz</p>
                    </div>

                    <div class="buttons-colaborador">
                        <div class="button-colaborador editar">
                            <a href="" class="editar">Editar</a>
                        </div>

                        <div class="button-colaborador excluir">
                            <a href="">Deletar</a>
                        </div>
                    </div>
                </div>

                <div class='box-colaborador'>

                    <div class="perfil-colaborador">
                        <i class="bx bx-user-circle"></i>
                        <p>Jefferson Luiz</p>
                    </div>

                    <div class="buttons-colaborador">
                        <div class="button-colaborador editar">
                            <a href="" class="editar">Editar</a>
                        </div>

                        <div class="button-colaborador excluir">
                            <a href="">Deletar</a>
                        </div>
                    </div>
                </div>

                <div class='box-colaborador'>

                    <div class="perfil-colaborador">
                        <i class="bx bx-user-circle"></i>
                        <p>Jefferson Luiz</p>
                    </div>

                    <div class="buttons-colaborador">
                        <div class="button-colaborador editar">
                            <a href="" class="editar">Editar</a>
                        </div>

                        <div class="button-colaborador excluir">
                            <a href="">Deletar</a>
                        </div>
                    </div>
                </div>

                <div class='box-colaborador'>

                    <div class="perfil-colaborador">
                        <i class="bx bx-user-circle"></i>
                        <p>Jefferson Luiz</p>
                    </div>

                    <div class="buttons-colaborador">
                        <div class="button-colaborador editar">
                            <a href="" class="editar">Editar</a>
                        </div>

                        <div class="button-colaborador excluir">
                            <a href="">Deletar</a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="add-banco-de-dados">
                <div class="form-add-bd">
                    <div class="title-add">
                        <h1>Adicionar Setor</h1>
                    </div>

                    <form>
                        <div class="box-form-setor">
                            <input type="text" placeholder="Nome do Setor">
                        </div>

                        <div class="buttons-add-cancelar">
                            <button type="submit" class="button-form">Adicionar</button>
                            <button type="button" class="button-form" id="buttonCancelar">Cancelar</button>
                        </div>
                    </form>
                </div>
            </section>
        </section>
    </section>
</body>

<script src="../../../script/navegacao.js?v=1"></script>
<script src="../../../script/dashboard.js?v=1"></script>

</html>