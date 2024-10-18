<?php
require 'Camp.php';

class Ship
{
    private $id_ship;
    private $name;
    private $camp;
    private $speed_kmh;
    private $capacity;

    public function __construct($id_ship, $name, $camp, $speed_kmh, $capacity)
    {
        $this->id_ship = $id_ship;
        $this->name = $name;
        $this->camp = $camp;
        $this->speed_kmh = $speed_kmh;
        $this->capacity = $capacity;
    }

    public function saveToDatabase($conn) {
        $campObj = new Camp();
        $campId = $campObj->getOrInsertCamp($conn, $this->camp);

        if ($campId !== null) {
            $stmt = $conn->prepare("
                INSERT INTO travia_ship 
                (id_ship, name, speed_kmh, capacity, id_camp) 
                VALUES (:id_ship, :name, :speed_kmh, :capacity, :id_camp)
            ");

            $stmt->bindParam(':id_ship', $this->id_ship, PDO::PARAM_INT);
            $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindParam(':speed_kmh', $this->speed_kmh, PDO::PARAM_INT);
            $stmt->bindParam(':capacity', $this->capacity, PDO::PARAM_INT);
            $stmt->bindParam(':id_camp', $campId, PDO::PARAM_INT);

            $stmt->execute();
        }
    }
}

?>
