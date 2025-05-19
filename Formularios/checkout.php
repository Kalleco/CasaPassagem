<?php
require 'processo.php';
$morador_id = $_GET['id'] ?? null;

/*if($morador_id && isset($_POST['jantou']) && isset($_POST['passagem']) && isset($_POST['destino']))*/
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $morador_id &&
    isset($_POST['jantou'], $_POST['passagem'], $_POST['destino'], $_POST['banho'], $_POST['atendente'])) {
    // Verifica se o morador já existe no banco
    $stmt = $db->prepare(
        "UPDATE hospedagens 
        SET data_checkout = datetime('now'), jantou = ?, passagem = ?, destino = ?, banho = ?, atendente = ?
        WHERE morador_id = ? and data_checkout is NULL");

    $stmt->execute([
        $_POST['jantou'],
        $_POST['passagem'],
        $_POST['destino'],
        $_POST['banho'],
        $_POST['atendente'],
        $morador_id
    ]);
    echo "Check-out feito com sucesso! <a href='../index.php'>Voltar</a>";
} 
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Check-out</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> 
    </head>
    <body>
    <header class="p-3 mb-4 border-down bg-white text-white">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="index.html" class="nav-link px-2 text-secondary">Home</a></li>
          <li><a href="cadmorador.html" class="nav-link px-2">Cadastro morador</a></li>
          <li><a href="lista.php" class="nav-link px-2">Lista Check-In</a></li>
          <li><a href="checarlista.php" class="nav-link px-2">Lista Check-Out</a></li>
        </ul>

        <div class="text-end">
          <a href="cadmorador.html" class="btn btn-outline-success">Cadastro</a>
        </div>
    </div>
    </header>
        <div class="container">
        <h1>Check-out</h1>
        <?php if ($morador_id): ?>
            <form method = "post" action = "checkout.php?id=<?php echo $morador_id ?>" onsubmit="return confirm('Deseja fazer o check-out?')">
                <label for="jantou">Jantou:</label>
                <select class ="form-select" name="jantou" required>
                    <option value="">Selecione</option>
                    <option value="Sim">Sim</option>
                    <option value="Não">não</option>
                </select><br>

                <label for="banho">Tomou banho:</label>
                <select class ="form-select" name="banho" required>
                    <option value="">Selecione</option>
                    <option value="Sim">Sim</option>
                    <option value="Não">não</option>
                </select><br>

                <label for="passagem">Recebeu passagem?:</label>
                <select class ="form-select" name="passagem" required>
                    <option value="">Selecione</option>
                    <option value="Sim">Sim</option>
                    <option value="Não">não</option>
                </select><br>

                <label for="destino">Destino:</label>
                <input type="text" class="form-control" name="destino"><br>

                <label for="atendente">Atendente:</label>
                <input type="text" class="form-control" name="atendente"><br>

                <button class="btn btn-success" type="submit" value="Finalizar Check-out">Finalizar Check-out</button>
                <button type ="button" class="btn btn-secondary" onclick="window.location.href='../index.php'">Voltar</button><br>
            </form>
            </div>
        <?php else: ?>
            <p>Morador não encontrado.</p>
        <?php endif; ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">      
        </script>
    </body>