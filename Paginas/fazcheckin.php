<?php
require '../Formularios/processo.php';
// Verifica se o morador já existe no banco 

$pesquisa = $_GET['nome'] ?? '';

if($pesquisa){
  $stmt = $db->prepare("SELECT * FROM moradores WHERE nome LIKE ?");
  $stmt->execute(["%$pesquisa%"]);
}
else{
$stmt = $db->prepare("SELECT * from moradores"); // Preparando a consulta SQl segura
$stmt->execute();
}

$moradores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casa de passagem</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  </head>
    <body>
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
            <li class="nav-item">
          <i class="fa-solid fa-book-open"></i>
          <a href="/Paginas/lista.php">Check-in</a>
          </li>
          <li class="nav-item active">
            <i class="fa-solid fa-list"></i>
          <a href="/Paginas/fazcheckin.php">Lista de moradores</a>
          </li>
          
      </ul>

      <a href ='cadmorador.html' class = 'btn btn-default'>
          Cadastro
      </a>
     </nav> 
  </header>

 <main id="form-container">
    <div class="form-header">
        <h1 class="title"> 
          Histórico de
          <span>hospedagens</span>
        </h1>
        <form method="get" action="">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Pesquise pelo nome" name="nome" value="<?php echo htmlspecialchars($pesquisa); ?>">
                <button class="btn btn-primary" type="submit">Buscar</button>
            </div>
        </form>
    </div>

        <?php if (count($moradores) > 0): ?>
            <div class="table-responsive mt-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Data Nasc.</th>
                            <th>RG</th>
                            <th>CPF</th>
                            <th>Cidade Origem</th>
                            <th>Benefício</th>
                            <th class="text-center">Ação</th>
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
                                <td>
                                    <div class="action-buttons">
                                        <form method="get" action="/Formularios/checkin.php" onsubmit="return confirm('Deseja confirmar o check-in?')">
                                            <input type="hidden" name="id" value="<?php echo $m['id']; ?>">
                                            <button class="btn btn-sm btn-success" type="submit">Check-in</button>
                                        </form>
                                        <form method="get" action="/Formularios/editar.php" onsubmit="return confirm('Deseja editar o cadastro?')">
                                            <input type="hidden" name="id" value="<?php echo $m['id']; ?>">
                                            <button class="btn btn-sm btn-primary" type="submit">Editar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="mt-4">Nenhum morador encontrado.</p>
        <?php endif; ?>
    </div>
</main>

          <?php if (isset($_GET['atualizado']) && $_GET['atualizado'] == 1): ?>
        <script>
            alert("Cadastro atualizado!");

        if (window.history.replaceState) {
        const url = new URL(window.location);
        url.searchParams.delete('atualizado');
        window.history.replaceState(null, '', url);
        }
        </script>
        <?php endif; ?>

        </body>
        </html>