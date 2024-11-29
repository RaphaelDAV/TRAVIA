<?php
function logSearch($pdo, $id_user, $id_departure_planet, $id_arrival_planet) {
    $query = "INSERT INTO travia_log_search (id_user, search_date_time, id_departure_planet, id_arrival_planet) 
              VALUES (:id_user, NOW(), :id_departure_planet, :id_arrival_planet)";
    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':id_departure_planet', $id_departure_planet, PDO::PARAM_INT);
        $stmt->bindParam(':id_arrival_planet', $id_arrival_planet, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        echo "Error logging search: " . $e->getMessage();
        return false;
    }
}

function logCart($pdo, $id_user, $id_ticket,$state) {
    $query = "INSERT INTO travia_log_cart (id_user, search_date_time, id_ticket,state) 
              VALUES (:id_user, NOW(), :id_ticket,:state)";
    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':id_ticket', $id_ticket, PDO::PARAM_INT);
        $stmt->bindParam(':state', $state, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        echo "Error logging cart action: " . $e->getMessage();
        return false;
    }
}

?>
