<?php
require 'processo.php';

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

try {
    // Verifica se tem hospedagens ativa do morador no banco
    $stmt1 = $db->prepare("DELETE FROM hospedagens WHERE id = ?");
    $stmt1->execute([$id]);

      header("Location: ../lista.php");
        exit;

    } catch (PDOException $e) {
        echo "Erro ao excluir: " . $e->getMessage();
    }

} else {
    echo "Erro ao cancelar check-in. <a href='../index.php'>Voltar</a>";

}

?>