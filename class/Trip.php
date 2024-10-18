<?php

class Trip
{
    private $tripDetails;
    private $dayName;

    public function __construct($dayName, $tripDetails) {
        $this->dayName = $dayName;
        $this->tripDetails = $tripDetails;
    }

    public function insertTrip($conn, $planetId) {
        $stmt = $conn->prepare("INSERT INTO travia_trips (id_planet) VALUES (:id_planet)");
        $stmt->bindParam(':id_planet', $planetId, PDO::PARAM_INT);

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

    public function insertHaveDay($conn, $tripId, $dayNameId) {
        $stmt = $conn->prepare("INSERT INTO Have_day (id_trips, id_day_name) VALUES (:id_trips, :id_day_name)");
        $stmt->bindParam(':id_trips', $tripId, PDO::PARAM_INT);
        $stmt->bindParam(':id_day_name', $dayNameId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function insertDayContent($conn, $dayNameId) {
        foreach ($this->tripDetails as $trip) {
            foreach ($trip['departure_time'] as $departureTime) {
                $shipId = $trip['ship_id'][0];

                $stmt = $conn->prepare("INSERT INTO travia_day_content (departure_time, id_ship, id_day_name) VALUES (:departure_time, :id_ship, :id_day_name)");
                $stmt->bindParam(':departure_time', $departureTime, PDO::PARAM_STR);
                $stmt->bindParam(':id_ship', $shipId, PDO::PARAM_INT);
                $stmt->bindParam(':id_day_name', $dayNameId, PDO::PARAM_INT);
                $stmt->execute();
            }
        }
    }
}

?>
