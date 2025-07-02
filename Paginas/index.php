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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/home.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> 
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

      <button class = "btn btn-default" onclick="redirecionar()">
          Cadastro
      </button>
     </nav> 
  </header>

     <main id = content>
      <div class="container-fluid">
    
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