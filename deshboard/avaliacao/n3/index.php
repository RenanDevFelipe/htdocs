<?php
require_once "../../../autentication/index.php";
require_once "../../../slide_menu/slide_bar_menu.php";
require_once "../../../api/listar_os.php";
require_once "../../../api/os_aberta_do_dia.php";

$mostrar = 0;
?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../style/dashboard.css?v=4">
    <link rel="stylesheet" href="index.css?v=4">
    <title>Document</title>
</head>

<body>
    <section class="body-os home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
            <p><strong>Total de OS:</strong> <?php echo $os_fin->total ?></p>
        </div>
        <section class="dashboard-tecnicos-ranking">

            <?php
            foreach (zip($desc_os, $nomes_clientes, $fechamento_os, $id_os_ixc, $id_cliente, $abertura_os, $id_assunto) as $index => $pair) :
                list($desc, $cliente, $fechamento, $id, $id_cliente, $abertura_os, $id_assunto) = $pair;
            ?>
                <div>
                    <div class="box-tecnico">
                        <div id="tecnico">
                            <div>
                                <p> <?php echo $id ?> </p>
                                <p> <?php echo $fechamento ?> </p>
                            </div>
                            <p> <?php echo $id_cliente . ' - ' . $cliente ?> </p>
                        </div>
                        <div class="avaliar">
                            <div id="abrirDetalhes">
                                <i class="bx bx-collection"></i>
                                <a>Detalhes</a>
                            </div>
                            <div id="abrirAvaliar" data-assunto="<?php echo $id_assunto ?>">
                                <i class="bx bx-star"></i>
                                <a>Avaliar</a>
                            </div>
                        </div>

                    </div>
                    <div class="box-detalhes">
                        <div class="row-id-os">
                            <p><strong>ID: </strong><?php echo $id ?></p>
                        </div>
                        <div class="row-assunto-os">
                            <p><strong>Assunto da OS: </strong><?php echo $id_assunto ?></p>
                        </div>
                        <div class="row-data-abertura">
                            <p><strong>Data de abertura: </strong><?php echo $abertura_os ?></p>
                        </div>
                        <div class="row-data-fechamento">
                            <p><strong>Data de fechamento: </strong><?php echo $fechamento ?></p>
                        </div>
                        <div class="row-desc-os">
                            <p><strong>Descrição da OS: </strong><?php echo $desc ?></p>
                        </div>
                    </div>
                    <div class="box-checklist">
                        <form class="formulario_instalacao" method="post" id="form-<?php echo $index ?>">
                            <div>
                                <input value="1" type="checkbox" name="execucao" id="execucao">
                                <label for="execucao">A ordem de serviço estava com o Status em "Execução"? </label>
                            </div>

                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="potencia" id="potencia">
                                <label for="potencia">Foi aferida a potência do Sinal, na casa do cliente e na CTO? Frequência 1490nm.</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="potenciaBoa" id="potenciaBoa">
                                <label for="potenciaBoa">A potência do sinal óptico ficou na margem de sinal permitido = ou < que -25db?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="organizadoCaixa" id="organizadoCaixa">
                                <label for="organizadoCaixa">Foi organizado os cabos na CTO/Caixa?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="organizadoParede" id="organizadoParede">
                                <label for="organizadoParede">Os Equipamentos e cabos ficaram organizados na parede, de acordo com o Padrão Ti Connect?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="velocidade" id="velocidade">
                                <label for="velocidade">Foi Feito o teste de velocidade?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="acessoRemoto" id="acessoRemoto">
                                <label for="acessoRemoto">Foi ativado o Ping e liberado o acesso remoto?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="nomeRede" id="nomeRede">
                                <label for="nomeRede">Foi inserido o nome (Ticonnect), na rede wifi?</label>
                            </div>
                            <div>
                                <label for="obs">OBS:</label>
                                <input type="text" name="obs" id="obs">
                            </div>
                        </form>
                        <form class="formulario_suporte" method="post" id="form-<?php echo $index ?>">
                            <div>
                                <input value="1" type="checkbox" name="execucao" id="execucao">
                                <label for="execucao">A ordem de serviço estava com o Status em "Execução"? </label>
                            </div>

                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="potencia" id="potencia">
                                <label for="potencia">Foi aferida a potência do Sinal, na casa do cliente e na CTO? Frequência 1490nm.</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="potenciaBoa" id="potenciaBoa">
                                <label for="potenciaBoa">A potência do sinal óptico ficou na margem de sinal permitido = ou < que -25db?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="organizadoCaixa" id="organizadoCaixa">
                                <label for="organizadoCaixa">Foi organizado os cabos na CTO/Caixa?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="organizadoParede" id="organizadoParede">
                                <label for="organizadoParede">Os Equipamentos e cabos ficaram organizados na parede, de acordo com o Padrão Ti Connect?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="velocidade" id="velocidade">
                                <label for="velocidade">Foi Feito o teste de velocidade?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="acessoRemoto" id="acessoRemoto">
                                <label for="acessoRemoto">Foi ativado o Ping e liberado o acesso remoto?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="nomeRede" id="nomeRede">
                                <label for="nomeRede">Foi inserido o nome (Ticonnect), na rede wifi?</label>
                            </div>
                            <div>
                                <label for="obs">OBS:</label>
                                <input type="text" name="obs" id="obs">
                            </div>
                        </form>
                        <form class="formulario_instalacao_camera" method="post" id="form-<?php echo $index ?>">
                            <div>
                                <input value="1" type="checkbox" name="execucao" id="execucao">
                                <label for="execucao">A ordem de serviço estava com o Status em "Execução"? </label>
                            </div>

                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="potencia" id="potencia">
                                <label for="potencia">Foi aferida a potência do Sinal, na casa do cliente e na CTO? Frequência 1490nm.</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="potenciaBoa" id="potenciaBoa">
                                <label for="potenciaBoa">A potência do sinal óptico ficou na margem de sinal permitido = ou < que -25db?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="organizadoCaixa" id="organizadoCaixa">
                                <label for="organizadoCaixa">Foi organizado os cabos na CTO/Caixa?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="organizadoParede" id="organizadoParede">
                                <label for="organizadoParede">Os Equipamentos e cabos ficaram organizados na parede, de acordo com o Padrão Ti Connect?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="velocidade" id="velocidade">
                                <label for="velocidade">Foi Feito o teste de velocidade?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="acessoRemoto" id="acessoRemoto">
                                <label for="acessoRemoto">Foi ativado o Ping e liberado o acesso remoto?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="nomeRede" id="nomeRede">
                                <label for="nomeRede">Foi inserido o nome (Ticonnect), na rede wifi?</label>
                            </div>
                            <div>
                                <label for="obs">OBS:</label>
                                <input type="text" name="obs" id="obs">
                            </div>
                        </form>
                        <form class="formulario_instalacao_iptv" data-assunto="427" method="post" id="form-<?php echo $index ?>">
                            <div>
                                <input value="1" type="checkbox" name="execucao" id="execucao">
                                <label for="execucao">A ordem de serviço estava com o Status em "Execução"? </label>
                            </div>

                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="potencia" id="potencia">
                                <label for="potencia">Foi aferida a potência do Sinal, na casa do cliente e na CTO? Frequência 1490nm.</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="potenciaBoa" id="potenciaBoa">
                                <label for="potenciaBoa">A potência do sinal óptico ficou na margem de sinal permitido = ou < que -25db?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="organizadoCaixa" id="organizadoCaixa">
                                <label for="organizadoCaixa">Foi organizado os cabos na CTO/Caixa?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="organizadoParede" id="organizadoParede">
                                <label for="organizadoParede">Os Equipamentos e cabos ficaram organizados na parede, de acordo com o Padrão Ti Connect?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="velocidade" id="velocidade">
                                <label for="velocidade">Foi Feito o teste de velocidade?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="acessoRemoto" id="acessoRemoto">
                                <label for="acessoRemoto">Foi ativado o Ping e liberado o acesso remoto?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="nomeRede" id="nomeRede">
                                <label for="nomeRede">Foi inserido o nome (Ticonnect), na rede wifi?</label>
                            </div>
                            <div>
                                <label for="obs">OBS:</label>
                                <input type="text" name="obs" id="obs">
                            </div>
                        </form>
                        <form class="formulario_suporte_camera" method="post" id="form-<?php echo $index ?>">
                            <div>
                                <input value="1" type="checkbox" name="execucao" id="execucao">
                                <label for="execucao">A ordem de serviço estava com o Status em "Execução"? </label>
                            </div>

                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="potencia" id="potencia">
                                <label for="potencia">Foi aferida a potência do Sinal, na casa do cliente e na CTO? Frequência 1490nm.</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="potenciaBoa" id="potenciaBoa">
                                <label for="potenciaBoa">A potência do sinal óptico ficou na margem de sinal permitido = ou < que -25db?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="organizadoCaixa" id="organizadoCaixa">
                                <label for="organizadoCaixa">Foi organizado os cabos na CTO/Caixa?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="organizadoParede" id="organizadoParede">
                                <label for="organizadoParede">Os Equipamentos e cabos ficaram organizados na parede, de acordo com o Padrão Ti Connect?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="velocidade" id="velocidade">
                                <label for="velocidade">Foi Feito o teste de velocidade?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="acessoRemoto" id="acessoRemoto">
                                <label for="acessoRemoto">Foi ativado o Ping e liberado o acesso remoto?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="nomeRede" id="nomeRede">
                                <label for="nomeRede">Foi inserido o nome (Ticonnect), na rede wifi?</label>
                            </div>
                            <div>
                                <label for="obs">OBS:</label>
                                <input type="text" name="obs" id="obs">
                            </div>
                        </form>
                        <form class="formulario_suporte_iptv" method="post" id="form-<?php echo $index ?>">
                            <div>
                                <input value="1" type="checkbox" name="execucao" id="execucao">
                                <label for="execucao">A ordem de serviço estava com o Status em "Execução"? </label>
                            </div>

                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="potencia" id="potencia">
                                <label for="potencia">Foi aferida a potência do Sinal, na casa do cliente e na CTO? Frequência 1490nm.</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="potenciaBoa" id="potenciaBoa">
                                <label for="potenciaBoa">A potência do sinal óptico ficou na margem de sinal permitido = ou < que -25db?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="organizadoCaixa" id="organizadoCaixa">
                                <label for="organizadoCaixa">Foi organizado os cabos na CTO/Caixa?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="organizadoParede" id="organizadoParede">
                                <label for="organizadoParede">Os Equipamentos e cabos ficaram organizados na parede, de acordo com o Padrão Ti Connect?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="velocidade" id="velocidade">
                                <label for="velocidade">Foi Feito o teste de velocidade?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="acessoRemoto" id="acessoRemoto">
                                <label for="acessoRemoto">Foi ativado o Ping e liberado o acesso remoto?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="nomeRede" id="nomeRede">
                                <label for="nomeRede">Foi inserido o nome (Ticonnect), na rede wifi?</label>
                            </div>
                            <div>
                                <label for="obs">OBS:</label>
                                <input type="text" name="obs" id="obs">
                            </div>
                        </form>
                        <div class="buttons-salvar-checklist">
                            <button type="button" onclick="calcularSoma(<?php echo $index ?>)">Calcular Soma</button>
                            <button type="submit" class="button-form" id="formEditColaborador">Salvar</button>
                        </div>
                    </div>
                </div>



            <?php endforeach ?>
            <div>
                <?php echo $erro_mensagem ?>
            </div>
        </section>
    </section>


