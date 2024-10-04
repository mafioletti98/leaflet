$(document).ready(function(){
    loadGeoJSON(); // Chama a função para carregar o GeoJSON assim que o documento estiver pronto
});

function loadGeoJSON() {
    $.ajax({
        url: '../geojson.php', // Caminho correto para o script PHP que gera o GeoJSON
        method: 'GET', // Use GET para buscar os dados GeoJSON
        dataType: 'json', // Espera receber dados JSON
        success: function(data) {
            // Callback de sucesso
            createMarkers(data); // Chama a função para criar os marcadores no mapa com base nos dados recebidos
        },
        error: function(xhr, status, error) {
            console.error('Erro ao carregar GeoJSON:', status, error);
        }
    });
}

function createMarkers(data) {
    // Configuração do mapa Leaflet
    const map = L.map('map').setView([-3.7386406943108894, -38.5477232612709], 15);

    // Camada base do mapa
    var Esri_WorldImagery = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
    }).addTo(map);

    // Itera sobre os dados GeoJSON e cria os marcadores
    L.geoJSON(data, {
        onEachFeature: function(feature, layer) {
            const properties = feature.properties;
            const coordinates = feature.geometry.coordinates;

            // Conteúdo do popup
            const popupContent = `
                <strong>dql: ${properties.dql}</strong><br>
                Latitude: ${coordinates[1]}<br>
                Longitude: ${coordinates[0]}<br>
                <img src='${properties.img_path}' width='200px'>
            `;

            // Adiciona o popup ao marcador
            layer.bindPopup(popupContent);
        }
    }).addTo(map);
}
