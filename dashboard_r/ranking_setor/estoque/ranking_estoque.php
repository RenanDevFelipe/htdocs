<?php 

require_once '../../../core/core.php';

// Obter o mês e ano atuais
$currentMonth = date('m');
$currentYear = date('Y');

// Selecionar os IDs e nomes dos colaboradores
$sql = $pdo->prepare('SELECT id_colaborador, nome_colaborador FROM colaborador');
$sql->execute();
$colaboradores = $sql->fetchAll();

// Array para armazenar as notas dos colaboradores
$notas_colaboradores = [];

foreach($colaboradores as $colaborador){
    // Consultar a soma das notas no estoque para o mês atual
    $sql = $pdo->prepare('
        SELECT SUM(pnt_total_estoque) as total_estoque 
        FROM avaliacao_estoque 
        WHERE id_tecnico_estoque = ? AND MONTH(data_finalizacao) = ? AND YEAR(data_finalizacao) = ?');
    $sql->execute([$colaborador['id_colaborador'], $currentMonth, $currentYear]);
    $nota = $sql->fetch(PDO::FETCH_ASSOC);

    // Armazenar o nome do colaborador e a nota
    if ($nota['total_estoque'] !== null) {
        $notas_colaboradores[] = [
            'nome_colaborador' => $colaborador['nome_colaborador'],
            'total_estoque' => $nota['total_estoque']
        ];
    }
}

// Classificar as notas em ordem decrescente
usort($notas_colaboradores, function($a, $b) {
    return $b['total_estoque'] - $a['total_estoque'];
});



// HTML para exibir os resultados
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classificação dos Colaboradores</title>
    <style>
        .ranking-container {
            text-align: center;
            font-family: Arial, sans-serif;
        }
        .top-3 {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
        }
        .card {
            position: relative;
            border: 2px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            width: 150px;
            text-align: center;
        }
        .first {
            border-color: gold;
            border-radius: 50%;
        }
        .second {
            border-color: silver;
        }
        .third {
            border-color: #cd7f32; /* Bronze */
        }
        .ranking-list {
            margin-top: 20px;
        }
        .ranking-list .item {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .medal {
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #fff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2em;
            font-weight: bold;
            color: #fff;
        }
        .medal.first {
            background-color: gold;
        }
        .medal.second {
            background-color: silver;
        }
        .medal.third {
            background-color: #cd7f32; /* Bronze */
        }
    </style>
</head>
<body>

<div class="ranking-container">
    <h2>Classificação dos Colaboradores</h2>
    
    <div class="top-3">
        <?php if (isset($notas_colaboradores[1])): ?>
            <div class="card second">
                <div class="medal second">2º</div>
                <div><?php echo $notas_colaboradores[1]['nome_colaborador']; ?></div>
                <div><?php echo number_format($notas_colaboradores[1]['total_estoque'], 2, ',', '.'); ?> Pontos</div>
            </div>
        <?php endif; ?>
        
        <?php if (isset($notas_colaboradores[0])): ?>
            <div class="card first">
                <div class="medal first">1º</div>
                <div><?php echo $notas_colaboradores[0]['nome_colaborador']; ?></div>
                <div><?php echo number_format($notas_colaboradores[0]['total_estoque'], 2, ',', '.'); ?> Pontos</div>
            </div>
        <?php endif; ?>
        
        <?php if (isset($notas_colaboradores[2])): ?>
            <div class="card third">
                <div class="medal third">3º</div>
                <div><?php echo $notas_colaboradores[2]['nome_colaborador']; ?></div>
                <div><?php echo number_format($notas_colaboradores[2]['total_estoque'], 2, ',', '.'); ?> Pontos</div>
            </div>
        <?php endif; ?>
    </div>

    <div class="ranking-list">
        <?php foreach ($notas_colaboradores as $index => $colaborador): ?>
            <div class="item">
                <div><?php echo $index + 1; ?>º <?php echo $colaborador['nome_colaborador']; ?></div>
                <div><?php echo number_format($colaborador['total_estoque'], 2, ',', '.'); ?> Pontos</div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
