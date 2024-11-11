<?php
session_start();
include '../class/Planet.php';

//Information for departure and arrival planets
$departurePlanetData = $_SESSION['departurePlanetData'];
$arrivalPlanetData = $_SESSION['arrivalPlanetData'];

$departurePlanet = new Planet($departurePlanetData);
$arrivalPlanet = new Planet($arrivalPlanetData);

$distance = $departurePlanet->calculateDistance($arrivalPlanet);

//Image of arrival planet
$imageName = $arrivalPlanet->getImage();
$md5Hash = md5($imageName);
$defaultImage = '../assets/map/unknow_planet.png';
$imagePath = $defaultImage;

if (!empty($imageName)) {
    $firstChar = strtolower(substr($md5Hash, 0, 1));
    $firstTwoChars = strtolower(substr($md5Hash, 0, 2));
    $imagePath = "https://static.wikia.nocookie.net/starwars/images/{$firstChar}/{$firstTwoChars}/{$imageName}";
}

//Get all the tickets for each ships
include '../php/trip_cost.php';

if (isset($_SESSION['shipCosts'])) {
    $shipCosts = $_SESSION['shipCosts'];
} else {
    echo "No ship data available.";
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Map</title>
    <link rel="stylesheet" type="text/css" href="../css/map.css" />
    <link rel="stylesheet" type="text/css" href="../css/header_footer.css" />

    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/star-wars" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">



    <!--  CSS of Leaflet.js -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

    <!--  JS of Leaflet.js -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- CSS of Splide.js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.3/dist/css/splide.min.css">

    <!-- JS of Splide.js -->
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.3/dist/js/splide.min.js"></script>
</head>
<body>
    <div id="header-container"></div>
    <script>
        fetch('header.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('header-container').innerHTML = data;
            })
            .catch(error => {
                console.error('Erreur lors du chargement du header:', error);
            });
    </script>
    <!--_______________________________ PLANET INFORMATION _______________________________-->
    <div class="planet-section">
        <div class="main-flex">
            <h1><?php echo $_SESSION['arrivalPlanet']; ?></h1>
            <img class="assets1" src="../assets/map/assets1.png" alt="assets1">
            <h2><b>Coord :</b>
                <?php echo $arrivalPlanet->getSubgridx(); ?>
                <?php echo $arrivalPlanet->getSubgridy(); ?>
                <?php echo $arrivalPlanet->getSubgridcood(); ?>
                <?php echo $arrivalPlanet->getCoord(); ?>
            </h2>
            <div class="flex1">
                <img class="assets2" src="../assets/map/assets2.png" alt="assets2">
                <div class="planet-info">
                    <p><b>SUNS :</b> <?php echo $arrivalPlanet->getSuns(); ?></p>
                    <p><b>MOONS :</b> <?php echo $arrivalPlanet->getMoons(); ?></p>
                    <p><b>DIAMETER :</b> <?php echo $arrivalPlanet->getDiameter(); ?></p>
                    <p><b>REGION :</b> <?php echo $arrivalPlanet->getIdRegion(); ?></p>
                    <p><b>SECTOR :</b> <?php echo $arrivalPlanet->getIdSector(); ?></p>
                    <p><b>POSITION :</b> <?php echo $arrivalPlanet->getPlanetPosition(); ?></p>
                    <p><b>DISTANCE :</b> <?php echo $arrivalPlanet->getDistance(); ?></p>
                </div>
                <img class="assets3" src="../assets/map/assets3.png" alt="assets3">
            </div>
            <div class="flex2">
                <img class="assets4" src="../assets/map/assets4.png" alt="assets4">
                <img class="assets5" src="../assets/map/assets5.png" alt="assets5">
            </div>
            <div class="flex3">
                <p><b>LENGHTDAY :</b> <?php echo $arrivalPlanet->getLengthday(); ?></p>
                <p>|</p>
                <p><b>LENGHYEAR :</b> <?php echo $arrivalPlanet->getLengthyear(); ?></p>
                <p>|</p>
                <p><b>GRAVITY :</b> <?php echo $arrivalPlanet->getGravity(); ?> </p>
            </div>
        </div>
        <div class="round-image" style="background-image: url(<?php echo $imagePath; ?>)"></div>

    </div>

    <div class="transition"></div>

    <!--_______________________________TRIP_______________________________-->
    <section class="travel-information">
        <h1>INTERPLANETARY TRIP</h1>
        <hr>
        <div class="choices">
            <h2>Choices made</h2>
            <div class="choices-flex">
                <p><strong>Departure Planet :</strong> <?php echo isset($_SESSION['departurePlanet']) ? $_SESSION['departurePlanet'] : 'N/A'; ?></p>
                <p><strong>Arrival Planet :</strong> <?php echo isset($_SESSION['arrivalPlanet']) ? $_SESSION['arrivalPlanet'] : 'N/A'; ?></p>
                <p><strong>Date :</strong> <?php echo !empty($_SESSION['date']) ? $_SESSION['date'] : 'Non spécifiée'; ?></p>
                <p><strong>Number of Travelers :</strong> <?php echo !empty($_SESSION['travelers']) ? $_SESSION['travelers'] : 'Non spécifié'; ?></p>

            </div>
            <div class="distance-flex">
                <h3>Distance between planets:</h3>
                <p><?php echo "The distance between " . $_SESSION['departurePlanet'] . " and " . $_SESSION['arrivalPlanet'] . " is " . round($distance, 2) . " 10^18 km."; ?></p>
            </div>
        </div>

        <hr>


    </section>

    <section class="map-section">
        <div id="map"></div>
        <script src="../script/map.js" ></script>
        <script>
            var departurePlanet = '<?php echo isset($_SESSION["departurePlanet"]) ? $_SESSION["departurePlanet"] : ""; ?>';
            var arrivalPlanet = '<?php echo isset($_SESSION["arrivalPlanet"]) ? $_SESSION["arrivalPlanet"] : ""; ?>';
        </script>

        <div id="legend">
            <h4>Legend of regions</h4>
            <div class="legend-item"><div class="legend-color" style="background-color: rgb(0, 255, 255);"></div> Colonies</div>
            <div class="legend-item"><div class="legend-color" style="background-color: rgb(0, 229, 255);"></div> Core</div>
            <div class="legend-item"><div class="legend-color" style="background-color: rgb(0, 204, 255);"></div> Deep Core</div>
            <div class="legend-item"><div class="legend-color" style="background-color: rgb(0, 178, 255);"></div> Expansion Region</div>
            <div class="legend-item"><div class="legend-color" style="background-color: rgb(0, 153, 255);"></div> Extragalactic</div>
            <div class="legend-item"><div class="legend-color" style="background-color: rgb(0, 127, 255);"></div> Hutt Space</div>
            <div class="legend-item"><div class="legend-color" style="background-color: rgb(0, 102, 255);"></div> Inner Rim Territories</div>
            <div class="legend-item"><div class="legend-color" style="background-color: rgb(0, 76, 255);"></div> Mid Rim Territories</div>
            <div class="legend-item"><div class="legend-color" style="background-color: rgb(0, 51, 255);"></div> Outer Rim Territories</div>
            <div class="legend-item"><div class="legend-color" style="background-color: rgb(0, 26, 255);"></div> Talcene Sector</div>
            <div class="legend-item"><div class="legend-color" style="background-color: rgb(0, 0, 255);"></div> The Centrality</div>
            <div class="legend-item"><div class="legend-color" style="background-color: rgb(0, 0, 229);"></div> Tingel Arm</div>
            <div class="legend-item"><div class="legend-color" style="background-color: rgb(0, 0, 204);"></div> Wild Space</div>
            <div class="legend-item"><div class="legend-color" style="background-color: rgb(0, 0, 153);"></div> Other</div>
        </div>

        <img src="../assets/map/r2d2.png" alt="R2D2" class="r2d2">

    </section>

    <!--_______________________________TICKETS_______________________________-->
    <section class="tickets">
        <div class="tickets-left">
            <?php foreach ($shipCosts as $ship): ?>
                <div class="ticket">
                    <div class="ticket-flex1">
                        <?php
                        $camp_id = htmlspecialchars($ship['camp_id']);

                        $imagePath = "../assets/default_image.png";

                        switch ($camp_id) {
                            case 1:
                                $imagePath = "../assets/map/smugglers.png";
                                break;
                            case 2:
                                $imagePath = "../assets/map/empire.png";
                                break;
                            case 3:
                                $imagePath = "../assets/map/rebels.png";
                                break;
                            default:
                                $imagePath = "../assets/map/smugglers.png";
                                break;
                        }
                        ?>

                        <img src="<?php echo $imagePath; ?>" alt="camp" ">
                        <div class="credits">
                            <p><?php
                                $unit_price = round($ship['base_cost'] * (1 + ($ship['speed_kmh'] / LIGHT_SPEED)), 2);
                                echo $unit_price ?>
                            </p>
                            <img src="../assets/map/credits.png" alt="credits">
                        </div>
                    </div>
                    <div class="ticket-flex2">

                        <img src="../assets/map/<?php echo htmlspecialchars($ship['name']); ?>.png" alt="spaceship">
                        <p>Tickets for the <br>Planetary <br>Trips</p>
                    </div>
                    <div class="ticket-flex3">
                        <div class="ticket-flex4">
                            <p>The spaceship name is:</p>
                            <h2><?php echo htmlspecialchars($ship['name']); ?></h2>
                        </div>
                        <div class="ticket-flex5">
                            <h3>Informations</h3>
                            <p><?php echo htmlspecialchars($ship['speed_kmh']); ?> km/h</p>
                            <p><strong>Capacity:</strong> <?php echo htmlspecialchars($ship['capacity']); ?></p>
                        </div>
                    </div>

                    <form class="form_cart" action="../php/add_to_cart.php" method="POST">
                        <input type="hidden" name="unit_price" value="<?php echo htmlspecialchars($unit_price); ?>">
                        <input type="hidden" name="id_ship" value="<?php echo htmlspecialchars($ship['id_ship']); ?>">
                        <input type="hidden" name="departure_planet" value="<?php echo htmlspecialchars($arrivalPlanet->getIdPlanet()); ?>">
                        <input type="hidden" name="arrival_planet" value="<?php echo htmlspecialchars($departurePlanet->getIdPlanet()); ?>">
                        <button class="cart-button" onclick="addToCart()" type="submit"></button>
                    </form>
                    <script>
                        function addToCart() {
                            alert("Le ticket a été ajouté au panier !");
                        }
                    </script>

                </div>
            <?php endforeach; ?>

        </div>
        <div class="tickets-right">
            <div id="carousel" class="splide">
                <h1>MOST ATTRACTIVE PLANETS</h1>
                <div class="splide__track">
                    <ul class="splide__list">
                        <li class="splide__slide">
                            <img src="../assets/map/naboo.jpg" alt="Image 1">
                            <div class="slide-content">
                                <h3>Titre de l'image 1</h3>
                                <p>Description de l'image 1. C'est un texte qui explique ce que l'on voit.</p>
                                <a href="#" class="btn">En savoir plus</a>
                            </div>
                        </li>
                        <li class="splide__slide">
                            <img src="../assets/map/naboo.jpg" alt="Image 2">
                            <div class="slide-content">
                                <h3>Titre de l'image 2</h3>
                                <p>Description de l'image 2. C'est un texte qui explique ce que l'on voit.</p>
                                <a href="#" class="btn">En savoir plus</a>
                            </div>
                        </li>
                        <li class="splide__slide">
                            <img src="../assets/map/naboo.jpg" alt="Image 3">
                            <div class="slide-content">
                                <h3>Titre de l'image 3</h3>
                                <p>Description de l'image 3. C'est un texte qui explique ce que l'on voit.</p>
                                <a href="#" class="btn">En savoir plus</a>
                            </div>
                        </li>
                        <li class="splide__slide">
                            <img src="../assets/map/naboo.jpg" alt="Image 4">
                            <div class="slide-content">
                                <h3>Titre de l'image 4</h3>
                                <p>Description de l'image 4. C'est un texte qui explique ce que l'on voit.</p>
                                <a href="#" class="btn">En savoir plus</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!--_______________________________SLIDE_______________________________-->



    <script src="../script/slide.js" ></script>











</body>
</html>