<?php
require 'processo.php';

$sql = "SELECT h.id AS hospedagens, h.jantou, h.passagem, h.destino, 
m.id AS morador_id, m.nome, m.idade, m.data_nasc, m.rg, m.cpf, m.cidade_origem, h.data_checkin, h.data_checkout
FROM moradores m
JOIN hospedagens h on m.id = h.morador_id
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
        <title>Histórico</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1>Histórico de check-in e check-out</h1>
        <?php if (count($moradores) > 0): ?>
        <table border = "2" cellpadding = "10">
            <tr>
                <th>Nome:</th>
                <th>Data Nasc:</th>
                <th>Cidade Origem:</th>
                <th>Check-in:</th>
                <th>Check-out:</th>
                <th>Jantou:</th>
                <th>Passagem:</th>
                <th>Destino:</th>
            </tr>
            <?php foreach ($moradores as $m): ?>
                <tr>
                <td><?php echo ($m['nome'])?></td>
                <td><?php echo ($m['data_nasc'])?></td>
                <td><?php echo ($m['cidade_origem'])?></td>
                <td><?php echo ($m['data_checkin'])?></td>
                <td><?php echo($m['data_checkout'])?></td>
                <td><?php echo($m['jantou'])?></td>
                <td><?php echo($m['passagem'])?></td>
                <td><?php echo($m['destino'])?></td>
                </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
        <a href="index.html">voltar</a>
    </body>
    </html>