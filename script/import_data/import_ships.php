<?php
global $pdo;
require '../../php/pdo.php';
require '../../class/Ship.php';

// Clear existing data
$pdo->exec("DELETE FROM travia_day_content");
$pdo->exec("DELETE FROM Have_day");
$pdo->exec("DELETE FROM travia_trips");
$pdo->exec("DELETE FROM travia_ship");
$pdo->exec("DELETE FROM travia_camp");

// Load JSON file
$jsonData = file_get_contents('../../assets/data/ships.json');
$shipsArray = json_decode($jsonData, true);

// Insert new ships
foreach ($shipsArray as $shipData) {
    $ship = new Ship($shipData['id'], $shipData['name'], $shipData['camp'], $shipData['speed_kmh'], $shipData['capacity']);
    $ship->saveToDatabase($pdo);
}

echo "Data import completed successfully.";
?>
