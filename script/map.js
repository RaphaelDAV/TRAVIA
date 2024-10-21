    var map = L.map('map', {
    crs: L.CRS.Simple,
    minZoom: 2
});

    function xy(x, y) {
    return L.latLng(y, x);
}

    function getRegionColor(region) {
    switch(region) {
    case 'Colonies': return '#FFEB3B';
    case 'Core': return '#FFC107';
    case 'Deep Core': return '#FF9800';
    case 'Expansion Region': return '#FF5722';
    case 'Extragalactic': return '#FF3D00';
    case 'Hutt Space': return '#F44336';
    case 'Inner Rim Territories': return '#FF5722';
    case 'Mid Rim Territories': return '#2196F3';
    case 'Outer Rim Territories': return '#3F51B5';
    case 'Talcene Sector': return '#FF9800';
    case 'The Centrality': return '#1976D2';
    case 'Tingel Arm': return '#0D47A1';
    case 'Wild Space': return '#001F3F';
    default: return '#001F3F';
}
}

    var bounds = [[0, 0], [110, 110]];
    map.setView([50, 50], 1);

    L.control.scale({
    position: 'bottomright',
    maxWidth: 200,
    metric: true,
    imperial: false
}).addTo(map);

    function drawGrid() {
    var step = 2;

    for (var i = 0; i <= 110; i += step) {
    L.polyline([[0, i], [110, i]], { color: 'gray', weight: 1, opacity: 0.5 }).addTo(map);
    L.polyline([[i, 0], [i, 110]], { color: 'gray', weight: 1, opacity: 0.5 }).addTo(map);

    if (i % 10 === 0) {
    L.marker([i, -2], { icon: L.divIcon({ className: 'grid-label', html: i.toString() }) }).addTo(map); // Etiquettes de lignes
    L.marker([-2, i], { icon: L.divIcon({ className: 'grid-label', html: i.toString() }) }).addTo(map); // Etiquettes de colonnes
}
}
}

    drawGrid();

    map.on('drag', function() {
    map.panInsideBounds(bounds, { animate: false });
});

    map.on('zoomend', function() {
    var currentZoom = map.getZoom();
    if (currentZoom < 2) {
    map.setZoom(2);
}
});

    fetch('../php/get_planets.php')
    .then(response => response.json())
    .then(data => {
    data.forEach(planet => {
        var x = parseFloat(planet.x);
        var subgridx = parseFloat(planet.subgridx);
        var y = parseFloat(planet.y);
        var subgridy = parseFloat(planet.subgridy);

        var positionX = (x + subgridx) * 5;
        var positionY = (y + subgridy) * 5;

        var position = xy(positionX, positionY);

        var diameter = planet.diameter > 0 ? planet.diameter : 10000;

        var circleOptions = {
            color: getRegionColor(planet.region),
            fillColor: getRegionColor(planet.region),
            radius: 1.5
        };

        L.circleMarker(position, circleOptions)
            .addTo(map)
            .bindPopup(`${planet.name} (Diamètre: ${diameter} km)`);

    });
})
