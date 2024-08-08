<?php

require_once '../../../core/core.php';

$month = date("m");
$year = date("Y");

$sql = $pdo->prepare('SELECT COUNT(*) FROM avaliacao_rh WHERE MONTH(data_avaliacao) = ? AND YEAR(data_avaliacao) = ?');
$sql->execute([$month, $year]);

if ($sql->fetchColumn() == 0) {

    $sql = $pdo->prepare('SELECT * FROM colaborador');
    $sql->execute();
    $colaborador_bd = $sql->fetchAll();

    foreach ($colaborador_bd as $bd_colaborador) {
        $pnt_ponto = 60;
        $pnt_atestado = 60;
        $pnt_falta = 60;
        $data_avaliacao = date("Y-m-d");
        $id_tecnico = $bd_colaborador['id_colaborador'];
        $id_setor_avaliacao = 7;

        $sql = $pdo->prepare('SELECT COUNT(*) FROM avaliacao_rh WHERE id_tecnico = ? AND data_avaliacao = ?');
        $sql->execute([$id_tecnico, $data_avaliacao]);
        
        if($sql->fetchColumn() < 1){
            $sql = $pdo->prepare('INSERT INTO avaliacao_rh (pnt_ponto, pnt_atestado, pnt_falta, id_tecnico, id_setor, data_avaliacao) 
                                  VALUES (?, ?, ?, ?, ?, ?)');
            $sql->execute([$pnt_ponto, $pnt_atestado, $pnt_falta, $id_tecnico, $id_setor_avaliacao, $data_avaliacao]);
        }
    }
}

?>
