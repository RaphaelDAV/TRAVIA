<?php

class Sun
{
    public function getOrInsertSun($conn, $sunName) {
        $stmt = $conn->prepare("SELECT id_sun FROM travia_sun WHERE namesun = :sunName");
        $stmt->bindParam(':sunName', $sunName, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['id_sun'];
        } else {
            $query_insert_sun = "INSERT INTO travia_sun (namesun) VALUES (:sunName)";
            $insert_stmt = $conn->prepare($query_insert_sun);
            $insert_stmt->bindParam(':sunName', $sunName, PDO::PARAM_STR);

            if ($insert_stmt->execute()) {
                return $conn->lastInsertId();
            } else {
                return null;
            }
        }
    }
}

?>
