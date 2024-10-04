<?php
// Configurações do banco de dados
$db_nome = "pontos";
$db_host = "localhost";
$db_user = "postgres";
$db_pass = "cadastro";

// String de conexão PDO
$dns = "pgsql:host=$db_host;port=5432;dbname=$db_nome;user=$db_user;password=$db_pass options='--client_encoding=UTF8'";

try {
    // Conexão com o banco de dados
    $conn = new PDO($dns);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $Exception) {
    echo "<h2>Erro na conexão com o banco de dados</h2>" . $Exception->getMessage();
    die();
}

