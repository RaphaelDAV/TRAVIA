<?php
global $pdo;
include '../php/pdo.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['id_ticket']) && !empty($_POST['id_ticket'])) {
            $id_ticket = $_POST['id_ticket'];

            $query = "UPDATE travia_ticket SET id_user = NULL WHERE id_ticket = :id_ticket";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id_ticket', $id_ticket, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->execute()) {

                //Add log add to cart
                include 'create_log.php';
                logCart($pdo, 1, $id_ticket,0);

                header('Location: ../src/cart.php');
                exit();
            } else {
                echo "<script>alert('Error while deleting ticket');</script>";
            }

        } else {
            echo "No ticket id.";
        }
    }
} catch (PDOException $e) {
    echo 'Error : ' . $e->getMessage();
}
?>
<?php
