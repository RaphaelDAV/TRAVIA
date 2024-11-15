<?php
// Paramètres de connexion à la base de données
$servername = 'localhost';
$username = 'traviauser';
$password = '0mMitM!E7VmJo%6S';
$dbname = 'traviauser';

try {
    // Create a PDO connection
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get order parameter from URL, default to 'name'
    $order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'name';
    $order_direction = isset($_GET['order_direction']) && $_GET['order_direction'] == 'DESC' ? 'DESC' : 'ASC';

    // Validate the order_by parameter
    $valid_order_by = ['name', 'distance', 'gravity', 'diameter', 'id_planet'];
    if (!in_array($order_by, $valid_order_by)) {
        $order_by = 'name';
    }

    $stmt = $pdo->prepare("
        SELECT id_planet, image, name, coord, distance, gravity, diameter
        FROM travia_planet
        ORDER BY $order_by $order_direction
        LIMIT :limit OFFSET :offset
    ");
    $planets_per_page = 40;
    $page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $planets_per_page;

    $stmt->bindValue(':limit', $planets_per_page, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $planets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $total_planets_stmt = $pdo->query("SELECT COUNT(*) FROM travia_planet");
    $total_planets = $total_planets_stmt->fetchColumn();
    $total_pages = ceil($total_planets / $planets_per_page);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planets</title>
    <link rel="stylesheet" href="../css/planets.css">
    <link rel="stylesheet" type="text/css" href="../css/header_footer.css" />

    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/star-wars" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<div id="header-container"></div>
<script>
    fetch('header.html')
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
        <a href="?order_by=name&order_direction=<?php echo ($order_direction == 'DESC' ? 'ASC' : 'DESC'); ?>" class="sort-button <?php echo ($order_by == 'name' ? 'active' : ''); ?>">Name <?php echo ($order_direction == 'ASC' ? '↓' : '↑'); ?></a>
        <a href="?order_by=distance&order_direction=<?php echo ($order_direction == 'DESC' ? 'ASC' : 'DESC'); ?>" class="sort-button <?php echo ($order_by == 'distance' ? 'active' : ''); ?>">Distance <?php echo ($order_direction == 'ASC' ? '↓' : '↑'); ?></a>
        <a href="?order_by=gravity&order_direction=<?php echo ($order_direction == 'DESC' ? 'ASC' : 'DESC'); ?>" class="sort-button <?php echo ($order_by == 'gravity' ? 'active' : ''); ?>">Gravity <?php echo ($order_direction == 'ASC' ? '↓' : '↑'); ?></a>
        <a href="?order_by=diameter&order_direction=<?php echo ($order_direction == 'DESC' ? 'ASC' : 'DESC'); ?>" class="sort-button <?php echo ($order_by == 'diameter' ? 'active' : ''); ?>">Diameter <?php echo ($order_direction == 'ASC' ? '↓' : '↑'); ?></a>
    </div>

    <div class="gallery">
        <?php if (count($planets) > 0): ?>
            <?php foreach ($planets as $planet): ?>
                <div class="card" onclick="openLightbox(<?php echo $planet['id_planet']; ?>)">
                    <div class="image-container">
                        <?php
                        $imageName = $planet['image'];
                        $md5Hash = md5($imageName);
                        $defaultImage = '../assets/map/unknow_planet.png';
                        $imagePath = $defaultImage;

                        if (!empty($imageName)) {
                            $firstChar = strtolower(substr($md5Hash, 0, 1));
                            $firstTwoChars = strtolower(substr($md5Hash, 0, 2));
                            $imagePath = "https://static.wikia.nocookie.net/starwars/images/{$firstChar}/{$firstTwoChars}/{$imageName}";

                        }
                        ?>
                        <img id= "planet-image" src="<?php echo $imagePath ?>" alt="Planet Image">
                    </div>
                    <div class="card-info">
                        <div class="little-flex2">
                            <p class="planet-name"><?php echo htmlspecialchars($planet['name']); ?></p>
                            <div class="databank">
                                <div class="little-flex">
                                    <img id= "data" src="../assets/planets/data.png" alt="">
                                    <p>DATABANK</p>
                                </div>
                            </div>
                        </div>
                        <img id= "lines" src="../assets/ships/lines.png" alt="">
                    </div>
                </div>

                <div id="lightbox-<?php echo $planet['id_planet']; ?>" class="lightbox">
                    <div class="lightbox-content">
                        <span class="close" onclick="closeLightbox(<?php echo $planet['id_planet']; ?>)">&times;</span>
                        <h2><?php echo htmlspecialchars($planet['name']); ?></h2>
                        <p><strong>Coordinates:</strong> <?php echo htmlspecialchars($planet['coord']); ?></p>
                        <p><strong>Distance:</strong> <?php echo htmlspecialchars($planet['distance']); ?> AU</p>
                        <p><strong>Gravity:</strong> <?php echo htmlspecialchars($planet['gravity']); ?> g</p>
                        <p><strong>Diameter:</strong> <?php echo htmlspecialchars($planet['diameter']); ?> km</p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No planets found.</p>
        <?php endif; ?>
    </div>

    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>&order_by=<?php echo $order_by; ?>&order_direction=<?php echo $order_direction; ?>" class="prev">Previous</a>
        <?php endif; ?>

        <?php
        $range = 2;
        $start = max(1, $page - $range);
        $end = min($total_pages, $page + $range);

        if ($start > 1) {
            echo '<a href="?page=1&order_by=' . $order_by . '&order_direction=' . $order_direction . '">1</a>';
            if ($start > 2) {
                echo '<span>...</span>';
            }
        }

        for ($i = $start; $i <= $end; $i++) {
            echo '<a href="?page=' . $i . '&order_by=' . $order_by . '&order_direction=' . $order_direction . '" class="' . ($i == $page ? 'active' : '') . '">' . $i . '</a>';
        }

        if ($end < $total_pages) {
            if ($end < $total_pages - 1) {
                echo '<span>...</span>';
            }
            echo '<a href="?page=' . $total_pages . '&order_by=' . $order_by . '&order_direction=' . $order_direction . '">' . $total_pages . '</a>';
        }
        ?>

        <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $page + 1; ?>&order_by=<?php echo $order_by; ?>&order_direction=<?php echo $order_direction; ?>" class="next">Next</a>
        <?php endif; ?>
    </div>


</section>



<script>
    function openLightbox(id) {
        var lightbox = document.getElementById("lightbox-" + id);
        if (lightbox) {
            lightbox.style.display = "block";
        }
    }

    function closeLightbox(id) {
        var lightbox = document.getElementById("lightbox-" + id);
        if (lightbox) {
            lightbox.style.display = "none";
        }
    }

    window.onclick = function(event) {
        var lightboxes = document.getElementsByClassName("lightbox");
        for (var i = 0; i < lightboxes.length; i++) {
            if (event.target === lightboxes[i]) {
                lightboxes[i].style.display = "none";
            }
        }
    }
</script>

<!-- Include footer with JS-->
<div id="footer-container"></div>
<script>
    window.onload = function() {
        fetch('footer.html')
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

</body>
</html>
