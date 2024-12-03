<?php

class Trip
{
    private $dayName;
    private $departureTime;
    private $planetId;
    private $idShip;

    public function __construct($dayName, $departureTime, $planetId, $idShip) {
        $this->dayName = $dayName;
        $this->departureTime = $departureTime;
        $this->planetId = $planetId;
        $this->idShip = $idShip;
    }

    public function insertTrip($conn, $departureTime, $planetId, $idShip, $id_day_name) {
        $stmt = $conn->prepare("INSERT INTO travia_trips (departure_time, id_planet, id_ship, id_day_name) VALUES (:departure_time, :id_planet, :id_ship, :id_day_name)");

        $stmt->bindParam(':departure_time', $departureTime, PDO::PARAM_STR);
        $stmt->bindParam(':id_planet', $planetId, PDO::PARAM_INT);
        $stmt->bindParam(':id_ship', $idShip, PDO::PARAM_INT);
        $stmt->bindParam(':id_day_name', $id_day_name, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $conn->lastInsertId();
        } else {
            return null;
        }
    }


    public function getOrInsertDayName($conn) {
        $stmt = $conn->prepare("SELECT id_day_name FROM travia_day_name WHERE day_name = :day_name");
        $stmt->bindParam(':day_name', $this->dayName, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['id_day_name'];
        } else {
            $insert_stmt = $conn->prepare("INSERT INTO travia_day_name (day_name) VALUES (:day_name)");
            $insert_stmt->bindParam(':day_name', $this->dayName, PDO::PARAM_STR);

            if ($insert_stmt->execute()) {
                return $conn->lastInsertId();
            } else {
                return null;
            }
        }
    }
}

?>
