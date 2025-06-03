<?php
    require 'processo.php';
    $id = $_GET['id'] ?? null;

    if(!$id){
        echo "ID não encontrado.";
        exit;
    }

    $stmt = $db->prepare('SELECT * FROM moradores WHERE id = ?');
    $stmt->execute([$id]);
    $morador = $stmt->fetch();

    if(!$morador){
        echo 'Morador não encontrado.';
        exit;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Editar Cadastro</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> 
    </head>
    <body>
   <!--  <header class="p-3 mb-4 border-down bg-white text-white">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="../index.html" class="nav-link px-2 text-secondary">Home</a></li>
          <li><a href="lista.php" class="nav-link px-2">Lista Check-In</a></li>
          <li><a href="checarlista.php" class="nav-link px-2">Lista Check-Out</a></li>
        </ul>

        <div class="text-end">
          <a href="../cadmorador.html" class="btn btn-outline-success md-2">Cadastro</a>
        </div>
      </div>
    </header> -->
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
        <div class ="container pt-3">
        <h1>Editar Cadastro</h1>
        <?php if ($morador): ?>
            <form method = "post" action = "atualizar.php">
                <input type="hidden" name="id" value="<?php echo $morador['id'] ?>">

                <label for="nome">Nome:</label>
                <input type="text" class="form-control" name="nome" value="<?php echo $morador['nome'] ?>" required><br>

                <label for="data_nasc">Data Nasc:</label>
                <input type="date" class="form-control" name="data_nasc" value="<?php echo $morador['data_nasc'] ?>"><br>

                <label for="rg">RG:</label>
                <input type="text" class="form-control" name="rg" value="<?php echo $morador['rg'] ?>"><br>

                <label for="cpf">CPF:</label>
                <input type="text" class="form-control" name="cpf" value="<?php echo $morador['cpf'] ?>"><br>

                <label for="cidade_origem">Cidade Origem:</label>
                <input type="text" class="form-control" name="cidade_origem" value="<?php echo $morador['cidade_origem'] ?>"><br>

                <label for="beneficio">Beneficio:</label>
                <input type="text" class="form-control" name="beneficio" value="<?php echo $morador['beneficio'] ?>" required><br>


                <input type="submit" class="btn btn-success" value="Editar Cadastro">
            </form>
        <?php else: ?>
            <p>Morador não encontrado.</p>
        <?php endif; ?>
        </div>
        </div>
        </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">      
        </script>


        </body>