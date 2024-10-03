<?php

global $conn;
require 'connexion.php';
session_start();

if (isset($_POST['submit'])) {
    if (!empty($_POST['start']) && !empty($_POST['end'])){
        $start = htmlspecialchars($_POST['start']);
        $end = htmlspecialchars($_POST['end']);

        $insertTravel = $conn->prepare('INSERT INTO travia.travia_journeys(departure,arrival) VALUES(?, ?)');
        $insertTravel->execute([$start, $end]);


        echo "Ville de départ: $start <br>";
        echo "Ville d'arrivée: $end";
    }else{
        echo "Entrez des noms de villes valides";
    }
} else {
    header('location: accueil.html');
    exit();
}
?>