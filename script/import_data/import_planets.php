<?php

ini_set('max_execution_time', 300);
ini_set('memory_limit', '1G');

global $pdo;
require '../../php/pdo.php';
require '../../class/Region.php';
require '../../class/Sector.php';
require '../../class/Planet.php';
require '../../class/Trip.php';
require '../../class/Sun.php';

// Clear existing data
$tablesToReset = [
    "travia_trips", "travia_day_name",
    "travia_sun", "travia_planet", "travia_sector", "travia_region"
];

foreach ($tablesToReset as $table) {
    $pdo->exec("DELETE FROM $table");
    $pdo->exec("ALTER TABLE $table AUTO_INCREMENT = 1");
}
// Load JSON File
$jsonData = file_get_contents('../../assets/data/planets_details.json');
$dataArray = json_decode($jsonData, true);


// Ensure all keys are lowercase
/*function toLowerCaseKeys($array) {
    return array_map(function($item) {
        return is_array($item) ? toLowerCaseKeys($item) : $item;
    }, array_change_key_case($array, CASE_LOWER));
}

$dataArray = array_map('toLowerCaseKeys', $dataArray);*/

// Add new planets
foreach ($dataArray as $data) {
    $region = new Region();
    $sector = new Sector();
    $sun = new Sun();

    $regionId = isset($data['Region']) ? $region->getOrInsertRegion($pdo, $data['Region']) : null;
    $sectorId = isset($data['Sector']) ? $sector->getOrInsertSector($pdo, $data['Sector']) : null;
    $sunId = isset($data['SunName']) && !empty($data['SunName']) ? $sun->getOrInsertSun($pdo, $data['SunName']) : null;

    if ($regionId !== null && $sectorId !== null) {
        $planet = new Planet($data);
        $planetId = $planet->insertPlanet($pdo, $regionId, $sectorId, $sunId);

        // Insert trips for this planet
        foreach ($data['trips'] as $dayName => $tripDetails) {
            foreach ($tripDetails as $tripData) {
                $departureTime = $tripData['departure_time'][0];
                $destinationPlanetId = $tripData['destination_planet_id'][0];
                $shipId = $tripData['ship_id'][0];

                $trip = new Trip($dayName, $departureTime, $destinationPlanetId, $shipId);
                $dayNameId = $trip->getOrInsertDayName($pdo);

                if ($dayNameId) {
                    $trip->insertTrip($pdo, $departureTime, $planetId, $shipId, $dayNameId);
                } else {
                    echo "Error for insertion of trips " . htmlspecialchars($dayName) . "<br>";
                }
            }
        }

    } else {
        echo "Error for insertion of region or sector for planet " . htmlspecialchars($data['Name']) . "<br>";
    }
}
?>
