<?php
require '../Formularios/processo.php';

$pesquisa = $_GET['nome'] ?? '';

if ($pesquisa) {
  $sql = "SELECT h.id AS hospedagens, m.id AS morador_id, m.nome, m.data_nasc, m.rg, m.cpf, m.cidade_origem, m.beneficio, h.data_checkin
          FROM moradores m
          JOIN hospedagens h ON m.id = h.morador_id
          WHERE h.data_checkout IS NULL AND m.nome LIKE ?
          ORDER BY h.data_checkin ASC";
  $stmt = $db->prepare($sql);
  $stmt->execute(["%$pesquisa%"]);
} else {
  $sql = "SELECT h.id AS hospedagens, m.id AS morador_id, m.nome, m.data_nasc, m.rg, m.cpf, m.cidade_origem, m.beneficio, h.data_checkin
          FROM moradores m
          JOIN hospedagens h ON m.id = h.morador_id
          WHERE h.data_checkout IS NULL
          ORDER BY h.data_checkin ASC";
  $stmt = $db->prepare($sql);
  $stmt->execute();
}

$moradores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Casa de passagem - Lista Check-in</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
        <link rel="stylesheet" href="/css/style.css">
        <link rel="stylesheet" href="/css/navbar.css">
        <link rel="stylesheet" href="/css/home.css"> 
      </head>
    <body>
  <header>
<nav id="navbar">
  <img src="https://www.aparecida.sp.gov.br/img/logo_rodape.png" class="img-fluid " alt="Logo">   
   <ul id="nav_list">
        <li class="nav-item">
            <i class="fa-solid fa-house"></i>
          <a href="/Paginas/index.php">Dashboard</a>
          </li>
            <li class="nav-item">
          <i class="fa-solid fa-house"></i>
          <a href="/Paginas/checarlista.php">Histórico</a>
          </li>
            <li class="nav-item active">
          <i class="fa-solid fa-book-open"></i>
          <a href="/Paginas/lista.php">Check-in</a>
          </li>
          <li class="nav-item">
            <i class="fa-solid fa-list"></i>
          <a href="/Paginas/fazcheckin.php">Lista de moradores</a>
          </li>
          
      </ul>

      <a href = "cadmorador.html" class = "btn btn-default">
          Cadastro
      </a>
     </nav> 
  </header>
  
<main id="form-container">
    <div class="form-header">
        <h1 class="title">Lista 
          <span>Check-in</span>
        </h1>
        <form method="get" action="">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Pesquise pelo nome" name="nome" value="<?php echo htmlspecialchars($pesquisa); ?>">
                <button class="btn btn-primary" type="submit">Buscar</button>
            </div>
        </form>
    </div>

    <?php if (count($moradores) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Data Nasc.</th>
                        <th>RG</th>
                        <th>CPF</th>
                        <th>Cidade Origem</th>
                        <th>Benefício</th>
                        <th>Check-in</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($moradores as $m): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($m['nome']); ?></td>
                            <td><?php echo htmlspecialchars($m['data_nasc']); ?></td>
                            <td><?php echo htmlspecialchars($m['rg']); ?></td>
                            <td><?php echo htmlspecialchars($m['cpf']); ?></td>
                            <td><?php echo htmlspecialchars($m['cidade_origem']); ?></td>
                            <td><?php echo htmlspecialchars($m['beneficio']); ?></td>
                            <td><?php echo htmlspecialchars($m['data_checkin']); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <form method="get" action="../Formularios/checkout.php" onsubmit="return confirm('Deseja confirmar o check-out?')">
                                        <input type="hidden" name="id" value="<?php echo $m['hospedagens']; ?>">
                                        <button class="btn btn-sm btn-success" type="submit">Check-out</button>
                                    </form>
                                    <form method="post" action="../Formularios/delete.php" onsubmit="return confirm('Confirma a exclusão do registro?')">
                                        <input type="hidden" name="id" value="<?php echo $m['hospedagens']; ?>">
                                        <button class="btn btn-sm btn-danger" type="submit">Apagar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-center">Não foi efetuado nenhum check-in.</p>
    <?php endif; ?>
</main>

         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">      
        </script>

        <?php if (isset($_GET['cancelado']) && $_GET['cancelado'] == 1): ?>
        <script>
            alert("Checkin cancelado!");

        if (window.history.replaceState) {
        const url = new URL(window.location);
        url.searchParams.delete('cancelado');
        window.history.replaceState(null, '', url);
        }

        </script>
        <?php endif; ?>

    </body>
    </html>