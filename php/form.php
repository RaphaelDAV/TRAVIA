<?php
session_start();
global $pdo;
include '../php/pdo.php';
include '../class/Planet.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $departurePlanet = htmlspecialchars($_POST['departurePlanet']);
    $arrivalPlanet = htmlspecialchars($_POST['arrivalPlanet']);
    $date = htmlspecialchars($_POST['date']);
    $travelers = $_POST['travelers'] ?? null;


    try {
        // Get information about departure planet
        $stmt = $pdo->prepare("SELECT * FROM travia_planet WHERE name = :planet");
        $stmt->execute(['planet' => $departurePlanet]);
        $departurePlanetData = $stmt->fetch(PDO::FETCH_ASSOC);

        echo "<pre>";
        var_dump($departurePlanetData);
        echo "</pre>";

        // Get information about arrival planet
        $stmt2 = $pdo->prepare("SELECT * FROM travia_planet WHERE name = :planet");
        $stmt2->execute(['planet' => $arrivalPlanet]);
        $arrivalPlanetData = $stmt2->fetch(PDO::FETCH_ASSOC);

        echo "<pre>";
        var_dump($arrivalPlanetData);
        echo "</pre>";



        if ($departurePlanetData && $arrivalPlanetData) {
            // Stocking information send with form
            $_SESSION['departurePlanet'] = $departurePlanet;
            $_SESSION['arrivalPlanet'] = $arrivalPlanet;
            $_SESSION['date'] = $date;
            $_SESSION['travelers'] = $travelers;

            // Stocking data information about the planets
            $_SESSION['departurePlanetData'] = $departurePlanetData;
            $_SESSION['arrivalPlanetData'] = $arrivalPlanetData;

            //Create log of search
            include 'create_log.php';
            $departurePlanet = new Planet($departurePlanetData);
            $arrivalPlanet = new Planet($arrivalPlanetData);
            logSearch($pdo, 1, $departurePlanet->getIdPlanet(), $arrivalPlanet->getIdPlanet());

            //Go to map.php
            header("Location: ../src/map.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid planet name.";
            header("Location: ../index.html");
            exit();
        }
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
    }
} else {
    header("Location: ../index.html");
    exit();
}


