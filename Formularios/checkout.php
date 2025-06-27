<?php
require 'processo.php';

$hospedagem_id = $_GET['id'] ?? null;
$morador = null;


if ($hospedagem_id) {
    $stmt = $db->prepare("SELECT m.nome FROM moradores m
    JOIN hospedagens h on m.id = h.morador_id
    WHERE m.id = ?");
    $stmt->execute([$hospedagem_id]);
    $morador = $stmt->fetch(PDO::FETCH_ASSOC);
}

/*if($morador_id && isset($_POST['jantou']) && isset($_POST['passagem']) && isset($_POST['destino']))*/
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $hospedagem_id &&
    isset($_POST['jantou'], $_POST['passagem'], $_POST['destino'], $_POST['banho'], $_POST['atendente'])) {
    // Verifica se o morador já existe no banco
 try {
        $stmt = $db->prepare(
            "UPDATE hospedagens 
             SET data_checkout = datetime('now'), 
                 jantou = ?, 
                 passagem = ?, 
                 destino = ?, 
                 banho = ?, 
                 atendente = ?
             WHERE id = ? AND data_checkout IS NULL"
        );

        $stmt->execute([
            $_POST['jantou'],
            $_POST['passagem'],
            $_POST['destino'],
            $_POST['banho'],
            $_POST['atendente'],
            $hospedagem_id
        ]);

        header("Location: ../Paginas/checarlista.php?checkout=1");
        exit;

    } catch (PDOException $e) {
        $mensagem = "Erro ao realizar check-out: " . $e->getMessage();
    }
    exit;
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
   <!-- <header class="p-3 mb-4 border-down bg-white text-white">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="index.html" class="nav-link px-2 text-secondary">Home</a></li>
          <li><a href="lista.php" class="nav-link px-2">Lista Check-In</a></li>
          <li><a href="checarlista.php" class="nav-link px-2">Lista Check-Out</a></li>
          <li><a href="fazcheckin.php" class="nav-link px-2">Lista de moradores</a></li>
        </ul>

        <div class="text-end">
          <a href="cadmorador.html" class="btn btn-outline-success">Cadastro</a>
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
        <div class="container pt-3">
        <h1>Check-out</h1>
        <?php if ($hospedagem_id): ?>
            <form method = "post" action = "checkout.php?id=<?php echo $hospedagem_id ?>" onsubmit="return confirm('Deseja fazer o check-out?')">
            <div class = "input-group mb-3">
            <span class = "input-group-text" for="jantou">Jantou:</span>
                <select class ="form-select" name="jantou" required>
                    <option value="">Selecione</option>
                    <option value="Sim">Sim</option>
                    <option value="Não">Não</option>
                </select></div><br>

            <div class = "input-group mb-3">
            <span class = "input-group-text" for="banho">Tomou banho:</span>
                <select class ="form-select" name="banho" required>
                    <option value="">Selecione</option>
                    <option value="Sim">Sim</option>
                    <option value="Não">Não</option>
                </select></div><br>

            <div class = "input-group mb-3">
            <span class = "input-group-text" for="passagem">Recebeu passagem:</span>
                <select class ="form-select" name="passagem" required>
                    <option value="">Selecione</option>
                    <option value="Sim">Sim</option>
                    <option value="Não">Não</option>
                </select></div><br>

            <div class = "input-group mb-3">
            <span class = "input-group-text" for="destino">Destino:</span>
                <input type="text" class="form-control" name="destino"><br>
            </div><br>

            <div class = "input-group mb-3">
            <span class = "input-group-text" for="atendente">Atendente:</span>
                <input type="text" class="form-control" name="atendente"><br>
            </div>

                <button class="btn btn-success" type="submit">Finalizar Check-out</button>
                <button type ="button" class="btn btn-secondary" onclick="window.location.href='../index.php'">Voltar</button><br>
            </form>
            </div>
        <?php else: ?>
            <p>Morador não encontrado.</p>
        <?php endif; ?>
            </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">      
        </script>
    </body>
    </html>