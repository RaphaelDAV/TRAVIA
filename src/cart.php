<?php
session_start();
$servername = 'localhost';
$username = 'traviauser';
$password = '0mMitM!E7VmJo%6S';
$dbname = 'traviauser';

// Constants
define('LIGHT_SPEED', 1080000000); // Speed of light in km/h
define('COST_PER_TRILLION_KM', 100); // Cost per trillion km

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $query = "SELECT t.id_ticket, t.unit_price, t.id_ship, t.departure_planet, t.arrival_planet, s.name AS ship_name, dp.name AS departure_name, ap.name AS arrival_name, s.id_camp, s.speed_kmh, s.capacity         
        FROM travia_ticket t
        JOIN travia_ship s ON t.id_ship = s.id_ship
        JOIN travia_planet dp ON t.departure_planet = dp.id_planet
        JOIN travia_planet ap ON t.arrival_planet = ap.id_planet
        WHERE t.id_user = :user_id;
        ";

    $stmt = $pdo->prepare($query);
    $stmt->execute(['user_id' => 1]);

    $ticketInfos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalItems = 0;
    $totalPrice = 0;
    foreach ($ticketInfos as $item) {
        $totalItems += 1;
        $totalPrice += $item['unit_price'];
    }



} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/header_footer.css" />
    <link rel="stylesheet" type="text/css" href="../css/cart.css" />
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/star-wars" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <title>CART</title>
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


    <!--_______________________________ CART _______________________________-->
    <section class="cart-section">
        <section class="left-cart">
            <div class="title-cart">
                <div class="left-flex1">
                    <div class="title-cart">
                        <h1>Shopping Bag</h1>
                        <h2><b><?php echo $totalItems; ?> items</b> in your bag</h2>
                    </div>
                    <h2 id="price"><b>Price</b></h2>
                    <h2 id="quality"><b>Quality</b></h2>
                    <h2 id="total-price"><b>Total Price</b></h2>
                    <div id="space"></div>
                </div>

            </div>

            <div class="content-cart">
                <?php if (!empty($ticketInfos)): ?>
                    <?php foreach ($ticketInfos as $ticket): ?>
                    <div class="flex-ticket">
                        <div class="ticket-container">
                            <div class="ticket">
                                <div class="ticket-flex1">
                                    <?php
                                    $camp_id = htmlspecialchars($ticket['id_camp']);

                                    $imagePath = "../assets/default_image.png";

                                    switch ($camp_id) {
                                        case 1:
                                            $imagePath = "../assets/map/smugglers.png";
                                            break;
                                        case 2:
                                            $imagePath = "../assets/map/empire.png";
                                            break;
                                        case 3:
                                            $imagePath = "../assets/map/rebels.png";
                                            break;
                                        default:
                                            $imagePath = "../assets/map/smugglers.png";
                                            break;
                                    }
                                    ?>

                                    <img src="<?php echo $imagePath; ?>" alt="Image du camp" ">
                                    <div class="credits">
                                        <p><?php echo $ticket['unit_price'] ?></p>
                                        <img src="../assets/map/credits.png" alt="credits">
                                    </div>
                                </div>
                                <div class="ticket-flex2">

                                    <img src="../assets/map/<?php echo htmlspecialchars($ticket['ship_name']); ?>.png">
                                    <p>Tickets for the <br>Planetary <br>Trips</p>
                                </div>
                                <div class="ticket-flex3">
                                    <div class="ticket-flex4">
                                        <p>The spaceship name is:</p>
                                        <h2><?php echo htmlspecialchars($ticket['ship_name']); ?></h2>
                                    </div>
                                    <div class="ticket-flex5">
                                        <h3>Informations</h3>
                                        <p><?php echo htmlspecialchars($ticket['speed_kmh']); ?> km/h</p>
                                        <p><strong>Capacity:</strong> <?php echo htmlspecialchars($ticket['capacity']); ?></p>
                                    </div>


                                </div>

                                <div>
                                    <form class="form_cart" action="../php/delete_ticket.php" method="POST">
                                        <input type="hidden" name="id_ticket" value="<?php echo $ticket['id_ticket']; ?>">
                                        <button class="cart-button" onclick="deleteToCart()" type="submit"></button>
                                    </form>
                                    <script>
                                        function deleteToCart() {
                                            alert("Le ticket a été supprimé du panier !");
                                        }
                                    </script>
                                </div>
                            </div>
                            <div class="root">
                                <?php echo htmlspecialchars($ticket['departure_name']); ?> ➔ <?php echo htmlspecialchars($ticket['arrival_name']); ?>
                            </div>
                        </div>
                        <div class="ticket-price"><span class="unit-price"><?php echo $ticket['unit_price']; ?></span> Credits</div>

                        <div class="quantity-control">
                            <button class="quantity-btn" onclick="updateQuantity(this, -1)">-</button>
                            <input type="text" class="quantity-input" value="1" readonly>
                            <button class="quantity-btn" onclick="updateQuantity(this, 1)">+</button>
                        </div>

                        <div class="ticket-price-total"><span class="total-price"><?php echo $ticket['unit_price'] ?></span> Credits</div>
                        <div id="space"></div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucun ticket trouvé.</p>
                <?php endif; ?>
            </div>
            <script src="../script/cart.js"></script>


        </section>
        <section class="right-cart">
            <h1>ORDER SUMMARY</h1>
            <hr>
            <h2>Coupon Code</h2>
            <p>Use a promo code to enjoy exclusive discounts on your order. Enter the code in the field below and click 'Apply' to see if you're eligible for a special offer!</p>
            <input type="text" id="" placeholder="Coupon Code">
            <button type="button" id="submitButtonCode">Apply</button>
            <hr>
            <div class="total">
                <div class="total-flex">
                    <h2>Cart Total</h2>
                    <span id="cart-total"><?php echo $totalPrice; ?></span>
                </div>
                <div class="total-flex">
                    <p>Cart Subtotal</p>
                    <span id="cart-subtotal"><?php echo $totalPrice; ?></span>
                </div>
                <div class="total-flex">
                    <p>Discount</p>
                    <span id="discount">-4.00</span>
                </div>
                <div class="total-flex">
                    <p><b>Cart Total</b></p>
                    <span id="final-cart-total"><?php echo $totalPrice - 4.00; ?></span>
                </div>
                <button type="button" id="submitButton">Apply</button>
            </div>
        </section>

    </section>
</body>
</html>