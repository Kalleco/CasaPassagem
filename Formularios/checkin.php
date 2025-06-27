<?php
require 'processo.php';

if (!isset($_GET['id'])) {
    die("ID do morador não informado.");
}

$stmtvagas = $db->prepare("SELECT total_vagas FROM vagas");
$stmtvagas->execute();
$total_vagas = $stmtvagas->fetchColumn();


$stmt = $db->prepare("select count(*) from hospedagens where data_checkout is null");
$stmt->execute();
$checkinativo = $stmt->fetchColumn();

if($checkinativo >= $total_vagas){
    echo "<script>
        alert('Número de vagas atingido. Não é possível realizar o check-in');
        window.location.href = '../lista.php'; // redireciona para a lista ou onde desejar
          </script>";
    exit;
}

$moradorId = $_GET['id'];
$dataCheckin = date('y-m-d H:i:s');

// Verifica se o morador já tem hospedagem ativa
$sql = "SELECT * FROM hospedagens WHERE morador_id = :id AND data_checkout IS NULL";
$stmt = $db->prepare($sql);
$stmt->bindValue(':id', $moradorId, PDO::PARAM_INT);
$stmt->execute();
$hospedagemAtiva = $stmt->fetch();

if ($hospedagemAtiva) {
    echo "Este morador já possui um check-in ativo.";
    header("Location: ../Paginas/lista.php");
    exit;
}

// Insere nova hospedagem (check-in)
$sql = "INSERT INTO hospedagens (morador_id, data_checkin) VALUES (:id, :data)";
$stmt = $db->prepare($sql);
$stmt->bindValue(':id', $moradorId, PDO::PARAM_INT);
$stmt->bindValue(':data', $dataCheckin);
$stmt->execute();

// Redireciona para a lista
header("Location: ../Paginas/lista.php");
exit;
?>
