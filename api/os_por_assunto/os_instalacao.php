<?php 

require_once '../../api/api.php';

$data_ano = date("Y");
$data_mes = date("m");

// Data inicial (início do dia)
$data_inicio = $data_ano . '-' . $data_mes . '-01' . ' 00:00:00';

// Obtém o último dia do mês atual
$ultimoDiaMes = new DateTime('last day of this month');
$data_fim = $ultimoDiaMes->format('Y-m-d') . ' 23:59:59';

// Parâmetros para a API
$params = array(
    'qtype' => 'su_oss_chamado.id_assunto',
    'query' => '10',
    'oper' => '=',
    'page' => '1',
    'rp' => '20',
    'sortname' => 'su_oss_chamado.id',
    'sortorder' => 'desc',
    'grid_param' => json_encode(array(
        array('TB' => 'su_oss_chamado.data_abertura', 'OP' => '>=', 'P' => $data_inicio),
        array('TB' => 'su_oss_chamado.data_abertura', 'OP' => '<=', 'P' => $data_fim))
    ));

$api->get('su_oss_chamado', $params);
$retorno = $api->getRespostaConteudo(false);
$os_instalacao = json_decode($retorno);

if($os_instalacao->total < 1){
    $instalacao_total = 0;
}else{
    $instalacao_total = $os_instalacao->total;
}

?>
