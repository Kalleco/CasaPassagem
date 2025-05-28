<?php
require 'processo.php';

if (!isset($_GET['id'])) {
    die("ID do morador não informado.");
}

$moradorId = $_GET['id'];
$dataCheckin = date('d-m-y H:i:s');

// Verifica se o morador já tem hospedagem ativa
$sql = "SELECT * FROM hospedagens WHERE morador_id = :id AND data_checkout IS NULL";
$stmt = $db->prepare($sql);
$stmt->bindValue(':id', $moradorId, PDO::PARAM_INT);
$stmt->execute();
$hospedagemAtiva = $stmt->fetch();

if ($hospedagemAtiva) {
    echo "Este morador já possui um check-in ativo.";
    header("Location: ../lista.php");
    exit;
}

// Insere nova hospedagem (check-in)
$sql = "INSERT INTO hospedagens (morador_id, data_checkin) VALUES (:id, :data)";
$stmt = $db->prepare($sql);
$stmt->bindValue(':id', $moradorId, PDO::PARAM_INT);
$stmt->bindValue(':data', $dataCheckin);
$stmt->execute();

// Redireciona para a lista
header("Location: ../lista.php");
exit;
?>
