<?php
// get_planets.php
$servername = 'localhost';
$username = 'traviauser';
$password = '0mMitM!E7VmJo%6S';
$dbname = 'traviauser';

try {
    // Créer la connexion
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtenez le terme de recherche
    $searchTerm = isset($_GET['term']) ? $_GET['term'] : '';

    // Préparez et exécutez la requête
    $stmt = $conn->prepare("SELECT name FROM travia_planet WHERE name LIKE CONCAT('%', :term, '%')");
    $stmt->bindParam(':term', $searchTerm, PDO::PARAM_STR);
    $stmt->execute();

    // Récupérer les résultats
    $planets = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Renvoyer les résultats au format JSON
    echo json_encode($planets);
} catch(PDOException $e) {
    // Gérer l'erreur
    echo json_encode(["error" => $e->getMessage()]);
}
?>
