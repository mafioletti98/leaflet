<?php

require_once("database.php");

try {
    // Conexão com o banco de dados
    $conn = new PDO($dns);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta SQL para obter os dados
    $sql = "SELECT dql, latitude, longitude, img_path FROM ponto"; // Ajuste o nome da tabela conforme necessário ('ponto' é um exemplo)
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Inicializa o array GeoJSON
    $geojson = array(
        'type' => 'FeatureCollection',
        'features' => array()
    );

    // Itera sobre os resultados da consulta e cria as features GeoJSON
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $feature = array(
            'type' => 'Feature',
            'geometry' => array(
                'type' => 'Point',
                'coordinates' => array(
                    floatval($row['longitude']),  // Longitude vem primeiro
                    floatval($row['latitude'])    // Latitude vem depois
                )
            ),
            'properties' => array(
                'dql' => $row['dql'],
                'img_path' => 'fachada/' . $row['img_path'] // Caminho para a imagem na pasta 'fachada'
                // Adicione outras propriedades conforme necessário
            )
        );
        array_push($geojson['features'], $feature);
    }

    // Define o cabeçalho como JSON
    header('Content-Type: application/json');
    
    // Retorna os dados em formato GeoJSON
    echo json_encode($geojson);

} catch (PDOException $e) {
    // Em caso de erro, retorna mensagem de erro
    echo "Erro ao executar consulta SQL: " . $e->getMessage();
}
