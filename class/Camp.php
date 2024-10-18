<?php

class Camp
{
    public function getOrInsertCamp($conn, $campName) {
        $stmt = $conn->prepare("SELECT id_camp FROM travia_camp WHERE camp = :campName");
        $stmt->bindParam(':campName', $campName, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['id_camp'];
        } else {
            $query_insert_camp = "INSERT INTO travia_camp (camp) VALUES (:campName)";
            $insert_stmt = $conn->prepare($query_insert_camp);
            $insert_stmt->bindParam(':campName', $campName, PDO::PARAM_STR);

            if ($insert_stmt->execute()) {
                return $conn->lastInsertId();
            } else {
                return null;
            }
        }
    }
}

?>
