<?php 

include_once 'api.php';

$data_time = date("Y-m-d");

//inicio
$data_inicio = $data_time . '00:00:00';

//fim
$data_fim = $data_time . '23:59:59';

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
        array('TB' => 'su_oss_chamado.data_abertura', 'OP' => '<=', 'P' => $data_fim),
        array('TB' => 'su_oss_chamado.status', 'OP' => '=', 'P' => 'F')
    ))
);

$api->get('su_oss_chamado', $params);
$retorno = $api->getRespostaConteudo(false);

$total_os_finalizada_do_dia = json_decode($retorno);

if(isset($total_os_finalizada_do_dia->total)){
    print_r($total_os_finalizada_do_dia->total);
}else{
    echo "Erro: a resposta da API não contém a propriedade 'total'.";
}

?>