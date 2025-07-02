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
        <title>Casa de passagem - Editar cadastro</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/navbar.css">
        <link rel="stylesheet" href="../css/home.css">
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
            <li class="nav-item">
          <i class="fa-solid fa-book-open"></i>
          <a href="/Paginas/lista.php">Check-in</a>
          </li>
          <li class="nav-item">
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
        <h1 id="title">
          Editar
          <span>Cadastro</span>
        </h1>
    </div>
    
        <?php if ($morador): ?>
            <form method = "post" action = "atualizar.php">
              <div id="input-container">
                <input type="hidden" name="id" value="<?php echo $morador['id'] ?>">

                <div class = "input-box">
                <label class="form-label" for="nome">Nome:</label>
                <input type="text" class="form-control" name="nome" value="<?php echo $morador['nome'] ?>" required><br>
                </div>

                <div class="form-row">
                <div class="input-box">
                <label class="form-label" for="datanasc">Data de nascimento</label>
                <input type="date" class="form-control" name="data_nasc" value="<?php echo $morador['data_nasc'] ?>"><br>
                </div>

                <div class = "input-box">
                <label class="form-label" for="cidade_origem">Cidade de origem:</label>
                <input type="text" class="form-control" name="cidade_origem" value="<?php echo $morador['cidade_origem'] ?>"><br>
                </div>
                </div>

                <div class="form-row">
                <div class = "input-box">
                <label class="form-label" for="rg">RG:</label>
                <input type="text" class="form-control" name="rg" value="<?php echo $morador['rg'] ?>"><br>
                </div>

                <div class = "input-box">
                <label class="form-label" for="cpf">CPF:</label>
                <input type="text" class="form-control" name="cpf" value="<?php echo $morador['cpf'] ?>"><br>
                </div>
                </div>
              
                <div class = "input-box">
                <label class="form-label" for="beneficio">Beneficio:</span>
                <input type="text" class="form-control" name="beneficio" value="<?php echo $morador['beneficio'] ?>" required><br>
                </div>

                <input type="submit" class="btn btn-success" value="Editar Cadastro">
            </form>
        <?php else: ?>
            <p>Morador não encontrado.</p>
        <?php endif; ?>
        </div>
        </div>
        </div>
        </div>
        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">      
        </script>


        </body>