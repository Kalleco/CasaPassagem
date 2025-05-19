<?php
require 'Formularios/processo.php';

$sql = "SELECT h.id AS hospedagens, m.id AS morador_id, m.nome, m.data_nasc, m.rg, m.cpf, m.cidade_origem, m.beneficio,  h.data_checkin
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
          <li><a href="lista.php" class="nav-link px-2">Lista Check-In</a></li>
          <li><a href="checarlista.php" class="nav-link px-2">Lista Check-Out</a></li>
        </ul>

        <div class="text-end">
          <a href="cadmorador.html" class="btn btn-outline-success">Cadastro</a>
        </div>
      </div>
    </header>
        <div class="container">
        <h1>Lista Check-in</h1>
        <?php if (count($moradores) > 0): ?>
        <table class="table table-bordered table-sm table-responsive">
            <tr>
                <th>Nome:</th>
                <th>Data Nasc:</th>
                <th>RG:</th>
                <th>CPF:</th>
                <th>Cidade Origem:</th>
                <th>Beneficio:</th>
                <th>Check-IN:</th>
                <th>AÇÃO:</th>
            </tr>
            <?php foreach ($moradores as $m): ?>
                <tr>
                <td><?php echo ($m['nome'])?></td>
                <td><?php echo ($m['data_nasc'])?></td>
                <td><?php echo ($m['rg'])?></td>
                <td><?php echo ($m['cpf'])?></td>
                <td><?php echo ($m['cidade_origem'])?></td>
                <td><?php echo ($m['beneficio'])?></td>
                <td><?php echo ($m['data_checkin'])?></td>
                <td>
                <form method="get" action = "Formularios/checkout.php" onsubmit="return confirm('Deseja confirmar o check-out?')">
                    <input type="hidden" name="id" value="<?php echo $m['morador_id']?>">
                    <button class="btn btn-success" type = "submit">Check-out</button>
                </form>
                <form method="post" action = "Formularios/delete.php" onsubmit="return confirm('Confirma a exclusão do registro?')">
                    <input type="hidden" name="id" value="<?php echo $m['morador_id']?>">
                    <button class="btn btn-danger" type = "submit">Apagar</button>
                </form>
                <form method="get" action = "Formularios/editar.php" onsubmit="return confirm('Deseja editar alguma informação?')">
                    <input type="hidden" name="id" value="<?php echo $m['morador_id']?>">
                    <button class="btn btn-info" type = "submit">Editar</button>
                </form>
                </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <button type ="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Voltar</button>
        <button type ="button" class="btn btn-secondary" onclick="window.location.href='checarlista.php'">Lista Check-out</button><br>
        </div>
        <?php endif; ?>

         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">      
        </script>
    </body>
    </html>