<?php 

require_once 'api.php';

// Data corrente
$data_time = date("Y-m-d");

// Data inicial (início do dia)
$data_inicio = $data_time . ' 00:00:00';

// Data final (fim do dia)
$data_fim = $data_time . ' 23:59:59';

// Configuração dos parâmetros para a requisição
$params = array(
    'qtype' => 'su_oss_chamado.id', // campo de filtro
    'query' => '', // valor para consultar
    'oper' => '=', // operador da consulta
    'page' => '1', // página a ser mostrada
    'rp' => '20', // quantidade de registros por página
    'sortname' => 'su_oss_chamado.id', // campo para ordenar a consulta
    'sortorder' => 'desc', // ordenação (asc = crescente | desc = decrescente)
    'grid_param' => json_encode(array(
        array('TB' => 'su_oss_chamado.data_abertura', 'OP' => '>=', 'P' => $data_inicio),
        array('TB' => 'su_oss_chamado.data_abertura', 'OP' => '<=', 'P' => $data_fim)
    ))
);

// Faz a requisição à API
$api->get('su_oss_chamado', $params);

// Obtém a resposta da API
$retorno = $api->getRespostaConteudo(false);

// Decodifica a resposta JSON
$total_os_do_dia = json_decode($retorno);


?>
