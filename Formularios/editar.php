<?php
    require 'processo.php';
    $id = $_GET['id'] ?? null;

    if(!$id){
        echo "Morador não encontrador.";
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
        <h1>Editar Cadastro</h1>
        <?php if ($morador_id): ?>
            <form method = "post" action = "atualizar.php">
                <input type="hidden" name="id" value="<?php echo $morador['id'] ?>">

                <label for="nome">Nome:</label>
                <input type="text" name="nome" value="<?php echo $morador['nome'] ?>" required><br>

                <label for="idade">Idade:</label>
                <input type="number" name="idade" value="<?php echo $morador['idade'] ?>" required><br>

                <label for="data_nasc">Data Nasc:</label>
                <input type="date" name="data_nasc" value="<?php echo $morador['data_nasc'] ?>"><br>

                <label for="rg">RG:</label>
                <input type="text" name="rg" value="<?php echo $morador['rg'] ?>"><br>

                <label for="cpf">CPF:</label>
                <input type="text" name="cpf" value="<?php echo $morador['cpf'] ?>"><br>

                <label for="cidade_origem">Cidade Origem:</label>
                <input type="text" name="cidade_origem" value="<?php echo $morador['cidade_origem'] ?>"><br>

                <input type="submit" value="Editar Cadastro">
            </form>
        <?php else: ?>
            <p>Morador não encontrado.</p>
        <?php endif; ?>