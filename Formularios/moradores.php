<?php
require 'processo.php';

    $stmt = $db->prepare("INSERT INTO moradores (nome, data_nasc, rg, cpf, cidade_origem, beneficio) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['nome'],
        $_POST['data_nasc'],
        $_POST['rg'],
        $_POST['cpf'],
        $_POST['cidade_origem'],
        $_POST['beneficio']
    ]);
    $morador_id = $db->lastInsertId(); // Pega o id do morador que acabou de ser inserido

header("Location: ../Paginas/lista.php");
exit;
?>
