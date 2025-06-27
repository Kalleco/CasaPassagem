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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> 
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

      <main id="content">
        <div class="container pt-3">
        <h1>Lista de moradores</h1>
        <form method="get" action="fazcheckin.php">
          <div class = "input-group">
          <input type="text" class="form-control" placeholder="Pesquise pelo nome" name="nome" value=<?php echo htmlspecialchars($pesquisa);?>>
          <button class="btn btn-primary" type="submit">Buscar</button>
          </div>
        </form><br>
        <?php if (count($moradores) > 0): ?>
        <table class="table table-bordered table-sm table-responsive">
            <tr>
                <th>Nome:</th>
                <th>Data Nasc:</th>
                <th>RG:</th>
                <th>CPF:</th>
                <th>Cidade Origem:</th>
                <th>Beneficio:</th>
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
                <td>
                    <form method="get" action = "/Formularios/checkin.php" onsubmit="return confirm('Deseja confirmar o check-in?')">
                    <input type="hidden" name="id" value="<?php echo $m['id']?>">
                    <button class="btn-sm btn-success" type = "submit">Check-in</button>
                    </form>
                    <form method="get" action = "/Formularios/editar.php" onsubmit="return confirm('Deseja editar o cadastro?')">
                    <input type="hidden" name="id" value="<?php echo $m['id']?>">
                    <button class="btn-sm btn-primary" type = "submit">Editar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
            <p>Nenhum morador encontrado.</p>
        <?php endif; ?>
          </div>
          </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">      
        </script>

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