<?php
require 'Formularios/processo.php';

$sql = "SELECT h.id AS hospedagens, h.banho, h.jantou, h.passagem, h.destino, h.atendente,
m.id AS morador_id, m.nome, m.data_nasc, m.rg, m.cpf, m.cidade_origem, m.beneficio, h.data_checkin, h.data_checkout
FROM moradores m
JOIN hospedagens h on m.id = h.morador_id
WHERE h.data_checkout IS NOT NULL";

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
    <header class="p-3 mb-4 border-down bg-white text-white">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="index.html" class="nav-link px-2 text-secondary">Home</a></li>
          <li><a href="lista.php" class="nav-link px-2">Check-In</a></li>
          <li><a href="checarlista.php" class="nav-link px-2">Histórico</a></li>
          <li><a href="fazcheckin.php" class="nav-link px-2">Lista de moradores</a></li>
        </ul>

        <div class="text-end">
          <a href="cadmorador.html" class="btn btn-outline-success">Cadastro</a>
        </div>
      </div>
    </header>


        <div class="container">
        <P>
            Check-in > Histórico
        </P>
        <h1>Histórico</h1>
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
                </tr>
            <?php endforeach; ?>
        </table>
    
        </div>
        <?php endif; ?>
        

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">      
        </script>
    </body>
    </html>