</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('#abrirAvaliar');
        const forms = document.querySelectorAll('.box-checklist form');

        buttons.forEach((button) => {
            button.addEventListener('click', function() {
                const assunto = button.getAttribute('data-assunto');

                // Ocultar todos os formulários
                forms.forEach(form => {
                    form.classList.remove('active');
                });

                // Mostrar o formulário correspondente ao assunto
                forms.forEach(form => {
                    if (form.getAttribute('data-assunto') === assunto) {
                        form.classList.add('active');
                    }
                });
            });
        });
    });
    // abrir caixa de avaliar

    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('#abrirDetalhes');
        const boxes = document.querySelectorAll('.box-detalhes');

        buttons.forEach((button, index) => {
            button.addEventListener('click', function() {
                const selectedBox = boxes[index];

                // Oculta todas as caixas
                boxes.forEach(box => {
                    if (box !== selectedBox) {
                        box.classList.remove('active');
                    }
                });

                // Alterna a classe 'active' na caixa clicada
                selectedBox.classList.toggle('active');
            });
        });
    });

    // soma checkbox

    function calcularSoma(index) {
        // Selecionar o formulário específico
        const form = document.querySelector(`#form-${index}`);
        const checkboxes = form.querySelectorAll('input[type="checkbox"]');
        let soma = 0;

        // Iterar sobre todos os checkboxes e somar os valores dos marcados
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                soma += parseInt(checkbox.value);
            }
        });

        // Exibir a soma ou fazer outra coisa com ela
        alert(`A soma dos valores dos checkboxes marcados no formulário ${index} é: ${soma}`);
    }
</script>

<script src="../../../script/dashboard.js?v=1"></script>

</html>