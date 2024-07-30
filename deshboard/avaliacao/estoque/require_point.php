<?php

require_once 'C:/xampp/htdocs/core/core.php';


$sql = $pdo->prepare('SELECT COUNT(*) FROM avaliacao_estoque WHERE data_finalizacao = ?');
$sql->execute([date('Y-m-d')]);

if ($sql->fetchColumn() == 0) {

    $sql = $pdo->prepare('SELECT * FROM colaborador');
    $sql->execute();
    $colaborador_bd = $sql->fetchAll();


    foreach ($colaborador_bd as $bd_colaborador) {
        $pnt_pedido = 2;
        $pnt_prazo = 1;
        $pnt_etiqueta = 1;
        $pnt_baixa_mat = 2;
        $pnt_troca_equip = 2;
        $pnt_transferencia = 2;
        $data_finalizacao = date("Y-m-d");
        $id_tecnico_estoque = $bd_colaborador['id_colaborador'];
        $id_setor_avaliacao = 6;

        $sql = $pdo->prepare('SELECT COUNT(*) FROM avaliacao_estoque WHERE id_tecnico_estoque = ? AND data_finalizacao = ?');
        $sql->execute([$id_tecnico_estoque, $data_finalizacao]);
        
        if($sql->fetchColumn() < 1){
            $sql = $pdo->prepare('INSERT INTO avaliacao_estoque (pnt_pedido, pnt_prazo, pnt_etiqueta, pnt_baixa_mat, pnt_troca_equip, pnt_transferencia, data_finalizacao, id_tecnico_estoque, id_setor_avaliacao) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $sql->execute([$pnt_pedido, $pnt_prazo, $pnt_etiqueta, $pnt_baixa_mat, $pnt_troca_equip, $pnt_transferencia, $data_finalizacao, $id_tecnico_estoque, $id_setor_avaliacao]);
        }
    }


}






