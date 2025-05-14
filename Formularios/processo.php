<?php
$dbPath = __DIR__ . "/db.sqlite"; // Define o caminho do arquivo SQLite

$db = new PDO("sqlite:" . $dbPath);// Cria uma conexão com o Bd e define o caminho do arquivo
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$db->exec("
 CREATE TABLE IF NOT EXISTS moradores(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    idade INTEGER NOT NULL,
    data_nasc TEXT NOT NULL,
    rg TEXT NOT NULL,
    cpf TEXT NOT NULL,
    cidade_origem TEXT NOT NULL
    );
 ");

 $db->exec("
 CREATE TABLE IF NOT EXISTS hospedagens(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    morador_id INTEGER,
    data_checkin TEXT,
    data_checkout TEXT,
    jantou TEXT,
    passagem TEXT,
    destino TEXT,
    FOREIGN KEY (morador_id) REFERENCES moradores(id)
    );
");
?>