<?php
  require 'Formularios/processo.php';

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

  if($_SERVER['REQUEST_METHOD'] === 'POST' && ISSET($_POST['total_vagas'])){
  $valoreditado = intval($_POST['total_vagas']);
  $stmteditar = $db->prepare("SELECT total_vagas FROM vagas WHERE id = ?");
  $stmteditar->execute([$valoreditado]);
  }

  $stmt = $db->query("SELECT total_vagas FROM vagas WHERE id = 1");
  $total_vagas = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casa de passagem</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> 
</head>
    <body>
  <!--  <header class="p-3 mb-4 border-down bg-white text-dark">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
        </a>
      </div>
    </header>  -->
     <main>
      <div class="container-fluid">
    <nav class="col-md d-none d-md-block bg-light sidebar vh-100 position-fixed border-end">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column text-center">
          <li class="mb-3">
            <img src="https://www.aparecida.sp.gov.br/img/logo_rodape.png" class="img-fluid px-3" alt="Logo">
          </li>
        <li class="nav-item"><a href="index.html" class="nav-link px-2 mb-2 text-secondary">Home</a></li>
          <li class="nav-item"><a href="lista.php" class="nav-link px-2 mb-2">Check-In</a></li>
          <li class="nav-item"><a href="checarlista.php" class="nav-link px-2 mb-2">Histórico</a></li>
          <li class="nav-item"><a href="fazcheckin.php" class="nav-link px-5 mb-5">Lista de moradores</a></li>
          <li class="nav-item"><a href="cadmorador.html" class="btn btn-outline-success mb-5">Cadastro</a></li>
        </ul>
      </div>
      </nav>
      <div>
        <div class="container text-center pt-3">
          <h1>Casa de passagem de Aparecida</h1>

          <h2>Bem-Vindo(a) ao sistema da casa de passagem!</h2>
          <br>
      <div class = "row justify-content-center ">
        <div class = "col-md-3 mb-3">
          <div class = "card" id = "vagasrestantes">
          <div class = "card-body">
            <h5 class = "card-title">Vagas restantes:</h5>
            <h3 class = "card-text"><?php echo $total_vagas; ?></h3>
            
            
        </div>
        </div>
        </div>

        <div class = "col-md-3 mb-3">
          <div class = "card" id = "cardcheckin">
          <div class = "card-body">
            <h5 class = "card-title">Check in no momento:</h5>
            <h3 class = "card-text"><?php echo $checkinativo; ?></h3>
        </div>
        </div>
        </div>

        <div class = "col-md-3 mb-3">
        <div class = "card" id = "cardcheckout">
          <div class = "card-body">
            <h5 class = "card-title">Check out feitos:</h5>
            <h3 class = "card-text"><?php echo $checkoutativo; ?></h3>
        </div>
          </div>
        </div>

          <div class = "col-md-3 mb-3">
        <div class = "card" id = "cardcadastros">
          <div class = "card-body">
            <h5 class = "card-title">Usuarios cadastrados:</h5>
            <h3 class = "card-text"><?php echo $contagem; ?></h3>
        </div>
          </div>
        </div>
        </div>
        </div>    
      </div>
      </main>




   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">      
    </script>

    </body>
</html>