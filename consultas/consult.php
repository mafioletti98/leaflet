<?php

require_once("../database.php"); 

// Obtendo o valor do parâmetro img_path enviado via GET
$img_path = $_GET['img_path'];

try {
    // Conexão com o banco de dados (supondo que $dns já esteja definido no arquivo database.php)
    $conn = new PDO($dns);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Preparação da consulta SQL
    $sql = "SELECT dql, latitude, longitude, img_path FROM ponto WHERE img_path = :img_path"; 
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':img_path', $img_path, PDO::PARAM_STR);
    $stmt->execute();

    // Processamento dos resultados
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    // Exemplo de uso dos dados obtidos
    if ($resultado) {
        echo "DQL: " . $resultado['dql'] . "<br>";
        echo "Latitude: " . $resultado['latitude'] . "<br>";
        echo "Longitude: " . $resultado['longitude'] . "<br>";
        echo "Imagem: " . $resultado['img_path'] . "<br>";
    } else {
        echo "Nenhum resultado encontrado para img_path = $img_path";
    }
} catch (PDOException $e) {
    echo "Erro ao executar consulta SQL: " . $e->getMessage();
}
?>
