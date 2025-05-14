<?php
require 'processo.php';

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])){
    $stmt = $db->prepare("
    UPDATE moradores SET
    nome = ?,
    idade = ?,
    data_nasc = ?,
    rg = ?,
    cpf = ?,
    cidade_origem = ?
    WHERE id = ?
    ");

    $stmt->execute([
        $_POST['nome'],
        $_POST['idade'],
        $_POST['data_nasc'],
        $_POST['rg'],
        $_POST['cpf'],
        $_POST['cidade_origem'],
        $_POST['id']
    ]);

    echo "Cadastro atualizado com sucesso! <a href='../index.php'>Voltar</a>";
} else {
    echo "Erro ao atualizar cadastro. <a href='../index.php'>Voltar</a>";
}

?>