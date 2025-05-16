<?php
require 'Formularios/processo.php';

$sql = "SELECT h.id AS hospedagens, h.banho, h.jantou, h.passagem, h.destino, h.atendente,
m.id AS morador_id, m.nome, m.data_nasc, m.rg, m.cpf, m.cidade_origem, m.beneficio, h.data_checkin, h.data_checkout
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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> 
    </head>
    <body>
        <div class="container">
        <h1>Histórico de check-in e check-out</h1>
        <?php if (count($moradores) > 0): ?>
            
        <table class="table table-bordered table-sm table-responsive">
            <tr>
                <th>Nome:</th>
                <th>Data Nasc:</th>
                <th>Cidade Origem:</th>
                <th>Beneficio:</th>
                <th>Check-in:</th>
                <th>Check-out:</th>
                <th>Banho:</th>
                <th>Jantou:</th>
                <th>Passagem:</th>
                <th>Destino:</th>
                <th>Atendente:</th>
                <th>AÇÃO:</th>
            </tr>
            <?php foreach ($moradores as $m): ?>
                <tr>
                <td><?php echo ($m['nome'])?></td>
                <td><?php echo ($m['data_nasc'])?></td>
                <td><?php echo ($m['cidade_origem'])?></td>
                <td><?php echo ($m['beneficio'])?></td>
                <td><?php echo ($m['data_checkin'])?></td>
                <td><?php echo ($m['data_checkout'])?></td>
                <td><?php echo ($m['banho'])?></td>
                <td><?php echo ($m['jantou'])?></td>
                <td><?php echo ($m['passagem'])?></td>
                <td><?php echo ($m['destino'])?></td>
                <td><?php echo ($m['atendente'])?></td>
                <td>
                <form method="post" action = delete.php onsubmit="return confirm('Confirma a exclusão do registro?')">
                    <input type="hidden" name="id" value="<?php echo $m['morador_id']?>">
                    <button class="btn btn-danger" type = "submit">Apagar</button>
                </form>
                </td>
                </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <button type ="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Voltar</button><br>
        </div>
        <?php endif; ?>
        

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">      
        </script>
    </body>
    </html>