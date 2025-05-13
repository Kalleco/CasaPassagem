<?php
require 'processo.php';

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

try {
    // Verifica se tem hospedagens ativa do morador no banco
    $stmt1 = $db->prepare("DELETE FROM hospedagens WHERE morador_id = ?");
    $stmt1->execute([$id]);

    //Verifica se tem o morador no banco
    $stmt2 = $db->prepare("DELETE FROM moradores WHERE id = ?");
    $stmt2->execute([$id]);

    echo "Morador deletado com sucesso! <a href='index.php'>Voltar</a>";

    } catch (PDOException $e) {
        echo "Erro ao excluir: " . $e->getMessage();
    }

} else {
    echo "Erro ao deletar morador. <a href='index.php'>Voltar</a>";
}

?>