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
        <title>Casa de passagem - Cadastro de Hóspede</title>
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
          Check
          <span>Out</span>
        </h1>
    </div>
    
        <?php if ($hospedagem_id): ?>
            <form method = "post" action = "checkout.php?id=<?php echo $hospedagem_id ?>" onsubmit="return confirm('Deseja fazer o check-out?')">
        <div id="input-container">
            <div class = "form-row">
            <div class = "input-box">
            <label class = "form-label" for="jantou">Jantou:</label>
                <select class ="form-select" name="jantou" required>
                    <option value="">Selecione</option>
                    <option value="Sim">Sim</option>
                    <option value="Não">Não</option>
                </select></div><br>

            <div class = "input-box">
            <label class = "form-label" for="banho">Tomou banho:</span>
                <select class ="form-select" name="banho" required>
                    <option value="">Selecione</option>
                    <option value="Sim">Sim</option>
                    <option value="Não">Não</option>
                </select></div><br>

            <div class = "input-box">
            <label class = "form-label" for="passagem">Passagem:</span>
                <select class ="form-select" name="passagem" required>
                    <option value="">Selecione</option>
                    <option value="Sim">Sim</option>
                    <option value="Não">Não</option>
                </select></div><br>
            </div>    

            <div class = "form-row">
            <div class = "input-box">
            <label class = "form-label" for="destino">Destino:</span>
                <input type="text" class="form-control" name="destino"><br>
            </div><br>

            <div class = "input-box">
            <label class = "form-label" for="atendente">Atendente:</span>
                <input type="text" class="form-control" name="atendente"><br>
            </div>
            </div>

            <div class = "form-row">
                <button class="btn btn-success" type="submit">Finalizar Check-out</button>
                <button type ="button" class="btn btn-secondary" onclick="window.location.href='../index.php'">Voltar</button><br>
            </div>
            </form>
            </div>
        <?php else: ?>
            <p>Morador não encontrado.</p>
        <?php endif; ?>
            </div>
            </main>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">      
        </script>
    </body>
    </html>