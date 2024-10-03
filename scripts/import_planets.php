<?php

ini_set('max_execution_time', 300);

global $conn;
require 'connexion.php';
require '../class/Region.php';
require '../class/Sector.php';
require '../class/Planet.php';
require '../class/Trip.php';

// Clear existing data
$conn->query("DELETE FROM Have_day");
$conn->query("DELETE FROM travia_day_content");
$conn->query("DELETE FROM travia_day_name");
$conn->query("DELETE FROM travia_trips");

$conn->query("DELETE FROM travia_planet");
$conn->query("DELETE FROM travia_sun");
$conn->query("DELETE FROM travia_sector");
$conn->query("DELETE FROM travia_region");
// Load JSON File
$jsonData = file_get_contents('../assets/data/planets_details.json');
$dataArray = json_decode($jsonData, true);

// Add new planets
foreach ($dataArray as $data) {
    $region = new Region();
    $sector = new Sector();

    $regionId = $region->getOrInsertRegion($conn, $data['Region']);
    $sectorId = $sector->getOrInsertSector($conn, $data['Sector']);

    if ($regionId !== null && $sectorId !== null) {
        $planet = new Planet($data);
        $planetId = $planet->insertPlanet($conn, $regionId, $sectorId);

        // Insert trips for this planet
        foreach ($data['trips'] as $dayName => $tripDetails) {
            $trip = new Trip($dayName, $tripDetails);
            $tripId = $trip->insertTrip($conn, $planetId);
            $dayNameId = $trip->getOrInsertDayName($conn);
            $trip->insertHaveDay($conn, $tripId, $dayNameId);
            $trip->insertDayContent($conn, $dayNameId);
        }
    } else {
        echo "Erreur lors de l'insertion de la région ou du secteur pour la planète " . $data['Name'] . "<br>";
    }
}
?>
