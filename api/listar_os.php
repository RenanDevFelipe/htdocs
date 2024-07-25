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
        array('TB' => 'su_oss_chamado.data_fechamento', 'OP' => '>=', 'P' => $data_inicio),
        array('TB' => 'su_oss_chamado.data_fechamento', 'OP' => '<=', 'P' => $data_fim)
    ))
);

$api->get('su_oss_chamado', $params);
$retorno = $api->getRespostaConteudo(false);
$os_fin= json_decode($retorno);

$i = 0;
$id_cliente = array();
$desc_os = array();
$fechamento_os = array();
$id_os_ixc = array();

while($i < $os_fin->total){
    $id_cliente[] = $os_fin->registros[$i]->id_cliente;
    $desc_os[] = $os_fin->registros[$i]->mensagem;
    $fechamento_os[] = $os_fin->registros[$i]->data_fechamento;
    $id_os_ixc[] = $os_fin->registros[$i]->id;
    $i++;
}


$nomes_clientes = array();


foreach ($os_fin->registros as $chamado) {
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

function zip($array1, $array2, $array3, $array4, $array5) {
    $zipped = [];
    $length = min(count($array1), count($array2), count($array3), count($array4), count($array5));
    for ($i = 0; $i < $length; $i++) {
        $zipped[] = [$array1[$i], $array2[$i], $array3[$i], $array4[$i], $array5[$i]];
    }
    return $zipped;
}


?>