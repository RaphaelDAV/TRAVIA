<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $departurePlanet = htmlspecialchars($_POST['departurePlanet']);
    $arrivalPlanet = htmlspecialchars($_POST['arrivalPlanet']);
    $date = htmlspecialchars($_POST['date']);
    $travelers = htmlspecialchars($_POST['travelers']);

    $_SESSION['departurePlanet'] = $departurePlanet;
    $_SESSION['arrivalPlanet'] = $arrivalPlanet;
    $_SESSION['date'] = $date;
    $_SESSION['travelers'] = $travelers;


    header("Location: ../src/map.php");
    exit();
} else {
    header("Location: index.html");
    exit();
}
?>
