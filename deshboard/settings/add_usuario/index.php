<?php
require_once "../../../autentication/index.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../style/settings.css?v=3">
    <link rel="stylesheet" href="../../../style/dashboard.css?v=1">
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
                <div class='box-colaborador'>

                    <div class="perfil-colaborador">
                        <i class="bx bx-user-circle"></i>
                        <p>Jefferson Luiz</p>
                    </div>

                    <div class="buttons-colaborador">                      
                            <a href="" class="editar">Editar</a>
                        

                        
                            <a href="" class="excluir">Deletar</a>
                    </div>
                </div>
                </div>
            </section>
        </section>
    </section>
</body>

<script src="../../../script/navegacao.js?v=1"></script>
<script src="../../../script/dashboard.js?v=1"></script>

</html>