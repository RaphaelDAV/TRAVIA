<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $departurePlanet = htmlspecialchars($_POST['departurePlanet']);
    $arrivalPlanet = htmlspecialchars($_POST['arrivalPlanet']);
    $date = htmlspecialchars($_POST['date']);
    $travelers = htmlspecialchars($_POST['travelers']);

    // Database connection parameters
    $servername = 'localhost';
    $username = 'traviauser';
    $password = '0mMitM!E7VmJo%6S';
    $dbname = 'traviauser';

    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Get information about departure planet
        $stmt = $pdo->prepare("SELECT * FROM travia_planet WHERE name = :planet");
        $stmt->execute(['planet' => $departurePlanet]);
        $departurePlanetData = $stmt->fetch(PDO::FETCH_ASSOC);

        // Get information about arrival planet
        $stmt->execute(['planet' => $arrivalPlanet]);
        $arrivalPlanetData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($departurePlanetData && $arrivalPlanetData) {
            // Stocking information send with form
            $_SESSION['departurePlanet'] = $departurePlanet;
            $_SESSION['arrivalPlanet'] = $arrivalPlanet;
            $_SESSION['date'] = $date;
            $_SESSION['travelers'] = $travelers;

            // Stocking data information about the planets
            $_SESSION['departurePlanetData'] = $departurePlanetData;
            $_SESSION['arrivalPlanetData'] = $arrivalPlanetData;

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


