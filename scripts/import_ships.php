<?php
global $conn;
require 'connexion.php';
require '../class/Ship.php';

// Clear existing data
$conn->query("DELETE FROM travia_ship");
$conn->query("DELETE FROM travia_camp");

// Load JSON file
$jsonData = file_get_contents('../assets/data/ships.json');
$shipsArray = json_decode($jsonData, true);

// Insert new ships
foreach ($shipsArray as $shipData) {
    $ship = new Ship($shipData['id'], $shipData['name'], $shipData['camp'], $shipData['speed_kmh'], $shipData['capacity']);
    $ship->saveToDatabase($conn);
}

echo "Data import completed successfully.";
?>
