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
    <link rel="stylesheet" href="index.css?v=7">
    <title>Avaliação N3</title>
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
                            <div class="hidden" id="abrirAvaliar" data-assunto="<?php echo $id_assunto ?>" data-id-os="<?php echo $id ?>">
                                <i class="bx bx-star"></i>
                                <nav>
                                    <a>Avaliar</a>
                                </nav>
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
                    <div class="box-avaliar hidden" id="box-avaliar-<?php echo $id_assunto ?>-<?php echo $id ?>"></div>
                </div>



            <?php endforeach ?>
            <div>
                <?php echo $erro_mensagem ?>
            </div>
        </section>
    </section>


</body>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const forms = {
            28: (idOS) => `
                        <form  class="formulario_sem_acesso" method="post" id="form_${idOS}">
                            <div>
                                <input value="2" type="checkbox" name="execucao_${idOS}" id="execucao_${idOS}">
                                <label for="execucao_${idOS}">A ordem de serviço estava com o Status em "Execução"? </label>
                            </div>

                            <div>
                                <input class="checkbox" value="3" type="checkbox" name="potencia_${idOS}" id="potencia_${idOS}">
                                <label for="potencia_${idOS}">Foi aferida a potência do Sinal, na casa do cliente e na CTO? Frequência 1490nm.</label>
                            </div>
                            <div>
                                <input class="checkbox" value="3" type="checkbox" name="potenciaBoa_${idOS}" id="potenciaBoa_${idOS}">
                                <label for="potenciaBoa_${idOS}">A potência do sinal óptico ficou na margem de sinal permitido = ou < que -25db?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="2" type="checkbox" name="organizadoParede_${idOS}" id="organizadoParede_${idOS}">
                                <label for="organizadoParede_${idOS}">Os Equipamentos e cabos ficaram organizados na parede, de acordo com o Padrão Ti Connect?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="2" type="checkbox" name="velocidade_${idOS}" id="velocidade_${idOS}">
                                <label for="velocidade_${idOS}">Foi Feito o teste de velocidade?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="3" type="checkbox" name="acessoRemoto_${idOS}" id="acessoRemoto_${idOS}">
                                <label for="acessoRemoto_${idOS}">Foi ativado o Ping e liberado o acesso remoto?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="nomeRede_${idOS}" id="nomeRede_${idOS}">
                                <label for="nomeRede_${idOS}">Foi inserido o nome (Ticonnect), na rede wifi?</label>
                            </div>
                            <div>
                                <label for="obs_${idOS}">OBS:</label>
                                <input type="text" name="obs_${idOS}" id="obs_${idOS}">
                            </div>
                            <button type="button" id="sumButton_${idOS}">Somar Valores</button> 
                            <button type="button" onclick="generateAndCopyText('${idOS}')">Copiar Texto</button>  
                            <div id="form-avaliar_${idOS}" class="form-avaliar">
                                <div>
                                    <i class="bx bx-star"></i>
                                    <nav>
                                        <a>Avaliar</a>
                                    </nav>
                                </div>     
                            </div>              
                        </form>
                `,
            11: (idOS) => `
                        <form  class="formulario_suporte_tecnico" method="post" id="form_${idOS}">
                            <div>
                                <input value="2" type="checkbox" name="execucao_${idOS}" id="execucao_${idOS}">
                                <label for="execucao_${idOS}">A ordem de serviço estava com o Status em "Execução"? </label>
                            </div>

                            <div>
                                <input class="checkbox" value="3" type="checkbox" name="potencia_${idOS}" id="potencia_${idOS}">
                                <label for="potencia_${idOS}">Foi aferida a potência do Sinal, na casa do cliente e na CTO? Frequência 1490nm.</label>
                            </div>
                            <div>
                                <input class="checkbox" value="3" type="checkbox" name="potenciaBoa_${idOS}" id="potenciaBoa_${idOS}">
                                <label for="potenciaBoa_${idOS}">A potência do sinal óptico ficou na margem de sinal permitido = ou < que -25db?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="2" type="checkbox" name="organizadoParede_${idOS}" id="organizadoParede_${idOS}">
                                <label for="organizadoParede_${idOS}">Os Equipamentos e cabos ficaram organizados na parede, de acordo com o Padrão Ti Connect?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="2" type="checkbox" name="velocidade_${idOS}" id="velocidade_${idOS}">
                                <label for="velocidade_${idOS}">Foi Feito o teste de velocidade?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="3" type="checkbox" name="acessoRemoto_${idOS}" id="acessoRemoto_${idOS}">
                                <label for="acessoRemoto_${idOS}">Foi ativado o Ping e liberado o acesso remoto?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="nomeRede_${idOS}" id="nomeRede_${idOS}">
                                <label for="nomeRede_${idOS}">Foi inserido o nome (Ticonnect), na rede wifi?</label>
                            </div>
                            <div>
                                <label for="obs_${idOS}">OBS:</label>
                                <input type="text" name="obs_${idOS}" id="obs_${idOS}">
                            </div>
                            <button type="button" id="sumButton_${idOS}">Somar Valores</button>
                            <button type="button" onclick="generateAndCopyText('${idOS}')">Copiar Texto</button> 
                        </form>
                `,
            27: (idOS) => `
                        <form  class="formulario_lentidao" method="post" id="form_${idOS}">
                            <div>
                                <input value="2" type="checkbox" name="execucao_${idOS}" id="execucao_${idOS}">
                                <label for="execucao_${idOS}">A ordem de serviço estava com o Status em "Execução"? </label>
                            </div>

                            <div>
                                <input class="checkbox" value="3" type="checkbox" name="potencia_${idOS}" id="potencia_${idOS}">
                                <label for="potencia_${idOS}">Foi aferida a potência do Sinal, na casa do cliente e na CTO? Frequência 1490nm.</label>
                            </div>
                            <div>
                                <input class="checkbox" value="3" type="checkbox" name="potenciaBoa_${idOS}" id="potenciaBoa_${idOS}">
                                <label for="potenciaBoa_${idOS}">A potência do sinal óptico ficou na margem de sinal permitido = ou < que -25db?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="2" type="checkbox" name="organizadoParede_${idOS}" id="organizadoParede_${idOS}">
                                <label for="organizadoParede_${idOS}">Os Equipamentos e cabos ficaram organizados na parede, de acordo com o Padrão Ti Connect?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="2" type="checkbox" name="velocidade_${idOS}" id="velocidade_${idOS}">
                                <label for="velocidade_${idOS}">Foi Feito o teste de velocidade?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="3" type="checkbox" name="acessoRemoto_${idOS}" id="acessoRemoto_${idOS}">
                                <label for="acessoRemoto_${idOS}">Foi ativado o Ping e liberado o acesso remoto?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="nomeRede_${idOS}" id="nomeRede_${idOS}">
                                <label for="nomeRede_${idOS}">Foi inserido o nome (Ticonnect), na rede wifi?</label>
                            </div>
                            <div>
                                <label for="obs_${idOS}">OBS:</label>
                                <input type="text" name="obs_${idOS}" id="obs_${idOS}">
                            </div>
                            <button type="button" id="sumButton_${idOS}">Somar Valores</button>
                            <button type="button" onclick="generateAndCopyText('${idOS}')">Copiar Texto</button> 
                        </form>
                `,
            23: (idOS) => `
                        <form  class="formulario_oscilacao" method="post" id="form_${idOS}">
                            <div>
                                <input value="2" type="checkbox" name="execucao_${idOS}" id="execucao_${idOS}">
                                <label for="execucao_${idOS}">A ordem de serviço estava com o Status em "Execução"? </label>
                            </div>

                            <div>
                                <input class="checkbox" value="3" type="checkbox" name="potencia_${idOS}" id="potencia_${idOS}">
                                <label for="potencia_${idOS}">Foi aferida a potência do Sinal, na casa do cliente e na CTO? Frequência 1490nm.</label>
                            </div>
                            <div>
                                <input class="checkbox" value="3" type="checkbox" name="potenciaBoa_${idOS}" id="potenciaBoa_${idOS}">
                                <label for="potenciaBoa_${idOS}">A potência do sinal óptico ficou na margem de sinal permitido = ou < que -25db?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="2" type="checkbox" name="organizadoParede_${idOS}" id="organizadoParede_${idOS}">
                                <label for="organizadoParede_${idOS}">Os Equipamentos e cabos ficaram organizados na parede, de acordo com o Padrão Ti Connect?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="2" type="checkbox" name="velocidade_${idOS}" id="velocidade_${idOS}">
                                <label for="velocidade_${idOS}">Foi Feito o teste de velocidade?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="3" type="checkbox" name="acessoRemoto_${idOS}" id="acessoRemoto_${idOS}">
                                <label for="acessoRemoto_${idOS}">Foi ativado o Ping e liberado o acesso remoto?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="nomeRede_${idOS}" id="nomeRede_${idOS}">
                                <label for="nomeRede_${idOS}">Foi inserido o nome (Ticonnect), na rede wifi?</label>
                            </div>
                            <div>
                                <label for="obs_${idOS}">OBS:</label>
                                <input type="text" name="obs_${idOS}" id="obs_${idOS}">
                            </div>
                            <button type="button" id="sumButton_${idOS}">Somar Valores</button>
                            <button type="button" onclick="generateAndCopyText('${idOS}')">Copiar Texto</button> 
                        </form>
                `,
            10: (idOS) => `
                        <form  class="formulario_sem_acesso" method="post" id="form_${idOS}">
                            <div>
                                <input value="2" type="checkbox" name="execucao_${idOS}" id="execucao_${idOS}">
                                <label for="execucao_${idOS}">A ordem de serviço estava com o Status em "Execução"? </label>
                            </div>

                            <div>
                                <input class="checkbox" value="3" type="checkbox" name="potencia_${idOS}" id="potencia_${idOS}">
                                <label for="potencia_${idOS}">Foi aferida a potência do Sinal, na casa do cliente e na CTO? Frequência 1490nm.</label>
                            </div>
                            <div>
                                <input class="checkbox" value="3" type="checkbox" name="potenciaBoa_${idOS}" id="potenciaBoa_${idOS}">
                                <label for="potenciaBoa_${idOS}">A potência do sinal óptico ficou na margem de sinal permitido = ou < que -25db?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="2" type="checkbox" name="canal_${idOS}" id="canal_${idOS}">
                                <label for="canal_${idOS}">onfigurações do equipamento Canal e Largura</label>
                            </div>
                            <div>
                                <input class="checkbox" value="2" type="checkbox" name="velocidade_${idOS}" id="velocidade_${idOS}">
                                <label for="velocidade_${idOS}">Foi Feito o teste de velocidade?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="3" type="checkbox" name="acessoRemoto_${idOS}" id="acessoRemoto_${idOS}">
                                <label for="acessoRemoto_${idOS}">Foi ativado o Ping e liberado o acesso remoto?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="2" type="checkbox" name="organizadoParede_${idOS}" id="organizadoParede_${idOS}">
                                <label for="organizadoParede_${idOS}">Os Equipamentos e cabos ficaram organizados na parede, de acordo com o Padrão Ti Connect?</label>
                            </div>         
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="nomeRede_${idOS}" id="nomeRede_${idOS}">
                                <label for="nomeRede_${idOS}">Foi inserido o nome (Ticonnect), na rede wifi?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="2" type="checkbox" name="central_${idOS}" id="central_${idOS}">
                                <label for="central_${idOS}">baixou central do cliente no telefone do cliente?</label>
                            </div>
                            <div>
                                <label for="obs_${idOS}">OBS:</label>
                                <input type="text" name="obs_${idOS}" id="obs_${idOS}">
                            </div>
                            <button type="button" id="sumButton_${idOS}">Somar Valores</button>
                            <button type="button" onclick="generateAndCopyText('${idOS}')">Copiar Texto</button> 
                        </form>
                `,
            70: (idOS) => `
                        <form  class="formulario_sem_acesso" method="post" id="form_${idOS}">
                            <div>
                                <input value="2" type="checkbox" name="execucao_${idOS}" id="execucao_${idOS}">
                                <label for="execucao_${idOS}">A ordem de serviço estava com o Status em "Execução"? </label>
                            </div>

                            <div>
                                <input class="checkbox" value="3" type="checkbox" name="potencia_${idOS}" id="potencia_${idOS}">
                                <label for="potencia_${idOS}">Foi aferida a potência do Sinal, na casa do cliente e na CTO? Frequência 1490nm.</label>
                            </div>
                            <div>
                                <input class="checkbox" value="3" type="checkbox" name="potenciaBoa_${idOS}" id="potenciaBoa_${idOS}">
                                <label for="potenciaBoa_${idOS}">A potência do sinal óptico ficou na margem de sinal permitido = ou < que -25db?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="2" type="checkbox" name="canal_${idOS}" id="canal_${idOS}">
                                <label for="canal_${idOS}">onfigurações do equipamento Canal e Largura</label>
                            </div>
                            <div>
                                <input class="checkbox" value="2" type="checkbox" name="velocidade_${idOS}" id="velocidade_${idOS}">
                                <label for="velocidade_${idOS}">Foi Feito o teste de velocidade?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="3" type="checkbox" name="acessoRemoto_${idOS}" id="acessoRemoto_${idOS}">
                                <label for="acessoRemoto_${idOS}">Foi ativado o Ping e liberado o acesso remoto?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="2" type="checkbox" name="organizadoParede_${idOS}" id="organizadoParede_${idOS}">
                                <label for="organizadoParede_${idOS}">Os Equipamentos e cabos ficaram organizados na parede, de acordo com o Padrão Ti Connect?</label>
                            </div>         
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="nomeRede_${idOS}" id="nomeRede_${idOS}">
                                <label for="nomeRede_${idOS}">Foi inserido o nome (Ticonnect), na rede wifi?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="2" type="checkbox" name="central_${idOS}" id="central_${idOS}">
                                <label for="central_${idOS}">baixou central do cliente no telefone do cliente?</label>
                            </div>
                            <div>
                                <label for="obs_${idOS}">OBS:</label>
                                <input type="text" name="obs_${idOS}" id="obs_${idOS}">
                            </div>
                            <button type="button" id="sumButton_${idOS}">Somar Valores</button>
                            <button type="button" onclick="generateAndCopyText('${idOS}')">Copiar Texto</button> 
                        </form>
                `,
            26: (idOS) => `
                        <form  class="formulario_troca_equipamento" method="post" id="form_${idOS}">
                            <div>
                                <input value="2" type="checkbox" name="execucao_${idOS}" id="execucao_${idOS}">
                                <label for="execucao_${idOS}">A ordem de serviço estava com o Status em "Execução"? </label>
                            </div>

                            <div>
                                <input class="checkbox" value="3" type="checkbox" name="potencia_${idOS}" id="potencia_${idOS}">
                                <label for="potencia_${idOS}">Foi aferida a potência do Sinal, na casa do cliente e na CTO? Frequência 1490nm.</label>
                            </div>
                            <div>
                                <input class="checkbox" value="3" type="checkbox" name="potenciaBoa_${idOS}" id="potenciaBoa_${idOS}">
                                <label for="potenciaBoa_${idOS}">A potência do sinal óptico ficou na margem de sinal permitido = ou < que -25db?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="2" type="checkbox" name="organizadoParede_${idOS}" id="organizadoParede_${idOS}">
                                <label for="organizadoParede_${idOS}">Os Equipamentos e cabos ficaram organizados na parede, de acordo com o Padrão Ti Connect?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="2" type="checkbox" name="velocidade_${idOS}" id="velocidade_${idOS}">
                                <label for="velocidade_${idOS}">Foi Feito o teste de velocidade?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="3" type="checkbox" name="acessoRemoto_${idOS}" id="acessoRemoto_${idOS}">
                                <label for="acessoRemoto_${idOS}">Foi ativado o Ping e liberado o acesso remoto?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="nomeRede_${idOS}" id="nomeRede_${idOS}">
                                <label for="nomeRede_${idOS}">Foi inserido o nome (Ticonnect), na rede wifi?</label>
                            </div>
                            <div>
                                <label for="obs_${idOS}">OBS:</label>
                                <input type="text" name="obs_${idOS}" id="obs_${idOS}">
                            </div>
                            <button type="button" id="sumButton_${idOS}">Somar Valores</button>
                            <button type="button" onclick="generateAndCopyText('${idOS}')">Copiar Texto</button> 
                        </form>
                `,
            308: (idOS) => `
                        <form class="formulario_instalacao_camera " method="post">
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
                            <button type="button" id="sumButton_${idOS}">Somar Valores</button>
                            <button type="button" onclick="generateAndCopyText('${idOS}')">Copiar Texto</button> 
                        </form>
                `,
            357: (idOS) => `
                        <form class="formulario_suporte_camera " method="post">
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
                            <button type="button" id="sumButton_${idOS}">Somar Valores</button>
                            <button type="button" onclick="generateAndCopyText('${idOS}')">Copiar Texto</button> 
                        </form>
                `,
            425: (idOS) => `
                        <form class="formulario_instalacao_iptv " method="post">
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
                            <button type="button" id="sumButton_${idOS}">Somar Valores</button>
                            <button type="button" onclick="generateAndCopyText('${idOS}')">Copiar Texto</button> 
                        </form>
                `,
            452: (idOS) => `
                        <form class="formulario_suporte_iptv " method="post">
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
                            <button type="button" id="sumButton_${idOS}">Somar Valores</button>
                            <button type="button" onclick="generateAndCopyText('${idOS}')">Copiar Texto</button> 
                        </form>
                `,
        };

        document.querySelectorAll('#abrirAvaliar').forEach(link => {
        link.addEventListener('click', event => {
            event.preventDefault();

            const formId = link.getAttribute('data-assunto');
            const idOS = link.getAttribute('data-id-os');
            const descOS = link.getAttribute('data-desc');

            const boxId = `box-avaliar-${formId}-${idOS}`;
            let boxAvaliar = document.getElementById(boxId);

            if (!boxAvaliar) {
                boxAvaliar = document.createElement('div');
                boxAvaliar.id = boxId;
                document.body.appendChild(boxAvaliar);
            }

            if (boxAvaliar.classList.contains('hidden')) {
                boxAvaliar.classList.remove('hidden');
            } else {
                boxAvaliar.classList.add('hidden');
            }

            boxAvaliar.innerHTML = forms[formId](idOS);

            // Adiciona event listeners aos inputs do formulário gerado
            const form = document.getElementById(`form_${idOS}`);
            console.log(form);
            form.querySelectorAll('input').forEach(input => {
                input.addEventListener('change', event => {
                    console.log(`Input ${event.target.id} changed to ${event.target.checked ? 'checked' : 'unchecked'}`);
                });
            });

            // Adiciona event listener ao botão de soma
            const sumButton = document.getElementById(`form-avaliar_${idOS}`);
            sumButton.addEventListener('click', () => {
                let sum = 0;
                form.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
                    sum += parseInt(checkbox.value);
                });
                alert(`A soma dos valores dos checkboxes marcados é: ${sum}`);
            });
        });
    });
});

