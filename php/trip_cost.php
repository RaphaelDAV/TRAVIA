<?php

if (isset($_SESSION['departurePlanetData']) && isset($_SESSION['arrivalPlanetData'])) {
    // Database connection parameters
    $servername = 'localhost';
    $username = 'traviauser';
    $password = '0mMitM!E7VmJo%6S';
    $dbname = 'traviauser';

    // Constants
    define('LIGHT_SPEED', 1080000000); // Speed of light in km/h
    define('COST_PER_TRILLION_KM', 100); // Cost per trillion km

    try {
        // Create a PDO connection
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Departure and arrival planet
        $departurePlanetData = $_SESSION['departurePlanetData'];
        $arrivalPlanetData = $_SESSION['arrivalPlanetData'];
        $departurePlanet = new Planet($departurePlanetData);
        $arrivalPlanet = new Planet($arrivalPlanetData);
        $distance = $departurePlanet->calculateDistance($arrivalPlanet);

        //Initial cost
        $initial_cost = $distance * COST_PER_TRILLION_KM ;

        //Query to get all ships
        $stmt = $pdo->query("SELECT id_ship, name, speed_kmh,capacity, id_camp FROM travia_ship");
        $ships = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //Add to a list all ships with the final cost of the trip
        $shipCosts = [];
        foreach ($ships as $ship) {
            $shipSpeed = $ship['speed_kmh'];

            $finalCost =  $shipSpeed *100 / LIGHT_SPEED;

            $shipCosts[] = [
                'id_ship' => $ship['id_ship'],
                'name' => $ship['name'],
                'speed_kmh' => $shipSpeed,
                'capacity' => $ship["capacity"],
                'camp_id' => $ship["id_camp"],
                'base_cost' => $initial_cost,
                'final_cost' => $finalCost
            ];
        }
        $_SESSION['shipCosts'] = $shipCosts;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>
