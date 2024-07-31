<?php
// Verifica se o ID do usuário foi recebido via POST
if (isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];

    // Conexão com o banco de dados (substitua pelas suas credenciais)
    require_once "../../../autentication/index.php";
    require_once "../../../core/core.php";

    // Query para deletar o usuário
    $query = $pdo->prepare("DELETE FROM colaborador WHERE id_colaborador = :id");
    $query->bindParam(':id', $userId, PDO::PARAM_INT);

    if ($query->execute()) {
        echo "Colaborador deletado com sucesso!";
    } else {
        echo "Erro ao deletar o colaborador..";
    }
}
?>
