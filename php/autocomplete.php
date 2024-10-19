<?php
// Database connection parameters
$servername = 'localhost';
$username = 'traviauser';
$password = '0mMitM!E7VmJo%6S';
$dbname = 'traviauser';

try {
    // Create a PDO connection
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the search term from the query string
    $term = isset($_GET['term']) ? $_GET['term'] : '';

    // Prepare the SQL statement
    $sql = "SELECT name FROM travia_planet WHERE name LIKE :term";
    $stmt = $pdo->prepare($sql);

    // Bind the parameter
    $searchTerm = "%$term%";
    $stmt->bindParam(':term', $searchTerm, PDO::PARAM_STR);

    // Execute the statement
    $stmt->execute();

    // Fetch results and store in an array
    $suggestions = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $suggestions[] = $row['name'];
    }

    // Return the suggestions as JSON
    header('Content-Type: application/json');
    echo json_encode($suggestions);
} catch (PDOException $e) {
    // Handle connection error
    echo json_encode(['error' => $e->getMessage()]);
}
?>
