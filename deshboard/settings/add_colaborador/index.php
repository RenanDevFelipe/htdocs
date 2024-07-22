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
    <link rel="stylesheet" href="../../../style/settings.css?v=2">
    <link rel="stylesheet" href="../../../style/dashboard.css?v=1">
    <link rel="stylesheet" href="./add_colaborador.css">
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
                    $query -> execute();

                    while($colaboradores = $query->fetch(PDO::FETCH_ASSOC)){

                ?>
                <div class='box-colaborador'>
                    <div class="perfil-colaborador">
                        <i class="bx bx-user-circle"></i>
                        <p><?php echo $colaboradores['nome_colaborador'] ?></p>
                        <br>
                        <p><?php echo $colaboradores['setor_colaborador'] ?></p>
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
                                <label for="setor">Qual o setor do colaborador?  </label>
                                <select name="nome_setor" id="setor">
                                <?php
                                    $query = $pdo->prepare("SELECT * FROM setor");
                                    $query -> execute();

                                    while($setores = $query->fetch(PDO::FETCH_ASSOC)){

                                    ?>
                                    <option value="<?php echo $setores['nome_setor'] ?>"><?php echo $setores['nome_setor'] ?></option>
                                

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
        </section>
    </section>

    <!-- Modal de erro -->
    <div id="errorModal" style="display: <?php echo $error ? 'block' : 'none'; ?>" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeErrorModal()">&times;</span>
            <p><?php echo $error; ?></p>
        </div>
    </div>

    <!-- Seu JavaScript existente -->

    <script>
        // Função para fechar o modal de erro
        function closeErrorModal() {
            document.getElementById('errorModal').style.display = 'none';
        }
    </script>
</body>

<script src="../../../script/navegacao.js?v=1"></script>
<script src="../../../script/dashboard.js?v=1"></script>
<script src="enviar_requisicao.js"></script>

</html>