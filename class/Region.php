<?php

class Region
{
    public function getOrInsertRegion($conn, $regionName) {
        $stmt = $conn->prepare("SELECT id_region FROM travia_region WHERE region = :regionName");
        $stmt->bindParam(':regionName', $regionName, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['id_region'];
        } else {
            $query_insert_region = "INSERT INTO travia_region (region) VALUES (:regionName)";
            $insert_stmt = $conn->prepare($query_insert_region);
            $insert_stmt->bindParam(':regionName', $regionName, PDO::PARAM_STR);

            if ($insert_stmt->execute()) {
                return $conn->lastInsertId();
            } else {
                return null;
            }
        }
    }
}

?>