// Define a função no escopo global

function generateAndCopyText(idOS) {
    const fields = [
        { id: `execucao_${idOS}`, label: 'A ordem de serviço estava com o Status em "Execução"?' },
        { id: `potencia_${idOS}`, label: 'Foi aferida a potência do Sinal, na casa do cliente e na CTO? Frequência 1490nm.' },
        { id: `potenciaBoa_${idOS}`, label: 'A potência do sinal óptico ficou na margem de sinal permitido = ou < que -25db?' },
        { id: `organizadoCaixa_${idOS}`, label: 'Foi organizado os cabos na CTO/Caixa?' },
        { id: `organizadoParede_${idOS}`, label: 'Os Equipamentos e cabos ficaram organizados na parede, de acordo com o Padrão Ti Connect?' },
        { id: `velocidade_${idOS}`, label: 'Foi Feito o teste de velocidade?' },
        { id: `acessoRemoto_${idOS}`, label: 'Foi ativado o Ping e liberado o acesso remoto?' },
        { id: `nomeRede_${idOS}`, label: 'Foi inserido o nome (Ticonnect), na rede wifi?' },
    ];

    let resultText = '';

    fields.forEach(field => {
        const checkbox = document.getElementById(field.id);
        if (checkbox) { // Verifica se o elemento existe
            resultText += `${field.label}\nSim (${checkbox.checked ? 'X' : ' '}) Não (${checkbox.checked ? ' ' : 'X'})\n\n`;
        } else {
            console.warn(`Elemento com ID ${field.id} não encontrado.`);
        }
    });

    const obs = document.getElementById(`obs_${idOS}`);
    if (obs) { // Verifica se o elemento existe
        resultText += `OBS: ${obs.value}\n`;
    } else {
        console.warn(`Elemento com ID obs_${idOS} não encontrado.`);
    }

    navigator.clipboard.writeText(resultText).then(() => {
        alert('Texto copiado para a área de transferência!');
    }).catch(err => {
        console.error('Erro ao copiar o texto: ', err);
    });
}


</script>
<script src="index.js"></script>
<script src="../../../script/dashboard.js?v=1"></script>

</html>