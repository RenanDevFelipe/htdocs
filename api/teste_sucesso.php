<?php
require_once '../core/core.php';
require_once '../api/api.php';

// Aumentar o tempo máximo de execução para 300 segundos (5 minutos)
set_time_limit(300);

// Obtendo todos os colaboradores e seus id_ixc
$sql = $pdo->prepare('SELECT id_colaborador, id_ixc FROM colaborador');
$sql->execute();
$id_colaborador_ixc = $sql->fetchAll();

// Função para substituir os IDs pelos valores correspondentes
function substituir_ids($pontuacao, $id_diagnostico)
{
    foreach ($pontuacao as &$id) {
        if (isset($id_diagnostico[$id])) {
            $id = $id_diagnostico[$id];
        }
    }
    return $pontuacao;
}

$id_diagnostico = array(
    '50' => '10',
    '49' => '5',
    '51' => '0'
);

$data_ano = date("Y");
$data_mes = date("m");
$date_sucesso = date("Y-m-d");

// Data inicial (início do dia)
$data_inicio = $data_ano . '-' . $data_mes . '-01' . ' 00:00:00';

// Obtém o último dia do mês atual
$ultimoDiaMes = new DateTime('last day of this month');
$data_fim = $ultimoDiaMes->format('Y-m-d') . ' 23:59:59';

$inicio_sucesso = $date_sucesso . ' 00:00:00';
$fim_sucesso = $date_sucesso . ' 23:59:59';

// Itera sobre cada colaborador e faz a requisição da API
foreach ($id_colaborador_ixc as $colaborador) {
    $id_ixc = $colaborador['id_ixc'];

    $params = array(
        'qtype' => 'su_oss_chamado.id_tecnico',
        'query' => $id_ixc,
        'oper' => '=',
        'page' => '1',
        'rp' => '180',
        'sortname' => 'su_oss_chamado.id',
        'sortorder' => 'desc',
        'grid_param' => json_encode(array(
            array('TB' => 'su_oss_chamado.status', 'OP' => '=', 'P' => 'F'),
            array('TB' => 'su_oss_chamado.data_fechamento', 'OP' => '>=', 'P' => $data_inicio),
            array('TB' => 'su_oss_chamado.data_fechamento', 'OP' => '<=', 'P' => $data_fim),
            array('TB' => 'su_oss_chamado.tipo', 'OP' => '=', 'P' => 'C')
        ))
    );

    $api->get('su_oss_chamado', $params);
    $retorno = $api->getRespostaConteudo(false);
    $teste = json_decode($retorno);

    if ($teste->total > 0) {
        $id_atendimento = [];
        foreach ($teste->registros as $registro) {
            if (!in_array($registro->id_ticket, $id_atendimento)) {
                $id_atendimento[] = $registro->id_ticket;
            }
        }

        foreach ($id_atendimento as $id_sucesso) {
            $params = array(
                'qtype' => 'su_oss_chamado.id_ticket',
                'query' => $id_sucesso,
                'oper' => '=',
                'page' => '1',
                'rp' => '180',
                'sortname' => 'su_oss_chamado.id',
                'sortorder' => 'desc',
                'grid_param' => json_encode(array(
                    array('TB' => 'su_oss_chamado.status', 'OP' => '=', 'P' => 'F'),
                    array('TB' => 'su_oss_chamado.data_fechamento', 'OP' => '>=', 'P' => $inicio_sucesso),
                    array('TB' => 'su_oss_chamado.data_fechamento', 'OP' => '<=', 'P' => $fim_sucesso),
                    array('TB' => 'su_oss_chamado.setor', 'OP' => '=', 'P' => '36'),
                    array('TB' => 'su_oss_chamado.id_assunto', 'OP' => '=', 'P' => '416')
                ))
            );

            $api->get('su_oss_chamado', $params);
            $retorno = $api->getRespostaConteudo(false);
            $teste_1 = json_decode($retorno);

            if ($teste_1->total > 0) {
                $id_ticket = $id_sucesso;
                $ponto_sucesso = substituir_ids($teste_1->registros[0]->id_su_diagnostico, $id_diagnostico);
                $colaborador_sucesso =  $colaborador['id_colaborador'];
                $id_setor = 8;
                $data_sucesso = date('Y-m-d');

                $sql = $pdo->prepare('SELECT COUNT(*) FROM avaliacao_sucesso WHERE id_atendimento = ?');
                $sql->execute([$id_ticket]);

                if($sql->fetchColumn() == 0){
                    $sql = $pdo->prepare('INSERT INTO avaliacao_sucesso (id_atendimento, id_tecnico, id_setor, ponto_sucesso, data_avaliacao) VALUES (?, ?, ?, ?, ?)');
                    $sql->execute([$id_ticket, $colaborador_sucesso, $id_setor, $ponto_sucesso, $data_sucesso]);
                }
            }
        }

    }
}

?>
