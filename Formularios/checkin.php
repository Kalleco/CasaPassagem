<?php
require 'processo.php';

$stmt = $db->prepare(" SELECT id FROM moradores WHERE nome = ? AND cpf = ?"); // Preparando a consulta SQl segura
$stmt->execute([$_POST['nome'], $_POST['cpf']]);//Executa a consulta com os dados do formulario
$morador = $stmt->fetch();

// Verifica se o morador já existe no banco
if ($morador){
    $morador_id = $morador['id'];

} else{
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
}

// Nova hospedagem  
$stmt = $db->prepare("INSERT INTO hospedagens (morador_id, data_checkin) 
VALUES (?, datetime('now'))");

$stmt->execute( [
    $morador_id,
]);

echo "Check-in feito com sucesso! <a href='../index.php'>Voltar</a>";
?>
