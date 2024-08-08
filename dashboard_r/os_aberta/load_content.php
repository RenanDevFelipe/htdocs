<?php

require_once '../../api/os_por_assunto/os_sem_acesso.php';
require_once '../../api/os_por_assunto/os_oscilacao.php';
require_once '../../api/os_por_assunto/os_lentidao.php';
require_once '../../api/os_por_assunto/os_instalacao.php';
require_once '../../api/os_por_assunto/os_troca_de_endereco.php';
require_once '../../api/os_por_assunto/os_troca_de_equipamento.php';
require_once '../../api/os_por_assunto/total_os_mes.php';

// Simulando um atraso de 2 segundos para a resposta
sleep(2);

// Conteúdo dinâmico
$content = '
<section class="os-por-assunto">
    <div class="title">
        <h1>O.S aberta por assunto</h1>
        <p>Total de O.S Mensal: ' . $os_total . '</p>
    </div>

    <div class="list-geral-os">
        <div class="list-of-oss">
            <div class="box-os">
                <div class="id-os">
                    <p>ID: 28</p>
                </div>
                <div class="title-os">
                    <p>Sem Acesso</p>
                    <p>' . $sem_acesso_total . '</p>
                </div>
            </div>
            <div class="box-os">
                <div class="id-os">
                    <p>ID: 23</p>
                </div>
                <div class="title-os">
                    <p>Oscilação</p>
                    <p>' . $oscilacao_total . '</p>
                </div>
            </div>
            <div class="box-os">
                <div class="id-os">
                    <p>ID: 27</p>
                </div>
                <div class="title-os">
                    <p>Lentidão</p>
                    <p>' . $lentidao_total . '</p>
                </div>
            </div>
            <div class="box-os">
                <div class="id-os">
                    <p>ID: 10</p>
                </div>
                <div class="title-os">
                    <p>Instalação Fibra</p>
                    <p>' . $instalacao_total . '</p>
                </div>
            </div>
            <div class="box-os">
                <div class="id-os">
                    <p>ID: 70</p>
                </div>
                <div class="title-os">
                    <p>Troca de endereço</p>
                    <p>' . $mud_endereco_total . '</p>
                </div>
            </div>
            <div class="box-os">
                <div class="id-os">
                    <p>ID: 26</p>
                </div>
                <div class="title-os">
                    <p>Troca de Equipamento</p>
                    <p>' . $equipamento_total . '</p>
                </div>
            </div>
        </div>
    </div>
</section>';

echo $content;

?>