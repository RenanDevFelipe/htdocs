<?php
require_once "api.php";
$data_time = date("Y-m-d");

// Data inicial (início do dia)
$data_inicio = $data_time . ' 00:00:00';

// Data final (fim do dia)
$data_fim = $data_time . ' 23:59:59';

$id_tecnico = $_GET['id_colaborador'];

$params = array(
    'qtype' => 'su_oss_chamado.id_tecnico',
    'query' => $id_tecnico,
    'oper' => '=',
    'page' => '1',
    'rp' => '20',
    'sortname' => 'su_oss_chamado.id',
    'sortorder' => 'desc',
    'grid_param' => json_encode(array(
        array('TB' => 'su_oss_chamado.status', 'OP' => '=', 'P' => 'F'),
        array('TB' => 'su_oss_chamado.data_abertura', 'OP' => '>=', 'P' => $data_inicio),
        array('TB' => 'su_oss_chamado.data_abertura', 'OP' => '<=', 'P' => $data_fim)
    ))
);

$api->get('su_oss_chamado', $params);
$retorno = $api->getRespostaConteudo(false);
$teste = json_decode($retorno);


$nomes_clientes= array();

foreach ($teste->registros as $chamado) {
    $params = array(
        'qtype' => 'cliente.id',
        'query' => $chamado->id_cliente,
        'oper' => '=',
        'page' => '1',
        'rp' => '20',
        'sortname' => 'cliente.id',
        'sortorder' => 'desc'
    );

    $api->get('cliente', $params);
    $retorno_cliente = $api->getRespostaConteudo(false);
    $cliente = json_decode($retorno_cliente);

    $nomes_clientes[] = $cliente->registros[0]->razao;
}