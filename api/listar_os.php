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
        array('TB' => 'su_oss_chamado.data_fechamento', 'OP' => '<=', 'P' => $data_fim),
        array('TB' => 'su_oss_chamado.tipo', 'OP' => '=', 'P' => 'C')
    ))
);

$api->get('su_oss_chamado', $params);
$retorno = $api->getRespostaConteudo(false);
$os_fin = json_decode($retorno);

$id_cliente = [];
$abertura_os = [];
$id_assunto = [];
$desc_os = [];
$fechamento_os = [];
$id_os_ixc = [];
$nomes_clientes = [];
$erro_mensagem = ''; // Variável para armazenar mensagem de erro

if (isset($os_fin->registros) && !empty($os_fin->registros)) {
    $i = 0;

    while ($i < $os_fin->total) {
        $id_cliente[] = $os_fin->registros[$i]->id_cliente;   
        $abertura_os[] = $os_fin->registros[$i]->data_abertura;
        $id_assunto[] = $os_fin->registros[$i]->id_assunto;
        $desc_os[] = $os_fin->registros[$i]->mensagem_resposta;
        $fechamento_os[] = $os_fin->registros[$i]->data_fechamento;
        $id_os_ixc[] = $os_fin->registros[$i]->id;
        $i++;
    }

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
} else {
    $erro_mensagem = "Não foram encontrados registros.";
}

// Função para zipar arrays
function zip($array1, $array2, $array3, $array4, $array5, $array6, $array7, ) {
    $zipped = [];
    $length = min(count($array1), count($array2), count($array3), count($array4), count($array5), count($array6), count($array7));
    for ($i = 0; $i < $length; $i++) {
        $zipped[] = [$array1[$i], $array2[$i], $array3[$i], $array4[$i], $array5[$i], $array6[$i], $array7[$i]];
    }
    return $zipped;
}

?>
