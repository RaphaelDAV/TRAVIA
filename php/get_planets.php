<?php

require 'connexion.php';
session_start();

//Query to get planets
$sql = "SELECT name FROM travia_planet";
$result = $conn->query($sql);

$planets = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $planets[] = $row['name'];
    }
}

//Return
header('Content-Type: application/json');
echo json_encode($planets);

$conn->close();

?>