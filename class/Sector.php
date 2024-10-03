<?php

class Sector
{
    public function getOrInsertSector($conn, $sectorName) {
        $sectorName = $conn->real_escape_string($sectorName);

        $stmt = $conn->prepare("SELECT id_sector FROM travia_sector WHERE sector = ?");
        $stmt->bind_param("s", $sectorName);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc()['id_sector'];
        } else {
            $query_insert_sector = "INSERT INTO travia_sector (sector) VALUES (?)";
            $insert_stmt = $conn->prepare($query_insert_sector);
            $insert_stmt->bind_param("s", $sectorName);

            if ($insert_stmt->execute() === TRUE) {
                return $conn->insert_id;
            } else {
                return null;
            }
        }
    }
}

?>
