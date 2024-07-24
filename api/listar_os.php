<?php
require_once "api.php";

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
        array('TB' => 'su_oss_chamado.status', 'OP' => '=', 'P' => 'AG')
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