<?php

class Sector
{
    public function getOrInsertSector($conn, $sectorName) {
        $stmt = $conn->prepare("SELECT id_sector FROM travia_sector WHERE sector = :sectorName");
        $stmt->bindParam(':sectorName', $sectorName, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['id_sector'];
        } else {
            $query_insert_sector = "INSERT INTO travia_sector (sector) VALUES (:sectorName)";
            $insert_stmt = $conn->prepare($query_insert_sector);
            $insert_stmt->bindParam(':sectorName', $sectorName, PDO::PARAM_STR);

            if ($insert_stmt->execute()) {
                return $conn->lastInsertId();
            } else {
                return null;
            }
        }
    }
}

?>
