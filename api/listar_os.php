<?php
require_once "api.php";

// Verificar se a data foi fornecida no formulário, senão usar a data atual
if (isset($_GET['data']) && !empty($_GET['data'])) {
    $data_time = $_GET['data'];
} else {
    $data_time = date("Y-m-d");
}

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
    'rp' => '300',
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
    $i_2 = 0;

    while ($i_2 < $os_fin->total) {
        if ($os_fin->registros[$i_2]->id_assunto != 2) {
            $id_cliente[] = $os_fin->registros[$i_2]->id_cliente;   
            $abertura_os[] = $os_fin->registros[$i_2]->data_abertura;
            $id_assunto[] = $os_fin->registros[$i_2]->id_assunto;
            $desc_os[] = $os_fin->registros[$i_2]->mensagem_resposta;
            $fechamento_os[] = $os_fin->registros[$i_2]->data_fechamento;
            $id_os_ixc[] = $os_fin->registros[$i_2]->id;

            $params = array(
                'qtype' => 'cliente.id',
                'query' => $os_fin->registros[$i_2]->id_cliente,
                'oper' => '=',
                'page' => '1',
                'rp' => '300',
                'sortname' => 'cliente.id',
                'sortorder' => 'desc'
            );
    
            $api->get('cliente', $params);
            $retorno_cliente = $api->getRespostaConteudo(false);
            $cliente = json_decode($retorno_cliente);
    
            $nomes_clientes[] = $cliente->registros[0]->razao;
        }
        $i_2++;
    }
} else {
    $erro_mensagem = "Não foram encontrados registros.";
}

// Função para zipar arrays
function zip($array1, $array2, $array3, $array4, $array5, $array6, $array7) {
    $zipped = [];
    $length = min(count($array1), count($array2), count($array3), count($array4), count($array5), count($array6), count($array7));
    for ($i = 0; $i < $length; $i++) {
        $zipped[] = [$array1[$i], $array2[$i], $array3[$i], $array4[$i], $array5[$i], $array6[$i], $array7[$i]];
    }
    return $zipped;
}
?>
