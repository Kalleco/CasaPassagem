<?php
  require '../Formularios/processo.php';

  $stmtativo = $db->prepare("select count(*) from hospedagens where data_checkout is null");
  $stmtativo->execute();
  $checkinativo = $stmtativo->fetchColumn();

  $stmtinativo = $db->prepare("select count(*) from hospedagens");
  $stmtinativo->execute();
  $checkoutativo = $stmtinativo->fetchColumn();

  $stmtcontagem = $db->prepare("select count(*) from moradores");
  $stmtcontagem->execute();
  $contagem = $stmtcontagem->fetchColumn();

  $stmtvagas = $db->prepare("SELECT total_vagas FROM vagas");
  $stmtvagas->execute();
  $total_vagas = $stmtvagas->fetchColumn();
  $vagas_restantes = max(0, $total_vagas - $checkinativo);     

 if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['total_vagas'])) {
    $novo_total_vagas = intval($_POST['total_vagas']);
    
    $stmteditar = $db->prepare("UPDATE vagas SET total_vagas = ? WHERE id = 1");
    $stmteditar->execute([$novo_total_vagas]);
}

  $stmt = $db->query("SELECT total_vagas FROM vagas WHERE id = 1");
  $total_vagas = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <title>Casa de passagem</title>
  </head>
    <body>
 <nav id="navbar">
  <img src="https://www.aparecida.sp.gov.br/img/logo_rodape.png" class="img-fluid " alt="Logo">   
   <ul id="nav_list">
        <li class="nav-item active">
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

<main id="dashboard-container">
    <div class="dashboard-header">
        <h1 class="title">Dashboard do <span>Sistema</span></h1>
    </div>

    
    
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-vagas">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Vagas Restantes</h5>
                        <h3 class="card-text"><?php echo htmlspecialchars($vagas_restantes); ?></h3>
                    </div>
                    <i class="bi bi-door-open-fill card-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-checkin">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Check-in Ativos</h5>
                        <h3 class="card-text"><?php echo htmlspecialchars($checkinativo); ?></h3>
                    </div>
                    <i class="bi bi-person-check-fill card-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-checkout">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Check-outs Feitos</h5>
                        <h3 class="card-text"><?php echo htmlspecialchars($checkoutativo); ?></h3>
                    </div>
                    <i class="bi bi-person-dash-fill card-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-cadastros">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Usuários Cadastrados</h5>
                        <h3 class="card-text"><?php echo htmlspecialchars($contagem); ?></h3>
                    </div>
                    <i class="bi bi-people-fill card-icon"></i>
                </div>
            </div>
        </div>
    </div>

<h4>Editar Total de Vagas</h4>
<form method="POST" action="">
    <div class="input-group" style="max-width: 300px;">
        <input 
            type="number" 
            class="form-control" 
            name="total_vagas" 
            value="<?php echo htmlspecialchars($total_vagas); ?>" 
            required
        >
        <button class="btn btn-primary" type="submit">Salvar</button>
    </div>
</form>

</main>

    </body>
</html>