<?php

ini_set('max_execution_time', 300);
ini_set('memory_limit', '1G');

global $pdo;
require '../../php/pdo.php';
require '../../class/Region.php';
require '../../class/Sector.php';
require '../../class/Planet.php';
require '../../class/Trip.php';

// Clear existing data
$pdo->exec("DELETE FROM Have_day");
$pdo->exec("DELETE FROM Have_sun");
$pdo->exec("DELETE FROM travia_day_content");

$pdo->exec("DELETE FROM travia_journeys");
$pdo->exec("DELETE FROM travia_trips");
$pdo->exec("DELETE FROM travia_day_name");
$pdo->exec("DELETE FROM travia_sun");

$pdo->exec("DELETE FROM travia_planet");

$pdo->exec("DELETE FROM travia_sector");
$pdo->exec("DELETE FROM travia_region");

// Reset AUTO_INCREMENT for all tables
$pdo->exec("ALTER TABLE Have_day AUTO_INCREMENT = 1");
$pdo->exec("ALTER TABLE Have_sun AUTO_INCREMENT = 1");
$pdo->exec("ALTER TABLE travia_day_content AUTO_INCREMENT = 1");
$pdo->exec("ALTER TABLE travia_journeys AUTO_INCREMENT = 1");
$pdo->exec("ALTER TABLE travia_trips AUTO_INCREMENT = 1");
$pdo->exec("ALTER TABLE travia_day_name AUTO_INCREMENT = 1");
$pdo->exec("ALTER TABLE travia_sun AUTO_INCREMENT = 1");
$pdo->exec("ALTER TABLE travia_planet AUTO_INCREMENT = 1");
$pdo->exec("ALTER TABLE travia_sector AUTO_INCREMENT = 1");
$pdo->exec("ALTER TABLE travia_region AUTO_INCREMENT = 1");
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

    $regionId = $region->getOrInsertRegion($pdo, $data['Region']);
    $sectorId = $sector->getOrInsertSector($pdo, $data['Sector']);

    if ($regionId !== null && $sectorId !== null) {
        $planet = new Planet($data);
        $planetId = $planet->insertPlanet($pdo, $regionId, $sectorId);

        // Insert trips for this planet
        foreach ($data['trips'] as $dayName => $tripDetails) {
            $trip = new Trip($dayName, $tripDetails);
            $tripId = $trip->insertTrip($pdo, $planetId);
            $dayNameId = $trip->getOrInsertDayName($pdo);
            $trip->insertHaveDay($pdo, $tripId, $dayNameId);
            $trip->insertDayContent($pdo, $dayNameId);

        }
    } else {
        echo "Error for insertion of region or sector for planet " . htmlspecialchars($data['Name']) . "<br>";
    }
}
?>
