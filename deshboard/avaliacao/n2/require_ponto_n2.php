<?php

require_once '../../../core/core.php';


$sql = $pdo->prepare('SELECT COUNT(*) FROM avaliacao_n2 WHERE data_finalizacao = ?');
$sql->execute([date('Y-m-d')]);

if ($sql->fetchColumn() == 0) {

    $sql = $pdo->prepare('SELECT * FROM colaborador');
    $sql->execute();
    $colaborador_bd = $sql->fetchAll();


    foreach ($colaborador_bd as $bd_colaborador) {
        $ponto_finalizacao_os = 10;
        $organizacao_material = 10;
        $ponto_fardamento = 10;
        $data_finalizacao = date("Y-m-d");
        $id_tecnico_n2 = $bd_colaborador['id_colaborador'];
        $id_setor_avaliacao = 9;

        $sql = $pdo->prepare('SELECT COUNT(*) FROM avaliacao_n2 WHERE id_tecnico_n2 = ? AND data_finalizacao = ?');
        $sql->execute([$id_tecnico_n2, $data_finalizacao]);
        
        if($sql->fetchColumn() < 1){
            $sql = $pdo->prepare('INSERT INTO avaliacao_n2 (ponto_finalizacao_os, organizacao_material, data_finalizacao, id_tecnico_n2, id_setor, ponto_fardamento) 
            VALUES (?, ?, ?, ?, ?, ?)');
            $sql->execute([$ponto_finalizacao_os, $organizacao_material, $data_finalizacao, $id_tecnico_n2, $id_setor_avaliacao, $ponto_fardamento]);
        }
    }


}






