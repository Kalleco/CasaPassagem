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
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <header class="p-3 mb-4 border-down bg-white text-white">
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
    </header>
        <h1>Editar Cadastro</h1>
        <?php if ($morador): ?>
            <form method = "post" action = "atualizar.php">
                <input type="hidden" name="id" value="<?php echo $morador['id'] ?>">

                <label for="nome">Nome:</label>
                <input type="text" name="nome" value="<?php echo $morador['nome'] ?>" required><br>

                <label for="data_nasc">Data Nasc:</label>
                <input type="date" name="data_nasc" value="<?php echo $morador['data_nasc'] ?>"><br>

                <label for="rg">RG:</label>
                <input type="text" name="rg" value="<?php echo $morador['rg'] ?>"><br>

                <label for="cpf">CPF:</label>
                <input type="text" name="cpf" value="<?php echo $morador['cpf'] ?>"><br>

                <label for="cidade_origem">Cidade Origem:</label>
                <input type="text" name="cidade_origem" value="<?php echo $morador['cidade_origem'] ?>"><br>

                <label for="beneficio">Beneficio:</label>
                <input type="text" name="beneficio" value="<?php echo $morador['beneficio'] ?>" required><br>


                <input type="submit" value="Editar Cadastro">
            </form>
        <?php else: ?>
            <p>Morador não encontrado.</p>
        <?php endif; ?>