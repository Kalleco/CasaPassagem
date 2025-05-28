<?php
require 'processo.php';

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])){
    $stmt = $db->prepare("
    UPDATE moradores SET
    nome = ?,
    data_nasc = ?,
    rg = ?,
    cpf = ?,
    cidade_origem = ?,
    beneficio = ?
    WHERE id = ?
    ");

    $stmt->execute([
        $_POST['nome'],
        $_POST['data_nasc'],
        $_POST['rg'],
        $_POST['cpf'],
        $_POST['cidade_origem'],
        $_POST['beneficio'],
        $_POST['id']
    ]);

    header("Location: ../fazcheckin.php?atualizado=1");
    exit;

} else {
    header("Location: ../index.php");

}
?>

