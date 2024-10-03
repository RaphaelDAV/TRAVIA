<?php

class Camp
{
    public function getOrInsertCamp($conn, $campName) {
        $campName = $conn->real_escape_string($campName);

        $stmt = $conn->prepare("SELECT id_camp FROM travia_camp WHERE camp = ?");
        $stmt->bind_param("s", $campName);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc()['id_camp'];
        } else {
            $query_insert_camp = "INSERT INTO travia_camp (camp) VALUES (?)";
            $insert_stmt = $conn->prepare($query_insert_camp);
            $insert_stmt->bind_param("s", $campName);

            if ($insert_stmt->execute() === TRUE) {
                return $conn->insert_id;
            } else {
                return null;
            }
        }
    }
}

?>

