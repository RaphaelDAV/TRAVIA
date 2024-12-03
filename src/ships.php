<?php
global $pdo;
include '../php/pdo.php';

try {

    // Get order parameter from URL, default to 'name'
    $order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'id_ship';
    $order_direction = isset($_GET['order_direction']) && $_GET['order_direction'] == 'DESC' ? 'DESC' : 'ASC';


    // Validate the order_by parameter
    $valid_order_by = ['capacity', 'speed_kmh', 'id_camp', 'name', 'id_ship'];
    if (!in_array($order_by, $valid_order_by)) {
        $order_by = 'id_ship';
    }

    // Get ships
    $stmt = "SELECT ts.id_ship, ts.name, ts.speed_kmh, ts.capacity, ts.id_camp, tc.camp
         FROM travia_ship ts
         LEFT JOIN travia_camp tc ON ts.id_camp = tc.id_camp
         ORDER BY $order_by $order_direction";
    $stmt = $pdo->prepare($stmt);
    $stmt->execute();
    $ships = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ships</title>
    <link rel="stylesheet" href="../css/ships.css">
    <link rel="stylesheet" href="../css/header_footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/star-wars" rel="stylesheet">
</head>
<body>
<!-- Include header with JS-->

<div id="header-container"></div>
<script src="../script/nav_bar.js" defer></script>
<script>
    fetch('header.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('header-container').innerHTML = data;
        })
        .catch(error => {
            console.error('Erreur lors du chargement du header:', error);
        });
</script>

<section class="container">
    <div class="sort-options">
        <p>Order by:</p>
        <a href="./src/ships.php?order_by=id_ship&order_direction=<?php echo ($order_direction == 'DESC' ? 'ASC' : 'DESC'); ?>" class="sort-button <?php echo ($order_by == 'id_ship' ? 'active' : ''); ?>">ID <?php echo ($order_direction == 'ASC' ? '↓' : '↑'); ?></a>
        <a href="./src/ships.php?order_by=name&order_direction=<?php echo ($order_direction == 'DESC' ? 'ASC' : 'DESC'); ?>" class="sort-button <?php echo ($order_by == 'name' ? 'active' : ''); ?>">Name <?php echo ($order_direction == 'ASC' ? '↓' : '↑'); ?></a>
        <a href="./src/ships.php?order_by=capacity&order_direction=<?php echo ($order_direction == 'DESC' ? 'ASC' : 'DESC'); ?>" class="sort-button <?php echo ($order_by == 'capacity' ? 'active' : ''); ?>">Capacity <?php echo ($order_direction == 'ASC' ? '↓' : '↑'); ?></a>
        <a href="./src/ships.php?order_by=speed_kmh&order_direction=<?php echo ($order_direction == 'DESC' ? 'ASC' : 'DESC'); ?>" class="sort-button <?php echo ($order_by == 'speed_kmh' ? 'active' : ''); ?>">Speed <?php echo ($order_direction == 'ASC' ? '↓' : '↑'); ?></a>
        <a href="./src/ships.php?order_by=id_camp&order_direction=<?php echo ($order_direction == 'DESC' ? 'ASC' : 'DESC'); ?>" class="sort-button <?php echo ($order_by == 'id_camp' ? 'active' : ''); ?>">Camp <?php echo ($order_direction == 'ASC' ? '↓' : '↑'); ?></a>
    </div>

    <div class="gallery">
        <?php if (count($ships) > 0): ?>
            <?php foreach ($ships as $row): ?>
                <div class="card" onclick="openLightbox(<?php echo $row['id_ship']; ?>)">

                    <img id= "ship-image" src="../assets/ships/<?php echo htmlspecialchars($row['name']); ?>.png" alt="Ship Image">
                    <div class="card-info">
                        <div class="little-flex2">
                            <p class="ship-name"><?php echo htmlspecialchars($row['name']); ?></p>
                            <div class="databank">
                                <div class="little-flex">
                                    <img src="../assets/ships/data.png" alt="">
                                    <p>DATABANK</p>
                                </div>
                            </div>
                        </div>
                        <img id= "lines" src="../assets/ships/lines.png" alt="">
                    </div>
                </div>

                <div id="lightbox-<?php echo $row['id_ship']; ?>" class="lightbox">
                    <div class="lightbox-content">
                        <span class="close" onclick="closeLightbox(<?php echo $row['id_ship']; ?>)">&times;</span>
                        <h2><?php echo htmlspecialchars($row['name']); ?></h2>
                        <p><strong>Speed:</strong> <?php echo htmlspecialchars($row['speed_kmh']); ?> km/h</p>
                        <p><strong>Capacity:</strong> <?php echo htmlspecialchars($row['capacity']); ?></p>
                        <p><strong>Camp ID:</strong> <?php echo htmlspecialchars($row['id_camp']); ?></p>
                        <p><strong>Camp Name:</strong> <?php echo htmlspecialchars($row['camp']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No ships found.</p>
        <?php endif; ?>
    </div>
</section>



<!-- Include footer with JS-->
<div id="footer-container"></div>
<script>
    window.onload = function() {
        fetch('../src/footer.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('footer-container').innerHTML = data;

                const auLink = document.getElementById('au');
                const enLink = document.getElementById('en');

                if (auLink && enLink) {
                    auLink.addEventListener('click', function(event) {
                        event.preventDefault();
                        document.documentElement.classList.add('au-font');
                        console.log("Police Aurebesh appliquée");
                    });

                    enLink.addEventListener('click', function(event) {
                        event.preventDefault();
                        document.documentElement.classList.remove('au-font');
                        console.log("Police Aurebesh retirée");
                    });
                }
            })
            .catch(error => {
                console.error('Error while loading footer:', error);
            });
    }
</script>

<script>
    // Open lightbox
    function openLightbox(id) {
        var lightbox = document.getElementById("lightbox-" + id);
        if (lightbox) {
            lightbox.style.display = "block";
        }
    }

    // Close lightbox
    function closeLightbox(id) {
        var lightbox = document.getElementById("lightbox-" + id);
        if (lightbox) {
            lightbox.style.display = "none";
        }
    }

    // When outside click
    window.onclick = function(event) {
        var lightboxes = document.getElementsByClassName("lightbox");
        for (var i = 0; i < lightboxes.length; i++) {
            if (event.target === lightboxes[i]) {
                lightboxes[i].style.display = "none";
            }
        }
    }
</script>
</body>
</html>

