<?php
require 'Formularios/processo.php';

$sql = "SELECT h.id AS hospedagens, m.id AS morador_id, m.nome, m.idade, m.data_nasc, m.rg, m.cpf, m.cidade_origem, h.data_checkin
FROM moradores m
JOIN hospedagens h on m.id = h.morador_id
WHERE h.data_checkout IS NULL
ORDER BY h.data_checkin ASC";

$stmt = $db->prepare($sql);
$stmt->execute();
$moradores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lista de Check-ins</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1>Lista Check-in</h1>
        <?php if (count($moradores) > 0): ?>
        <table border = "2" cellpadding = "10">
            <tr>
                <th>Nome:</th>
                <th>Idade:</th>
                <th>Data Nasc:</th>
                <th>RG:</th>
                <th>CPF:</th>
                <th>Cidade Origem:</th>
                <th>Check-IN:</th>
                <th>AÇÃO:</th>
            </tr>
            <?php foreach ($moradores as $m): ?>
                <tr>
                <td><?php echo ($m['nome'])?></td>
                <td><?php echo ($m['idade'])?></td>
                <td><?php echo ($m['data_nasc'])?></td>
                <td><?php echo ($m['rg'])?></td>
                <td><?php echo ($m['cpf'])?></td>
                <td><?php echo ($m['cidade_origem'])?></td>
                <td><?php echo ($m['data_checkin'])?></td>
                <td>
                <form method="get" action = "Formularios/checkout.php" onsubmit="return confirm('Deseja confirmar o check-out?')">
                    <input type="hidden" name="id" value="<?php echo $m['morador_id']?>">
                    <button type = "submit">Check-out</button>
                </form><br>
                <form method="post" action = "Formularios/delete.php" onsubmit="return confirm('Confirma a exclusão do registro?')">
                    <input type="hidden" name="id" value="<?php echo $m['morador_id']?>">
                    <button type = "submit">Apagar</button>
                </form><br>
                <form method="get" action = "Formularios/editar.php" onsubmit="return confirm('Deseja editar alguma informação?')">
                    <input type="hidden" name="id" value="<?php echo $m['morador_id']?>">
                    <button type = "submit">Editar</button>
                </form>
                </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
        <a href="index.html">Voltar</a><br>
         <a href="checarlista.php">Lista de check-out</a>
    </body>
    </html>