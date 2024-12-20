<?php
global $pdo;
include '../php/pdo.php';
try {
    $stmt = $pdo->query('SELECT 
        travia_planet.name, 
        travia_planet.x, 
        travia_planet.y, 
        travia_planet.subgridx, 
        travia_planet.subgridy, 
        travia_region.region, 
        travia_planet.diameter 
    FROM 
        travia_planet 
    JOIN 
        travia_region 
    ON 
    travia_planet.id_region = travia_region.id_region;');
    $planets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($planets);
} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
}
?>

