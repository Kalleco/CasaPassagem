<?php
require 'processo.php';
$morador_id = $_GET['id'] ?? null;

/*if($morador_id && isset($_POST['jantou']) && isset($_POST['passagem']) && isset($_POST['destino']))*/
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $morador_id &&
    isset($_POST['jantou'], $_POST['passagem'], $_POST['destino'])) {
    // Verifica se o morador já existe no banco
    $stmt = $db->prepare(
        "UPDATE hospedagens 
        SET data_checkout = datetime('now'), jantou = ?, passagem = ?, destino = ? 
        WHERE morador_id = ? and data_checkout is NULL");

    $stmt->execute([
        $_POST['jantou'],
        $_POST['passagem'],
        $_POST['destino'],
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
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1>Check-out</h1>
        <?php if ($morador_id): ?>
            <form method = "post" action = "checkout.php?id=<?php echo $morador_id ?>" onsubmit="return confirm('Deseja fazer o check-out?')">
                <label for="jantou">Jantou:</label>
                <select name="jantou" required>
                    <option value="">Selecione</option>
                    <option value="Sim">Sim</option>
                    <option value="Não">não</option>
                </select><br>

                <label for="passagem">Recebeu passagem?:</label>
                <select name="passagem" required>
                    <option value="">Selecione</option>
                    <option value="Sim">Sim</option>
                    <option value="Não">não</option>
                </select><br>

                <label for="destino">Destino:</label>
                <input type="text" name="destino"><br>

                <input type="submit" value="Finalizar Check-out">
            </form>
        <?php else: ?>
            <p>Morador não encontrado.</p>
        <?php endif; ?>

        <a href="../index.html">voltar</a>
    </body>