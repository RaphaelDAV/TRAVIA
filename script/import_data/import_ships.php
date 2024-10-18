<?php
global $conn;
require '../../php/connexion.php';
require '../../class/Ship.php';

// Clear existing data
$conn->exec("DELETE FROM travia_day_content");
$conn->exec("DELETE FROM Have_day");
$conn->exec("DELETE FROM travia_trips");
$conn->exec("DELETE FROM travia_ship");
$conn->exec("DELETE FROM travia_camp");

// Load JSON file
$jsonData = file_get_contents('../../assets/data/ships.json');
$shipsArray = json_decode($jsonData, true);

// Insert new ships
foreach ($shipsArray as $shipData) {
    $ship = new Ship($shipData['id'], $shipData['name'], $shipData['camp'], $shipData['speed_kmh'], $shipData['capacity']);
    $ship->saveToDatabase($conn);
}

echo "Data import completed successfully.";
?>
