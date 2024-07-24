<?php
include '../../autentication/index.php';

$current_id = $_SESSION['user_setor'];

$setor = array(
    '5' => 'n3',
    '6' => 'estoque',
    '7' => 'rh',
    '8' => 'sucesso',
    '9' => 'n2',
    '20' => 'atendimento',
);

// Variável para armazenar o nome da pasta para redirecionamento
$redirect_folder = '';

// Percorre o array $setor para verificar se $current_id corresponde a alguma chave
foreach ($setor as $id => $folder) {
    if ($current_id == $id) {
        // Se encontrou correspondência, define o nome da pasta para redirecionamento
        $redirect_folder = $folder;
        break; // Encerra o loop, pois já encontrou correspondência
    }
}

// Se $redirect_folder foi definido, redireciona para a pasta correspondente
if (!empty($redirect_folder)) {
    header("Location: $redirect_folder/");
    exit();
} else {
    // Caso não encontre correspondência, faça algo aqui, se necessário
    echo "Setor não encontrado ou redirecionamento não configurado.";
}
?>
