<?php
session_start();
require_once '../class/Planet.php'; // Assurez-vous que le chemin est correct

$departurePlanetData = $_SESSION['departurePlanetData'];
$arrivalPlanetData = $_SESSION['arrivalPlanetData'];

$departurePlanet = new Planet($departurePlanetData);
$arrivalPlanet = new Planet($arrivalPlanetData);


$distance = $departurePlanet->calculateDistance($arrivalPlanet);

var_dump($distance);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Map</title>
    <link rel="stylesheet" type="text/css" href="../css/map.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

</head>
<body>

    <p><strong>Departure Planet:</strong> <?php echo $_SESSION['departurePlanet']; ?></p>
    <p><strong>Arrival Planet:</strong> <?php echo $_SESSION['arrivalPlanet']; ?></p>
    <p><strong>Date:</strong> <?php echo $_SESSION['date']; ?></p>
    <p><strong>Number of Travelers:</strong> <?php echo $_SESSION['travelers']; ?></p>

    <h2>Distance between planets:</h2>
    <p><?php echo "The distance between " . $_SESSION['departurePlanet'] . " and " . $_SESSION['arrivalPlanet'] . " is " . round($distance, 2) . " 10^18 km."; ?></p>

    <h1>Carte Spatiale</h1>

    <div class="stars"></div>
    <div id="map"></div>
    <script src="../script/map.js" ></script>
    <script>
        var departurePlanet = '<?php echo isset($_SESSION["departurePlanet"]) ? $_SESSION["departurePlanet"] : ""; ?>';
        var arrivalPlanet = '<?php echo isset($_SESSION["arrivalPlanet"]) ? $_SESSION["arrivalPlanet"] : ""; ?>';
    </script>

    <div id="legend">
        <h4>Légende des Régions</h4>
        <div class="legend-item"><div class="legend-color" style="background-color: #FFEB3B;"></div> Colonies</div>
        <div class="legend-item"><div class="legend-color" style="background-color: #FFC107;"></div> Core</div>
        <div class="legend-item"><div class="legend-color" style="background-color: #FF9800;"></div> Deep Core</div>
        <div class="legend-item"><div class="legend-color" style="background-color: #FF5722;"></div> Expansion Region</div>
        <div class="legend-item"><div class="legend-color" style="background-color: #FF3D00;"></div> Extragalactic</div>
        <div class="legend-item"><div class="legend-color" style="background-color: #F44336;"></div> Hutt Space</div>
        <div class="legend-item"><div class="legend-color" style="background-color: #FF5722;"></div> Inner Rim Territories</div>
        <div class="legend-item"><div class="legend-color" style="background-color: #FF9800;"></div> Mid Rim Territories</div>
        <div class="legend-item"><div class="legend-color" style="background-color: #3F51B5;"></div> Outer Rim Territories</div>
        <div class="legend-item"><div class="legend-color" style="background-color: #2196F3;"></div> Talcene Sector</div>
        <div class="legend-item"><div class="legend-color" style="background-color: #1976D2;"></div> The Centrality</div>
        <div class="legend-item"><div class="legend-color" style="background-color: #0D47A1;"></div> Tingel Arm</div>
        <div class="legend-item"><div class="legend-color" style="background-color: #004D40;"></div> Wild Space</div>
        <div class="legend-item"><div class="legend-color" style="background-color: #001F3F;"></div> Autre</div>
    </div>






</body>
</html>