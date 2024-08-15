<?php
require_once "../../../core/core.php";
require_once "../../../autentication/index.php";
require_once "../../../slide_menu/slide_bar_menu.php";
require_once "../../../api/listar_os.php";
require_once "../../../api/os_aberta_do_dia.php";

$mostrar = 0;
$avaliado = false;
$avaliador_nome = $_SESSION['user_name'];
?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../style/dashboard.css?v=4">
    <link rel="stylesheet" href="index.css?v=12">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Avaliação N3</title>
</head>

<body>
    <section class="body-os home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
            <p><strong>Total de OS:</strong> <?php echo $os_fin->total ?></p>
        </div>
        <div id="pesquisa">
            <form id="formData" action="" method="GET">
                <input type="hidden" name="id_colaborador" value="<?php echo htmlspecialchars($_GET['id_colaborador']); ?>">
                <input type="hidden" name="bd" value="<?php echo htmlspecialchars($_GET['bd']); ?>">
                <input type="date" name="data" id="dataInput" value="<?php echo isset($_GET['data']) ? $_GET['data'] : ''; ?>">
            </form>
        </div>
        <section class="dashboard-tecnicos-ranking">
            <?php
            foreach (zip($desc_os, $nomes_clientes, $fechamento_os, $id_os_ixc, $id_cliente, $abertura_os, $id_assunto,) as $index => $pair) :
                list($desc, $cliente, $fechamento, $id, $id_cliente, $abertura_os, $id_assunto) = $pair;
                // Consulta para verificar se o colaborador já existe
                $sql = $pdo->prepare('SELECT * FROM avaliacao_n3 WHERE id_os = ?');
                $sql->execute([$id]);

                $avaliado = $sql->rowCount() > 0;
                $avaliador = $sql->fetch(PDO::FETCH_ASSOC);
            ?>
                <div>
                    <div class="box-tecnico">
                        <div id="tecnico">
                            <div>
                                <div class="box-check" title="<?php echo $avaliado ? 'Já Finalizado!' : 'Não Finalizado!'; ?>">
                                    <div style="background-color: <?php echo $avaliado ? 'red' : 'green'; ?>;"></div>
                                    <p><?php echo $avaliado ? 'Finalizado! ' . '[' . $avaliador['avaliador'] . ']' : 'Não Finalizado!'; ?></p>
                                </div>
                                <p> <?php echo $fechamento ?> </p>
                            </div>
                            <p> <?php echo $id_cliente . ' - ' . $cliente ?> </p>
                        </div>
                        <div class="avaliar">
                            <div id="abrirDetalhes">
                                <i class="bx bx-collection"></i>
                                <a>Detalhes</a>
                            </div>
                            <div class="hidden" id="abrirAvaliar" data-id-tecnico="<?php echo $_GET['bd'] ?>" data-desc="<?php echo $desc ?>" data-finalizacao-os="<?php echo $fechamento ?>" data-assunto="<?php echo $id_assunto ?>" data-id-os="<?php echo $id ?>">
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
        const avaliador = "<?php echo $avaliador_nome ?>";
        const forms = {
            28: (idOS, descOS, fechamentoOS, formId, id_setor, nota_os, pontuacao_os, id_tecnico) => `
                        <form  class="formulario_sem_acesso" method="post" id="form_${idOS}">
                             <div>
                                <input value="${id_tecnico}" type="hidden" name="idTecnico_${idOS}" id="idTecnico_${idOS}">
                            </div>
                            <div>
                                <input value="${descOS}" type="hidden" name="descOS_${idOS}" id="descOS_${idOS}">
                            </div>
                            <div>
                                <input value="${fechamentoOS}" type="hidden" name="fechamentoOS_${idOS}" id="fechamentoOS_${idOS}">
                            </div>
                            <div>
                                <input value="${formId}" type="hidden" name="formId_${idOS}" id="formId_${idOS}">
                            </div>
                            <div>
                                <input value="${nota_os}" type="hidden" name="notaOS_${idOS}" id="notaOS_${idOS}">
                            </div>
                            <div>
                                <input value="${pontuacao_os}" type="hidden" name="pontuacaoOS_${idOS}" id="pontuacaoOS_${idOS}">
                            </div>
                            <div>
                                <input value="${id_setor}" type="hidden" name="setor_${idOS}" id="setor_${idOS}">
                            </div>
                            <div>
                                <input value="${avaliador}" type="text" name="avaliador_${idOS}" id="avaliador_${idOS}">
                            </div>
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
                                <input class="checkbox" value="1" type="checkbox" name="canal_${idOS}" id="canal_${idOS}">
                                <label for="canal_${idOS}">Configurou o canal e largura do equipamento?</label>
                            </div>
                            <div>
                                <label for="obs_${idOS}">OBS:</label>
                                <input class="obs" type="text" name="obs_${idOS}" id="obs_${idOS}">
                            </div>
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
            11: (idOS, descOS, fechamentoOS, formId, id_setor, nota_os, pontuacao_os, id_tecnico) => `
                        <form  class="formulario_suporte_tecnico" method="post" id="form_${idOS}">
                            <div>
                                <input value="${id_tecnico}" type="hidden" name="idTecnico_${idOS}" id="idTecnico_${idOS}">
                            </div>
                            <div>
                                <input value="${descOS}" type="hidden" name="descOS_${idOS}" id="descOS_${idOS}">
                            </div>
                            <div>
                                <input value="${fechamentoOS}" type="hidden" name="fechamentoOS_${idOS}" id="fechamentoOS_${idOS}">
                            </div>
                            <div>
                                <input value="${formId}" type="hidden" name="formId_${idOS}" id="formId_${idOS}">
                            </div>
                            <div>
                                <input value="${nota_os}" type="hidden" name="notaOS_${idOS}" id="notaOS_${idOS}">
                            </div>
                            <div>
                                <input value="${pontuacao_os}" type="hidden" name="pontuacaoOS_${idOS}" id="pontuacaoOS_${idOS}">
                            </div>
                            <div>
                                <input value="${id_setor}" type="hidden" name="setor_${idOS}" id="setor_${idOS}">
                            </div>
                            <div>
                                <input value="${avaliador}" type="hidden" name="avaliador_${idOS}" id="avaliador_${idOS}">
                            </div>
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
                                <input class="obs" type="text" name="obs_${idOS}" id="obs_${idOS}">
                            </div>
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
            45: (idOS, descOS, fechamentoOS, formId, id_setor, nota_os, pontuacao_os, id_tecnico) => `
                        <form  class="formulario_puxa_cabo" method="post" id="form_${idOS}">
                            <div>
                                <input value="${id_tecnico}" type="hidden" name="idTecnico_${idOS}" id="idTecnico_${idOS}">
                            </div>
                            <div>
                                <input value="${descOS}" type="hidden" name="descOS_${idOS}" id="descOS_${idOS}">
                            </div>
                            <div>
                                <input value="${fechamentoOS}" type="hidden" name="fechamentoOS_${idOS}" id="fechamentoOS_${idOS}">
                            </div>
                            <div>
                                <input value="${formId}" type="hidden" name="formId_${idOS}" id="formId_${idOS}">
                            </div>
                            <div>
                                <input value="${nota_os}" type="hidden" name="notaOS_${idOS}" id="notaOS_${idOS}">
                            </div>
                            <div>
                                <input value="${pontuacao_os}" type="hidden" name="pontuacaoOS_${idOS}" id="pontuacaoOS_${idOS}">
                            </div>
                            <div>
                                <input value="${id_setor}" type="hidden" name="setor_${idOS}" id="setor_${idOS}">
                            </div>
                            <div>
                                <input value="${avaliador}" type="hidden" name="avaliador_${idOS}" id="avaliador_${idOS}">
                            </div>
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
                                <input class="obs" type="text" name="obs_${idOS}" id="obs_${idOS}">
                            </div>
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
            87: (idOS, descOS, fechamentoOS, formId, id_setor, nota_os, pontuacao_os, id_tecnico) => `
                        <form  class="formulario_troca_cabo" method="post" id="form_${idOS}">
                            <div>
                                <input value="${id_tecnico}" type="hidden" name="idTecnico_${idOS}" id="idTecnico_${idOS}">
                            </div>
                            <div>
                                <input value="${descOS}" type="hidden" name="descOS_${idOS}" id="descOS_${idOS}">
                            </div>
                            <div>
                                <input value="${fechamentoOS}" type="hidden" name="fechamentoOS_${idOS}" id="fechamentoOS_${idOS}">
                            </div>
                            <div>
                                <input value="${formId}" type="hidden" name="formId_${idOS}" id="formId_${idOS}">
                            </div>
                            <div>
                                <input value="${nota_os}" type="hidden" name="notaOS_${idOS}" id="notaOS_${idOS}">
                            </div>
                            <div>
                                <input value="${pontuacao_os}" type="hidden" name="pontuacaoOS_${idOS}" id="pontuacaoOS_${idOS}">
                            </div>
                            <div>
                                <input value="${id_setor}" type="hidden" name="setor_${idOS}" id="setor_${idOS}">
                            </div>
                            <div>
                                <input value="${avaliador}" type="hidden" name="avaliador_${idOS}" id="avaliador_${idOS}">
                            </div>
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
                                <input class="obs" type="text" name="obs_${idOS}" id="obs_${idOS}">
                            </div>
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
            27: (idOS, descOS, fechamentoOS, formId, id_setor, nota_os, pontuacao_os, id_tecnico) =>   `
                        <form data-teste="${avaliador}"  class="formulario_lentidao" method="post" id="form_${idOS}">
                            <div>
                                <input value="${id_tecnico}" type="hidden" name="idTecnico_${idOS}" id="idTecnico_${idOS}">
                            </div>
                            <div>
                                <input value="${descOS}" type="hidden" name="descOS_${idOS}" id="descOS_${idOS}">
                            </div>
                            <div>
                                <input value="${fechamentoOS}" type="hidden" name="fechamentoOS_${idOS}" id="fechamentoOS_${idOS}">
                            </div>
                            <div>
                                <input value="${formId}" type="hidden" name="formId_${idOS}" id="formId_${idOS}">
                            </div>
                            <div>
                                <input value="${nota_os}" type="hidden" name="notaOS_${idOS}" id="notaOS_${idOS}">
                            </div>
                            <div>
                                <input value="${pontuacao_os}" type="hidden" name="pontuacaoOS_${idOS}" id="pontuacaoOS_${idOS}">
                            </div>
                            <div>
                                <input value="${id_setor}" type="hidden" name="setor_${idOS}" id="setor_${idOS}">
                            </div>
                            <div>
                                <input value="${avaliador}" type="hidden" name="avaliador_${idOS}" id="avaliador_${idOS}">
                            </div>
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
                                <input class="obs" type="text" name="obs_${idOS}" id="obs_${idOS}">
                            </div>
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
            23: (idOS, descOS, fechamentoOS, formId, id_setor, nota_os, pontuacao_os, id_tecnico) => `
                        <form  class="formulario_oscilacao" method="post" id="form_${idOS}">
                            <div>
                                <input value="${id_tecnico}" type="hidden" name="idTecnico_${idOS}" id="idTecnico_${idOS}">
                            </div>
                            <div>
                                <input value="${descOS}" type="hidden" name="descOS_${idOS}" id="descOS_${idOS}">
                            </div>
                            <div>
                                <input value="${fechamentoOS}" type="hidden" name="fechamentoOS_${idOS}" id="fechamentoOS_${idOS}">
                            </div>
                            <div>
                                <input value="${formId}" type="hidden" name="formId_${idOS}" id="formId_${idOS}">
                            </div>
                            <div>
                                <input value="${nota_os}" type="hidden" name="notaOS_${idOS}" id="notaOS_${idOS}">
                            </div>
                            <div>
                                <input value="${pontuacao_os}" type="hidden" name="pontuacaoOS_${idOS}" id="pontuacaoOS_${idOS}">
                            </div>
                            <div>
                                <input value="${id_setor}" type="hidden" name="setor_${idOS}" id="setor_${idOS}">
                            </div>
                            <div>
                                <input value="${avaliador}" type="hidden" name="avaliador_${idOS}" id="avaliador_${idOS}">
                            </div>
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
                                <input class="obs" type="text" name="obs_${idOS}" id="obs_${idOS}">
                            </div>
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
            10: (idOS, descOS, fechamentoOS, formId, id_setor, nota_os, pontuacao_os, id_tecnico) => `
                        <form  class="formulario_instalacao" method="post" id="form_${idOS}">
                            <div>
                                <input value="${id_tecnico}" type="hidden" name="idTecnico_${idOS}" id="idTecnico_${idOS}">
                            </div>
                            <div>
                                <input value="${descOS}" type="hidden" name="descOS_${idOS}" id="descOS_${idOS}">
                            </div>
                            <div>
                                <input value="${fechamentoOS}" type="hidden" name="fechamentoOS_${idOS}" id="fechamentoOS_${idOS}">
                            </div>
                            <div>
                                <input value="${formId}" type="hidden" name="formId_${idOS}" id="formId_${idOS}">
                            </div>
                            <div>
                                <input value="${nota_os}" type="hidden" name="notaOS_${idOS}" id="notaOS_${idOS}">
                            </div>
                            <div>
                                <input value="${pontuacao_os}" type="hidden" name="pontuacaoOS_${idOS}" id="pontuacaoOS_${idOS}">
                            </div>
                            <div>
                                <input value="${id_setor}" type="hidden" name="setor_${idOS}" id="setor_${idOS}">
                            </div>
                            <div>
                                <input value="${avaliador}" type="hidden" name="avaliador_${idOS}" id="avaliador_${idOS}">
                            </div>
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
                                <label for="canal_${idOS}">Configurações do equipamento Canal e Largura</label>
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
                                <input class="obs" type="text" name="obs_${idOS}" id="obs_${idOS}">
                            </div>
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
            70: (idOS, descOS, fechamentoOS, formId, id_setor, nota_os, pontuacao_os, id_tecnico) => `
                        <form  class="formulario_troca_endereco" method="post" id="form_${idOS}">
                            <div>
                                <input value="${id_tecnico}" type="hidden" name="idTecnico_${idOS}" id="idTecnico_${idOS}">
                            </div>
                            <div>
                                <input value="${descOS}" type="hidden" name="descOS_${idOS}" id="descOS_${idOS}">
                            </div>
                            <div>
                                <input value="${fechamentoOS}" type="hidden" name="fechamentoOS_${idOS}" id="fechamentoOS_${idOS}">
                            </div>
                            <div>
                                <input value="${formId}" type="hidden" name="formId_${idOS}" id="formId_${idOS}">
                            </div>
                            <div>
                                <input value="${nota_os}" type="hidden" name="notaOS_${idOS}" id="notaOS_${idOS}">
                            </div>
                            <div>
                                <input value="${pontuacao_os}" type="hidden" name="pontuacaoOS_${idOS}" id="pontuacaoOS_${idOS}">
                            </div>
                            <div>
                                <input value="${id_setor}" type="hidden" name="setor_${idOS}" id="setor_${idOS}">
                            </div>
                            <div>
                                <input value="${avaliador}" type="hidden" name="avaliador_${idOS}" id="avaliador_${idOS}">
                            </div>
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
                                <input class="obs" type="text" name="obs_${idOS}" id="obs_${idOS}">
                            </div>
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
            26: (idOS, descOS, fechamentoOS, formId, id_setor, nota_os, pontuacao_os, id_tecnico) => `
                        <form  class="formulario_troca_equipamento" method="post" id="form_${idOS}">
                            <div>
                                <input value="${id_tecnico}" type="hidden" name="idTecnico_${idOS}" id="idTecnico_${idOS}">
                            </div>
                            <div>
                                <input value="${descOS}" type="hidden" name="descOS_${idOS}" id="descOS_${idOS}">
                            </div>
                            <div>
                                <input value="${fechamentoOS}" type="hidden" name="fechamentoOS_${idOS}" id="fechamentoOS_${idOS}">
                            </div>
                            <div>
                                <input value="${formId}" type="hidden" name="formId_${idOS}" id="formId_${idOS}">
                            </div>
                            <div>
                                <input value="${nota_os}" type="hidden" name="notaOS_${idOS}" id="notaOS_${idOS}">
                            </div>
                            <div>
                                <input value="${pontuacao_os}" type="hidden" name="pontuacaoOS_${idOS}" id="pontuacaoOS_${idOS}">
                            </div>
                            <div>
                                <input value="${id_setor}" type="hidden" name="setor_${idOS}" id="setor_${idOS}">
                            </div>
                            <div>
                                <input value="${avaliador}" type="hidden" name="avaliador_${idOS}" id="avaliador_${idOS}">
                            </div>
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
                                <input class="obs" type="text" name="obs_${idOS}" id="obs_${idOS}">
                            </div>
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
            308: (idOS, descOS, fechamentoOS, formId, id_setor, nota_os, pontuacao_os, id_tecnico) => `
                        <form class="formulario_instalacao_camera " method="post" id="form_${idOS}">
                            <div>
                                <input value="${id_tecnico}" type="hidden" name="idTecnico_${idOS}" id="idTecnico_${idOS}">
                            </div>
                            <div>
                                <input value="${descOS}" type="hidden" name="descOS_${idOS}" id="descOS_${idOS}">
                            </div>
                            <div>
                                <input value="${fechamentoOS}" type="hidden" name="fechamentoOS_${idOS}" id="fechamentoOS_${idOS}">
                            </div>
                            <div>
                                <input value="${formId}" type="hidden" name="formId_${idOS}" id="formId_${idOS}">
                            </div>
                            <div>
                                <input value="${nota_os}" type="hidden" name="notaOS_${idOS}" id="notaOS_${idOS}">
                            </div>
                            <div>
                                <input value="${pontuacao_os}" type="hidden" name="pontuacaoOS_${idOS}" id="pontuacaoOS_${idOS}">
                            </div>
                            <div>
                                <input value="${id_setor}" type="hidden" name="setor_${idOS}" id="setor_${idOS}">
                            </div>
                            <div>
                                <input value="${avaliador}" type="hidden" name="avaliador_${idOS}" id="avaliador_${idOS}">
                            </div>
                            <div>
                                <input value="1" type="checkbox" name="execucao_${idOS}" id="execucao_${idOS}">
                                <label for="execucao_${idOS}">A ordem de serviço estava com o Status em "Execução"? </label>
                            </div>

                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="potencia_${idOS}" id="potencia_${idOS}">
                                <label for="potencia_${idOS}">Foi aferida a potência do Sinal, na casa do cliente e na CTO? Frequência 1490nm.</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="potenciaBoa_${idOS}" id="potenciaBoa_${idOS}">
                                <label for="potenciaBoa_${idOS}">A potência do sinal óptico ficou na margem de sinal permitido = ou < que -25db?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="organizadoCaixa_${idOS}" id="organizadoCaixa_${idOS}">
                                <label for="organizadoCaixa_${idOS}">Foi organizado os cabos na CTO/Caixa?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="organizadoParede_${idOS}" id="organizadoParede_${idOS}">
                                <label for="organizadoParede_${idOS}">Os Equipamentos e cabos ficaram organizados na parede, de acordo com o Padrão Ti Connect?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="velocidade_${idOS}" id="velocidade_${idOS}">
                                <label for="velocidade_${idOS}">Foi Feito o teste de velocidade?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="acessoRemoto_${idOS}" id="acessoRemoto_${idOS}">
                                <label for="acessoRemoto_${idOS}">Foi ativado o Ping e liberado o acesso remoto?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="nomeRede_${idOS}" id="nomeRede_${idOS}">
                                <label for="nomeRede_${idOS}">Foi inserido o nome (Ticonnect), na rede wifi?</label>
                            </div>
                            <div>
                                <label for="obs_${idOS}">OBS:</label>
                                <input class="obs" type="text" name="obs_${idOS}" id="obs_${idOS}">
                            </div>
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
            357: (idOS, descOS, fechamentoOS, formId, id_setor, nota_os, pontuacao_os, id_tecnico) => `
                        <form class="formulario_suporte_camera " method="post" id="form_${idOS}">
                        <div>
                                <input value="${id_tecnico}" type="hidden" name="idTecnico_${idOS}" id="idTecnico_${idOS}">
                            </div>
                            <div>
                                <input value="${descOS}" type="hidden" name="descOS_${idOS}" id="descOS_${idOS}">
                            </div>
                            <div>
                                <input value="${fechamentoOS}" type="hidden" name="fechamentoOS_${idOS}" id="fechamentoOS_${idOS}">
                            </div>
                            <div>
                                <input value="${formId}" type="hidden" name="formId_${idOS}" id="formId_${idOS}">
                            </div>
                            <div>
                                <input value="${nota_os}" type="hidden" name="notaOS_${idOS}" id="notaOS_${idOS}">
                            </div>
                            <div>
                                <input value="${pontuacao_os}" type="hidden" name="pontuacaoOS_${idOS}" id="pontuacaoOS_${idOS}">
                            </div>
                            <div>
                                <input value="${id_setor}" type="hidden" name="setor_${idOS}" id="setor_${idOS}">
                            </div>
                            <div>
                                <input value="${avaliador}" type="hidden" name="avaliador_${idOS}" id="avaliador_${idOS}">
                            </div>
                            <div>
                                <input value="1" type="checkbox" name="execucao_${idOS}" id="execucao_${idOS}">
                                <label for="execucao_${idOS}">A ordem de serviço estava com o Status em "Execução"? </label>
                            </div>

                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="potencia_${idOS}" id="potencia_${idOS}">
                                <label for="potencia_${idOS}">Foi aferida a potência do Sinal, na casa do cliente e na CTO? Frequência 1490nm.</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="potenciaBoa_${idOS}" id="potenciaBoa_${idOS}">
                                <label for="potenciaBoa_${idOS}">A potência do sinal óptico ficou na margem de sinal permitido = ou < que -25db?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="organizadoCaixa_${idOS}" id="organizadoCaixa_${idOS}">
                                <label for="organizadoCaixa_${idOS}">Foi organizado os cabos na CTO/Caixa?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="organizadoParede_${idOS}" id="organizadoParede_${idOS}">
                                <label for="organizadoParede_${idOS}">Os Equipamentos e cabos ficaram organizados na parede, de acordo com o Padrão Ti Connect?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="velocidade_${idOS}" id="velocidade_${idOS}">
                                <label for="velocidade_${idOS}">Foi Feito o teste de velocidade?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="acessoRemoto_${idOS}" id="acessoRemoto_${idOS}">
                                <label for="acessoRemoto_${idOS}">Foi ativado o Ping e liberado o acesso remoto?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="nomeRede_${idOS}" id="nomeRede_${idOS}">
                                <label for="nomeRede_${idOS}">Foi inserido o nome (Ticonnect), na rede wifi?</label>
                            </div>
                            <div>
                                <label for="obs_${idOS}">OBS:</label>
                                <input class="obs" type="text" name="obs_${idOS}" id="obs_${idOS}">
                            </div>
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
            425: (idOS, descOS, fechamentoOS, formId, id_setor, nota_os, pontuacao_os, id_tecnico) => `
                        <form class="formulario_instalacao_iptv " method="post" id="form_${idOS}">
                            <div>
                                <input value="${id_tecnico}" type="hidden" name="idTecnico_${idOS}" id="idTecnico_${idOS}">
                            </div>
                            <div>
                                <input value="${descOS}" type="hidden" name="descOS_${idOS}" id="descOS_${idOS}">
                            </div>
                            <div>
                                <input value="${fechamentoOS}" type="hidden" name="fechamentoOS_${idOS}" id="fechamentoOS_${idOS}">
                            </div>
                            <div>
                                <input value="${formId}" type="hidden" name="formId_${idOS}" id="formId_${idOS}">
                            </div>
                            <div>
                                <input value="${nota_os}" type="hidden" name="notaOS_${idOS}" id="notaOS_${idOS}">
                            </div>
                            <div>
                                <input value="${pontuacao_os}" type="hidden" name="pontuacaoOS_${idOS}" id="pontuacaoOS_${idOS}">
                            </div>
                            <div>
                                <input value="${id_setor}" type="hidden" name="setor_${idOS}" id="setor_${idOS}">
                            </div>
                            <div>
                                <input value="${avaliador}" type="hidden" name="avaliador_${idOS}" id="avaliador_${idOS}">
                            </div>
                            <div>
                                <input value="1" type="checkbox" name="link_${idOS}" id="link_${idOS}">
                                <label for="link_${idOS}">Foi tirado a foto do link no aplicativo?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="funcionando_${idOS}" id="funcionando_${idOS}">
                                <label for="funcionando_${idOS}">Foi tirada a foto do IPTV funcionando?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="organizacao_${idOS}" id="organizacao_${idOS}">
                                <label for="organizacao_${idOS}">Foi tirada a foto da organização(TV/TVBOX)?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="cabeamento_${idOS}" id="cabeamento_${idOS}">
                                <label for="cabeamento_${idOS}">Foi tirada a foto do cabeamento TVBOX->TV?</label>
                            </div>
                            <div>
                                <label for="obs_${idOS}">OBS:</label>
                                <input class="obs" type="text" name="obs_${idOS}" id="obs_${idOS}">
                            </div>
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
            452: (idOS, descOS, fechamentoOS, formId, id_setor, nota_os, pontuacao_os, id_tecnico) => `
                        <form class="formulario_suporte_iptv " method="post" id="form_${idOS}">
                            <div>
                                <input value="${id_tecnico}" type="hidden" name="idTecnico_${idOS}" id="idTecnico_${idOS}">
                            </div>
                            <div>
                                <input value="${descOS}" type="hidden" name="descOS_${idOS}" id="descOS_${idOS}">
                            </div>
                            <div>
                                <input value="${fechamentoOS}" type="hidden" name="fechamentoOS_${idOS}" id="fechamentoOS_${idOS}">
                            </div>
                            <div>
                                <input value="${formId}" type="hidden" name="formId_${idOS}" id="formId_${idOS}">
                            </div>
                            <div>
                                <input value="${nota_os}" type="hidden" name="notaOS_${idOS}" id="notaOS_${idOS}">
                            </div>
                            <div>
                                <input value="${pontuacao_os}" type="hidden" name="pontuacaoOS_${idOS}" id="pontuacaoOS_${idOS}">
                            </div>
                            <div>
                                <input value="${id_setor}" type="hidden" name="setor_${idOS}" id="setor_${idOS}">
                            </div>
                            <div>
                                <input value="${avaliador}" type="hidden" name="avaliador_${idOS}" id="avaliador_${idOS}">
                            </div>
                            <div>
                                <input value="1" type="checkbox" name="link_${idOS}" id="link_${idOS}">
                                <label for="link_${idOS}">Foi tirado a foto do link no aplicativo?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="funcionando_${idOS}" id="funcionando_${idOS}">
                                <label for="funcionando_${idOS}">Foi tirada a foto do IPTV funcionando?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="organizacao_${idOS}" id="organizacao_${idOS}">
                                <label for="organizacao_${idOS}">Foi tirada a foto da organização(TV/TVBOX)?</label>
                            </div>
                            <div>
                                <input class="checkbox" value="1" type="checkbox" name="cabeamento_${idOS}" id="cabeamento_${idOS}">
                                <label for="cabeamento_${idOS}">Foi tirada a foto do cabeamento TVBOX->TV?</label>
                            </div>
                            <div>
                                <label for="obs_${idOS}">OBS:</label>
                                <input class="obs" type="text" name="obs_${idOS}" id="obs_${idOS}">
                            </div>
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
        };

        document.querySelectorAll('#abrirAvaliar').forEach(link => {
            link.addEventListener('click', event => {
                event.preventDefault();

                const formId = link.getAttribute('data-assunto');
                const idOS = link.getAttribute('data-id-os');
                const descOS = link.getAttribute('data-desc');
                const fechamentoOS = link.getAttribute('data-finalizacao-os');
                const id_setor = "5";
                var pontuacao_os = 0;
                var nota_os = 0;
                const id_tecnico = link.getAttribute('data-id-tecnico');
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

                boxAvaliar.innerHTML = forms[formId](idOS, descOS, fechamentoOS, formId, id_setor, nota_os, pontuacao_os, id_tecnico);

                const form = document.getElementById(`form_${idOS}`);
                console.log(form);
                form.querySelectorAll('input').forEach(input => {
                    input.addEventListener('change', event => {
                        console.log(`Input ${event.target.id} changed to ${event.target.checked ? 'checked' : 'unchecked'}`);
                    });
                });

                const sumButton = document.getElementById(`form-avaliar_${idOS}`);
                sumButton.addEventListener('click', () => {
                    let sum = 0;
                    form.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
                        sum += parseInt(checkbox.value);
                    });
                    pontuacao_os = sum;
                    const quantidade_inputs = form.querySelectorAll('input[type="checkbox"');

                    const checkboxes = form.querySelectorAll('form input[type="checkbox"]');
                    let soma = 0;
                    checkboxes.forEach(checkbox => {
                        soma += parseFloat(checkbox.value);
                    });

                    nota_os = (pontuacao_os * 10) / soma;

                    console.log('pontuação da OS: ' + pontuacao_os);
                    console.log('total de value: ' + soma);
                    console.log('nota_os é: ' + nota_os);

                    Swal.fire({
                        title: 'Resultado',
                        text: `A soma dos valores dos checkboxes marcados é: ${sum}`,
                        icon: 'info',
                        confirmButtonText: 'OK'
                    });
                    if (formId == 452) {
                        generateAndCopyTextIPTV(idOS);
                    } else if (formId == 23 || formId == 87 || formId == 28 || formId == 27 || formId == 11 || formId == 45) {
                        generateAndCopyText(idOS);
                    } else if (formId == 357) {
                        generateAndCopyTextCamera(idOS);
                    } else if (formId == 10 || formId == 70) {
                        generateAndCopyTextInstalacao(idOS);
                    } else if (formId == 357) {
                        generateAndCopyTextInstalacaoCamera(idOS);
                    } else if (formId == 452) {
                        generateAndCopyTextSuporteIPTV(idOS);
                    }



                    const formData = new FormData(form);
                    form.querySelector(`input[name="pontuacaoOS_${idOS}"]`).value = pontuacao_os;
                    form.querySelector(`input[name="notaOS_${idOS}"]`).value = nota_os;
                    formData.set(`pontuacaoOS_${idOS}`, pontuacao_os);
                    formData.set(`notaOS_${idOS}`, nota_os);

                    fetch(`inserir_avaliacao.php?idOS=${idOS}`, {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Success:', data);
                            if (data.missing_fields) {
                                console.log('Campos ausentes:', data.missing_fields);
                            } else if (data.message == "Avaliação ja existe!") {
                                Swal.fire({
                                    title: 'Erro',
                                    text: data.message,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            } else if (data.message == "Avaliação feita com sucesso!") {
                                Swal.fire({
                                    title: 'Sucesso',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                                location.reload();
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Erro',
                                text: 'Erro ao enviar os dados.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        });
                });
            });
        });

    });

    // Define a função no escopo global

    function generateAndCopyText(idOS) {
        const fields = [{
                id: `execucao_${idOS}`,
                label: 'A ordem de serviço estava com o Status em "Execução"?'
            },
            {
                id: `potencia_${idOS}`,
                label: 'Foi aferida a potência do Sinal, na casa do cliente e na CTO? Frequência 1490nm.'
            },
            {
                id: `potenciaBoa_${idOS}`,
                label: 'A potência do sinal óptico ficou na margem de sinal permitido = ou < que -25db?'
            },
            {
                id: `organizadoCaixa_${idOS}`,
                label: 'Foi organizado os cabos na CTO/Caixa?'
            },
            {
                id: `organizadoParede_${idOS}`,
                label: 'Os Equipamentos e cabos ficaram organizados na parede, de acordo com o Padrão Ti Connect?'
            },
            {
                id: `velocidade_${idOS}`,
                label: 'Foi Feito o teste de velocidade?'
            },
            {
                id: `acessoRemoto_${idOS}`,
                label: 'Foi ativado o Ping e liberado o acesso remoto?'
            },
            {
                id: `nomeRede_${idOS}`,
                label: 'Foi inserido o nome (Ticonnect), na rede wifi?'
            },
        ];

        let resultText = '';

        fields.forEach(field => {
            const checkbox = document.getElementById(field.id);
            if (checkbox) {
                resultText += `${field.label}\nSim (${checkbox.checked ? 'X' : ' '}) Não (${checkbox.checked ? ' ' : 'X'})\n\n`;
            } else {
                console.warn(`Elemento com ID ${field.id} não encontrado.`);
            }
        });

        const obs = document.getElementById(`obs_${idOS}`);
        if (obs) {
            resultText += `OBS: ${obs.value}\n`;
        } else {
            console.warn(`Elemento com ID obs_${idOS} não encontrado.`);
        }

        navigator.clipboard.writeText(resultText).then(() => {
            Swal.fire({
                title: 'Sucesso',
                text: 'Texto copiado para a área de transferência!',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        }).catch(err => {
            console.error('Erro ao copiar o texto: ', err);
            Swal.fire({
                title: 'Erro',
                text: 'Erro ao copiar o texto.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    }


    function generateAndCopyTextInstalacao(idOS) {
        const fields = [{
                id: `execucao_${idOS}`,
                label: 'A ordem de serviço estava com o Status em "Execução"?'
            },
            {
                id: `potencia_${idOS}`,
                label: 'Foi aferida a potência do Sinal, na casa do cliente e na CTO? Frequência 1490nm.'
            },
            {
                id: `canal_${idOS}`,
                label: 'Configurações do equipamento Canal e Largura'
            },
            {
                id: `potenciaBoa_${idOS}`,
                label: 'A potência do sinal óptico ficou na margem de sinal permitido = ou < que -25db?'
            },
            {
                id: `organizadoCaixa_${idOS}`,
                label: 'Foi organizado os cabos na CTO/Caixa?'
            },
            {
                id: `organizadoParede_${idOS}`,
                label: 'Os Equipamentos e cabos ficaram organizados na parede, de acordo com o Padrão Ti Connect?'
            },
            {
                id: `velocidade_${idOS}`,
                label: 'Foi Feito o teste de velocidade?'
            },
            {
                id: `acessoRemoto_${idOS}`,
                label: 'Foi ativado o Ping e liberado o acesso remoto?'
            },
            {
                id: `nomeRede_${idOS}`,
                label: 'Foi inserido o nome (Ticonnect), na rede wifi?'
            },
        ];

        let resultText = '';

        fields.forEach(field => {
            const checkbox = document.getElementById(field.id);
            if (checkbox) {
                resultText += `${field.label}\nSim (${checkbox.checked ? 'X' : ' '}) Não (${checkbox.checked ? ' ' : 'X'})\n\n`;
            } else {
                console.warn(`Elemento com ID ${field.id} não encontrado.`);
            }
        });

        const obs = document.getElementById(`obs_${idOS}`);
        if (obs) {
            resultText += `OBS: ${obs.value}\n`;
        } else {
            console.warn(`Elemento com ID obs_${idOS} não encontrado.`);
        }

        navigator.clipboard.writeText(resultText).then(() => {
            Swal.fire({
                title: 'Sucesso',
                text: 'Texto copiado para a área de transferência!',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        }).catch(err => {
            console.error('Erro ao copiar o texto: ', err);
            Swal.fire({
                title: 'Erro',
                text: 'Erro ao copiar o texto.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    }

    function generateAndCopyTextIPTV(idOS) {
        const fields = [{
                id: `link_${idOS}`,
                label: 'Foi tirado a foto do link no aplicativo?'
            },
            {
                id: `funcionando_${idOS}`,
                label: 'Foi tirada a foto do IPTV funcionando?'
            },
            {
                id: `organizacao_${idOS}`,
                label: 'Foi tirada a foto da organização(TV/TVBOX)?'
            },
            {
                id: `cabeamento_${idOS}`,
                label: 'Foi tirada a foto do cabeamento TVBOX->TV?'
            },
        ];

        let resultText = '';

        fields.forEach(field => {
            const checkbox = document.getElementById(field.id);
            if (checkbox) {
                resultText += `${field.label}\nSim (${checkbox.checked ? 'X' : ' '}) Não (${checkbox.checked ? ' ' : 'X'})\n\n`;
            } else {
                console.warn(`Elemento com ID ${field.id} não encontrado.`);
            }
        });

        const obs = document.getElementById(`obs_${idOS}`);
        if (obs) {
            resultText += `OBS: ${obs.value}\n`;
        } else {
            console.warn(`Elemento com ID obs_${idOS} não encontrado.`);
        }

        navigator.clipboard.writeText(resultText).then(() => {
            Swal.fire({
                title: 'Sucesso',
                text: 'Texto copiado para a área de transferência!',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        }).catch(err => {
            console.error('Erro ao copiar o texto: ', err);
            Swal.fire({
                title: 'Erro',
                text: 'Erro ao copiar o texto.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    }

    function generateAndCopyTextCamera(idOS) {
        const fields = [{
                id: `link_${idOS}`,
                label: 'Foi tirado a foto do link no aplicativo?'
            },
            {
                id: `funcionando_${idOS}`,
                label: 'Foi tirada a foto do IPTV funcionando?'
            },
            {
                id: `organizacao_${idOS}`,
                label: 'Foi tirada a foto da organização(TV/TVBOX)?'
            },
            {
                id: `cabeamento_${idOS}`,
                label: 'Foi tirada a foto do cabeamento TVBOX->TV?'
            },
        ];

        let resultText = '';

        fields.forEach(field => {
            const checkbox = document.getElementById(field.id);
            if (checkbox) {
                resultText += `${field.label}\nSim (${checkbox.checked ? 'X' : ' '}) Não (${checkbox.checked ? ' ' : 'X'})\n\n`;
            } else {
                console.warn(`Elemento com ID ${field.id} não encontrado.`);
            }
        });

        const obs = document.getElementById(`obs_${idOS}`);
        if (obs) {
            resultText += `OBS: ${obs.value}\n`;
        } else {
            console.warn(`Elemento com ID obs_${idOS} não encontrado.`);
        }

        navigator.clipboard.writeText(resultText).then(() => {
            Swal.fire({
                title: 'Sucesso',
                text: 'Texto copiado para a área de transferência!',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        }).catch(err => {
            console.error('Erro ao copiar o texto: ', err);
            Swal.fire({
                title: 'Erro',
                text: 'Erro ao copiar o texto.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    }

    function generateAndCopyTextInstalacaoCamera(idOS) {
        const fields = [{
                id: `link_${idOS}`,
                label: 'Foi tirado a foto do link no aplicativo?'
            },
            {
                id: `funcionando_${idOS}`,
                label: 'Foi tirada a foto do IPTV funcionando?'
            },
            {
                id: `organizacao_${idOS}`,
                label: 'Foi tirada a foto da organização(TV/TVBOX)?'
            },
            {
                id: `cabeamento_${idOS}`,
                label: 'Foi tirada a foto do cabeamento TVBOX->TV?'
            },
        ];

        let resultText = '';

        fields.forEach(field => {
            const checkbox = document.getElementById(field.id);
            if (checkbox) {
                resultText += `${field.label}\nSim (${checkbox.checked ? 'X' : ' '}) Não (${checkbox.checked ? ' ' : 'X'})\n\n`;
            } else {
                console.warn(`Elemento com ID ${field.id} não encontrado.`);
            }
        });

        const obs = document.getElementById(`obs_${idOS}`);
        if (obs) {
            resultText += `OBS: ${obs.value}\n`;
        } else {
            console.warn(`Elemento com ID obs_${idOS} não encontrado.`);
        }

        navigator.clipboard.writeText(resultText).then(() => {
            Swal.fire({
                title: 'Sucesso',
                text: 'Texto copiado para a área de transferência!',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        }).catch(err => {
            console.error('Erro ao copiar o texto: ', err);
            Swal.fire({
                title: 'Erro',
                text: 'Erro ao copiar o texto.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    }

    function generateAndCopyTextSuporteIPTV(idOS) {
        const fields = [{
                id: `link_${idOS}`,
                label: 'Foi tirado a foto do link no aplicativo?'
            },
            {
                id: `funcionando_${idOS}`,
                label: 'Foi tirada a foto do IPTV funcionando?'
            },
            {
                id: `organizacao_${idOS}`,
                label: 'Foi tirada a foto da organização(TV/TVBOX)?'
            },
            {
                id: `cabeamento_${idOS}`,
                label: 'Foi tirada a foto do cabeamento TVBOX->TV?'
            },
        ];

        let resultText = '';

        fields.forEach(field => {
            const checkbox = document.getElementById(field.id);
            if (checkbox) {
                resultText += `${field.label}\nSim (${checkbox.checked ? 'X' : ' '}) Não (${checkbox.checked ? ' ' : 'X'})\n\n`;
            } else {
                console.warn(`Elemento com ID ${field.id} não encontrado.`);
            }
        });

        const obs = document.getElementById(`obs_${idOS}`);
        if (obs) {
            resultText += `OBS: ${obs.value}\n`;
        } else {
            console.warn(`Elemento com ID obs_${idOS} não encontrado.`);
        }

        navigator.clipboard.writeText(resultText).then(() => {
            Swal.fire({
                title: 'Sucesso',
                text: 'Texto copiado para a área de transferência!',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        }).catch(err => {
            console.error('Erro ao copiar o texto: ', err);
            Swal.fire({
                title: 'Erro',
                text: 'Erro ao copiar o texto.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    }



    // form submit 

    document.getElementById('dataInput').addEventListener('change', function() {
        document.getElementById('formData').submit();
    });
</script>
<script src="index.js"></script>
<script src="../../../script/dashboard.js?v=1"></script>

</html>