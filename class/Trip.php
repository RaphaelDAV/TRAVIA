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
        $stmt = $conn->prepare("INSERT INTO travia_trips (id_planet) VALUES (?)");
        $stmt->bind_param("i", $planetId);

        if ($stmt->execute() === TRUE) {
            return $conn->insert_id;
        } else {
            return null;
        }
    }

    public function getOrInsertDayName($conn) {
        $stmt = $conn->prepare("SELECT id_day_name FROM travia_day_name WHERE day_name = ?");
        $stmt->bind_param("s", $this->dayName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc()['id_day_name'];
        } else {
            $query_insert_day_name = "INSERT INTO travia_day_name (day_name) VALUES (?)";
            $insert_stmt = $conn->prepare($query_insert_day_name);
            $insert_stmt->bind_param("s", $this->dayName);

            if ($insert_stmt->execute() === TRUE) {
                return $conn->insert_id;
            } else {
                return null;
            }
        }
    }

    public function insertHaveDay($conn, $tripId, $dayNameId) {
        $stmt = $conn->prepare("INSERT INTO Have_day (id_trips, id_day_name) VALUES (?, ?)");
        $stmt->bind_param("ii", $tripId, $dayNameId);
        $stmt->execute();
    }

    public function insertDayContent($conn, $dayNameId) {
        foreach ($this->tripDetails as $trip) {
            foreach ($trip['departure_time'] as $departureTime) {
                $shipId = $trip['ship_id'][0];

                $stmt = $conn->prepare("INSERT INTO travia_day_content (departure_time, id_ship, id_day_name) VALUES (?, ?, ?)");
                $stmt->bind_param("sii", $departureTime, $shipId, $dayNameId);
                $stmt->execute();
            }
        }
    }
}

?>
