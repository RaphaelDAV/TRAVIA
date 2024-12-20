<?php
global $pdo;
include '../php/pdo.php';

try {
    $query = "SELECT t.id_ticket, t.unit_price, t.id_ship, t.departure_planet, t.arrival_planet, s.name AS ship_name, dp.name AS departure_name, ap.name AS arrival_name, t.date_added
              FROM travia_ticket t
              JOIN travia_ship s ON t.id_ship = s.id_ship
              JOIN travia_planet dp ON t.departure_planet = dp.id_planet
              JOIN travia_planet ap ON t.arrival_planet = ap.id_planet
              WHERE t.id_user = :user_id";

    $stmt = $pdo->prepare($query);
    $stmt->execute(['user_id' => 1]);

    $shipCosts = $stmt->fetchAll(PDO::FETCH_ASSOC);



} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
}
?>

