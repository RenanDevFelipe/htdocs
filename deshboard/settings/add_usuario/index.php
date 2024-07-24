<?php
require_once "../../../autentication/index.php";
require_once "listar_user.php";
require_once "get_roles.php";
require_once "../add_setor/listar_setor.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.5.js"></script>
    <link rel="stylesheet" href="../../../style/settings.css?v=3">
    <link rel="stylesheet" href="../../../style/dashboard.css?v=1">
    <link rel="stylesheet" href="add_user.css">
    <title>Settings - Cadastrar Usuário</title>
</head>

<body>
    <?php include_once '../../../slide_menu/slide_bar_menu.php' ?>
    <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
        </div>

        <section class="settings-add-colaborador">
            <div class="title-settings">
                <h1>Usuários</h1>
            </div>

            <section style="width: 92%;">
                <div class="button-add-colaboradores">
                    <i class="bx bx-plus-circle" id="buttonAdd"></i>
                </div>
            </section>
            <section class="list-colaboradores">
                <?php foreach ($users as $user) : ?>
                    <div class='box-colaborador'>

                        <div class="perfil-colaborador">
                            <i class="bx bx-user-circle"></i>
                            <p><?php echo $user['nome_user'] ?></p>
                        </div>

                        <div class="buttons-colaborador">
                            <a href="" class="editar">Editar</a>



                            <a href="" class="excluir">Deletar</a>
                        </div>
                    </div>
                <?php endforeach ?>

                </div>
            </section>

            <section class="add-banco-de-dados">
                <div class="form-add-bd">
                    <div class="title-add">
                        <h1>Adicionar Usuário</h1>
                    </div>

                    <form id="formUser" method="POST">
                        <div class="box-form-setor">
                            <input type="text" name="nomeUser" id="nomeUser" placeholder="Nome do Usuário">
                        </div>

                        <div class="box-form-setor">
                            <input type="email" name="emailUser" id="emailUser" placeholder="exemplo@exemplo.com">
                            <input type="password" name="passUser" id="passUser" placeholder="Password">
                        </div>
                        <div class="box-form-setor">
                            <select name="roleUser" id="" class="selectUser">
                                <option value="" disabled selected hidden>Selecione um perfil</option>
                                <?php foreach ($roles as $role) : ?>
                                    <option value="<?php echo $role['id_role'] ?>"><?php echo $role['nome_role'] ?></option>
                                <?php endforeach ?>
                            </select>

                            <select name="setorUser" id="" class="selectUser selectUser2">
                                <option value="" disabled selected hidden>Selecione um setor</option>
                                <?php foreach($setores as $setor): ?>
                                    <option value="<?php echo $setor['id_setor'] ?>"><?php echo $setor['nome_setor'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </form>

                    <div class="buttons-add-cancelar">
                        <button type="submit" class="button-form" id="addUser">Adicionar</button>
                        <button type="button" class="button-form" id="buttonCancelar">Cancelar</button>
                    </div>

                </div>
            </section>
        </section>
    </section>
</body>

<script src="../../../script/navegacao.js?v=1"></script>
<script src="../../../script/dashboard.js?v=1"></script>
<script src="enviar_riquisicao.js?v=1"></script>
</html>