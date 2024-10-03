<?php

class Region
{
    public function getOrInsertRegion($conn, $regionName) {
        $regionName = $conn->real_escape_string($regionName);

        $stmt = $conn->prepare("SELECT id_region FROM travia_region WHERE region = ?");
        $stmt->bind_param("s", $regionName);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc()['id_region'];
        } else {
            $query_insert_region = "INSERT INTO travia_region (region) VALUES (?)";
            $insert_stmt = $conn->prepare($query_insert_region);
            $insert_stmt->bind_param("s", $regionName);

            if ($insert_stmt->execute() === TRUE) {
                return $conn->insert_id;
            } else {
                return null;
            }
        }
    }
}

?>
