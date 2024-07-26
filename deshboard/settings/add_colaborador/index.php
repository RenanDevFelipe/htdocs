<?php
require_once "../../../autentication/index.php";
require_once "../../../core/core.php";
$error = isset($_GET['error']) ? $_GET['error'] : null;

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../style/settings.css?v=5">
    <link rel="stylesheet" href="../../../style/dashboard.css?v=2">
    <link rel="stylesheet" href="./add_colaborador.css?v=2">
    <link rel="stylesheet" href="./modal.css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Settings - Cadastrar Funcionário</title>


</head>

<body>
    <?php include_once '../../../slide_menu/slide_bar_menu.php' ?>
    <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
        </div>

        <section class="settings-add-colaborador">
            <div class="title-settings">
                <h1>Colaboradores</h1>
            </div>
            <section style="width: 92%;">
                <div class="button-add-colaboradores">
                    <i class="bx bx-plus-circle" id="buttonAdd"></i>
                </div>
            </section>
            <section class="list-colaboradores">
                <?php
                $query = $pdo->prepare("SELECT * FROM colaborador");
                $query->execute();

                while ($colaboradores = $query->fetch(PDO::FETCH_ASSOC)) {
                    $setor = $pdo->prepare('SELECT nome_setor FROM setor WHERE id_setor = ?');
                    $setor->execute([$colaboradores['setor_colaborador']]);
                    $setores = $setor->fetch(PDO::FETCH_ASSOC)
                ?>
                    <div class='box-colaborador'>
                        <div class="perfil-colaborador">
                            <i class="bx bx-user-circle"></i>
                            <p><?php echo $colaboradores['nome_colaborador'] ?></p>
                            <br>
                            <p><?php echo $setores['nome_setor'] ?></p>
                        </div>

                        <div class="buttons-colaborador">
                            <a class="editar buttonEditar" data-id="<?php echo $colaboradores['id_colaborador'] ?>">Editar</a>

                            <a class="excluir delete-btn" data-userid="<?php echo $colaboradores['id_colaborador']; ?>">Deletar</a>
                        </div>
                    </div>
                <?php
                }
                ?>

            </section>
            <section class="add-banco-de-dados">
                <div class="form-add-bd">
                    <div class="title-add">
                        <h1>Adicionar Colaborador</h1>
                    </div>

                    <form method="post" class="form" id="formColaborador">
                        <div class="box-form-setor">
                            <input id="nome_colaborador" name="nome_colaborador" type="text" placeholder="Nome do Colaborador">
                            <input id="id_ixc" name="id_ixc" type="text" placeholder="ID no IXC">
                            <div class="select">
                                <label for="setor">Qual o setor do colaborador? </label>
                                <select name="nome_setor" id="setor">
                                    <?php
                                    $query = $pdo->prepare("SELECT * FROM setor");
                                    $query->execute();

                                    while ($setores = $query->fetch(PDO::FETCH_ASSOC)) {

                                    ?>
                                        <option value="<?php echo $setores['id_setor'] ?>"><?php echo $setores['nome_setor'] ?></option>


                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>


                    </form>
                    <div class="buttons-add-cancelar">
                        <button type="submit" id="addColaborador" class="button-form">Adicionar</button>
                        <button type="button" class="button-form" id="buttonCancelar">Cancelar</button>
                    </div>
                </div>
            </section>
            <section class="edit-colaborador hidden add-banco-de-dados">
                <div class="form-add-bd">
                    <div class="title-add">
                        <h1>Editar Colaborador</h1>
                    </div>

                    <form id="formSetorEdit" method="POST">
                        <div class="box-form-setor">
                            <input type="hidden" name="id_colaborador" id="editUserId">
                            <input type="text" name="nome_colaborador" id="editNome" placeholder="Nome do Colaborador">
                            <input type="text" name="id_ixc" id="editId" placeholder="Id do IXC do colaborador">
                        </div>
                        <div class="select">
                            <label for="setor">Qual o setor do colaborador? </label>
                            <select name="setor_colaborador" id="editSetor">
                                <?php
                                $query = $pdo->prepare("SELECT * FROM setor");
                                $query->execute();

                                while ($setores = $query->fetch(PDO::FETCH_ASSOC)) {

                                ?>
                                    <option value="<?php echo $setores['id_setor'] ?>"><?php echo $setores['nome_setor'] ?></option>


                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </form>

                    <div class="buttons-add-cancelar">
                        <button type="submit" class="button-form" id="formEditColaborador">Salvar</button>
                        <button type="button" class="button-form" id="buttonCancelarEdit">Cancelar</button>
                    </div>

                </div>
            </section>
        </section>
    </section>
</body>
<script src="deletar_usuario.js"></script>
<script src="../../../script/navegacao.js?v=1"></script>
<script src="../../../script/dashboard.js?v=1"></script>
<script src="enviar_requisicao.js"></script>
<script src="requisicao_editar.js?v=2"></script>

</html>