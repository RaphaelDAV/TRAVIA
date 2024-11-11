<?php
$servername = 'localhost';
$username = 'traviauser';
$password = '0mMitM!E7VmJo%6S';
$dbname = 'traviauser';

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['id_ticket']) && !empty($_POST['id_ticket'])) {
            $id_ticket = $_POST['id_ticket'];

            $query = "DELETE FROM travia_ticket WHERE id_ticket = :id_ticket";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id_ticket', $id_ticket, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->execute()) {
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
