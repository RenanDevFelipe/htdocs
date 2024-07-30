<?php
require_once '../core/core.php';
require_once '../api/api.php';

$sql = $pdo->prepare('SELECT id_colaborador, id_ixc FROM colaborador');
$sql->execute();
$id_colaborador_ixc = $sql->fetchAll();

$id_atendimento = [];


$data_time = date("Y-m-d");

// Data inicial (início do dia)
$data_inicio = $data_time . ' 00:00:00';

// Data final (fim do dia)
$data_fim = $data_time . ' 23:59:59';


$params = array(
    'qtype' => 'su_oss_chamado.id_tecnico',
    'query' => 114,
    'oper' => '=',
    'page' => '1',
    'rp' => '20',
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

$i = 0;
while($i < $teste->total){
    $id_atendimento[] = $teste->registros[$i]->id_ticket;
    $i++;
}


print_r($id_atendimento);

