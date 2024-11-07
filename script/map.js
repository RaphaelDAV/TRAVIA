    var map = L.map('map', {
    crs: L.CRS.Simple,
    minZoom: 2
});

    function xy(x, y) {
    return L.latLng(y, x);
}

//____________________________COLORS___________________________________

    function getRegionColor(region) {
        switch(region) {
            case 'Colonies': return 'rgba(0, 255, 255, 0.4)';
            case 'Core': return 'rgba(0, 229, 255, 0.4)';
            case 'Deep Core': return 'rgba(0, 204, 255, 0.4)';
            case 'Expansion Region': return 'rgba(0, 178, 255, 0.4)';
            case 'Extragalactic': return 'rgba(0, 153, 255, 0.4)';
            case 'Hutt Space': return 'rgba(0, 127, 255, 0.4)';
            case 'Inner Rim Territories': return 'rgba(0, 102, 255, 0.4)';
            case 'Mid Rim Territories': return 'rgba(0, 76, 255, 0.4)';
            case 'Outer Rim Territories': return 'rgba(0, 51, 255, 0.4)';
            case 'Talcene Sector': return 'rgba(0, 26, 255, 0.4)';
            case 'The Centrality': return 'rgba(0, 0, 255, 0.4)';
            case 'Tingel Arm': return 'rgba(0, 0, 229, 0.4)';
            case 'Wild Space': return 'rgba(0, 0, 204, 0.4)';
            default: return 'rgba(0, 0, 153, 0.4)';
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

//____________________________GRID___________________________________

    function drawGrid() {
    var step = 5;

        for (var i = 0; i <= 100; i += step) {
            L.polyline([[0, i], [100, i]], { color: 'rgba(0, 153, 255, 0.3)', weight: 1, opacity: 0.8 }).addTo(map); // Horizontal
            L.polyline([[i, 0], [i, 100]], { color: 'rgba(0, 153, 255, 0.3)', weight: 1, opacity: 0.8 }).addTo(map); // Vertical

            if (i % 10 === 0) {
                L.marker([i, -2], { icon: L.divIcon({ className: 'grid-label', html: i.toString() }) }).addTo(map);
                L.marker([-2, i], { icon: L.divIcon({ className: 'grid-label', html: i.toString() }) }).addTo(map);
            }
        }

}

    drawGrid();


//____________________________ZOOM AND DRAG___________________________________

    map.on('drag', function() {
    map.panInsideBounds(bounds, { animate: false });
});

    map.on('zoomend', function() {
    var currentZoom = map.getZoom();
    if (currentZoom < 2) {
    map.setZoom(2);
}
});


//____________________________DYNAMIC SELECTION OF TWO PLANETS___________________________________

    var departurePlanet = '<?php echo isset($_SESSION["departurePlanet"]) ? $_SESSION["departurePlanet"] : ""; ?>';
    var arrivalPlanet = '<?php echo isset($_SESSION["arrivalPlanet"]) ? $_SESSION["arrivalPlanet"] : ""; ?>';

    console.log('Departure Planet:', departurePlanet);
    console.log('Arrival Planet:', arrivalPlanet);

    let selectedPlanets = [];
    let line;
    let departurePlanetPos = null;
    let arrivalPlanetPos = null

    function selectPlanet(planet, position) {
        selectedPlanets.push({ planet, position });

        L.marker(position).addTo(map)
            .bindPopup(`${planet.name}`)
            .openPopup();

        if (selectedPlanets.length === 2) {
            drawLine(selectedPlanets[0].position, selectedPlanets[1].position);
        }
    }


    function drawLine(start, end) {
        if (line) {
            map.removeLayer(line);
        }
        line = L.polyline([start, end], { color: 'yellow', weight: 5 }).addTo(map);
    }


//____________________________DISPLAY THE PLANETS ___________________________________



    // Display the planets
    fetch('../php/get_planets.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(planet => {
                var x = parseFloat(planet.x);
                var subgridx = parseFloat(planet.subgridx);
                var y = parseFloat(planet.y);
                var subgridy = parseFloat(planet.subgridy);

                var positionX = (x + subgridx) * 5;
                var positionY = (y + subgridy) * 5 - 5;

                var position = xy(positionX, positionY);

                var diameter = planet.diameter > 0 ? planet.diameter : 10000;

                var circleOptions = {
                    color: getRegionColor(planet.region),
                    fillColor: getRegionColor(planet.region),
                    radius: 1.5
                };

                var marker = L.circleMarker(position, circleOptions)
                    .addTo(map)
                    .bindPopup(`${planet.name} (Diamètre: ${diameter} km)`);

                if (planet.name === departurePlanet) {
                    departurePlanetPos = position;
                    selectPlanet(planet, position);
                } else if (planet.name === arrivalPlanet) {
                    arrivalPlanetPos = position;
                    selectPlanet(planet, position);
                }
            });

            console.log('Departure Planet Position:', departurePlanetPos);
            console.log('Arrival Planet Position:', arrivalPlanetPos);

            if (departurePlanetPos && arrivalPlanetPos) {
                drawLine(departurePlanetPos, arrivalPlanetPos);
            }
        });


