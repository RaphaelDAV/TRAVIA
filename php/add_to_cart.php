<?php

session_start();

global $pdo;
include '../php/pdo.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userId = 1;
        $unitPrice = $_POST['unit_price'];
        $shipId = $_POST['id_ship'];
        $departure_planet = $_POST['departure_planet'];
        $arrival_planet = $_POST['arrival_planet'];
        $date_added = date('Y-m-d H:i:s');

        $query = "INSERT INTO travia_ticket (id_user, unit_price, id_ship, departure_planet, arrival_planet, date_added) 
                  VALUES (:id_user, :unit_price, :id_ship, :departure_planet, :arrival_planet, :date_added)";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_user', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':unit_price', $unitPrice, PDO::PARAM_STR);
        $stmt->bindParam(':id_ship', $shipId, PDO::PARAM_INT);
        $stmt->bindParam(':departure_planet', $departure_planet, PDO::PARAM_INT);
        $stmt->bindParam(':arrival_planet', $arrival_planet, PDO::PARAM_INT);
        $stmt->bindParam(':date_added', $date_added, PDO::PARAM_STR);

        if ($stmt->execute()) {

            //Add log add to cart
            include 'create_log.php';
            $id_ticket = $pdo->lastInsertId();
            logCart($pdo, 1, $id_ticket,1);


            header('Location: ../src/map.php');
            exit();
        } else {
            echo "<script>alert('Error while adding to cart');</script>";
        }
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
