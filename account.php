<?php

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit;
}

include_once(__DIR__ . "/db.inc.php");
include_once(__DIR__ . "/classes/order.php");

$orderClass = new Order();
$orders = $orderClass->getByUserId($conn, (int)$_SESSION["user_id"]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Volleybal Webshop</title>
</head>

<body>
    <?php include_once(__DIR__ . "/nav.inc.php"); ?>
    <main>
        <section id="account">
            <div class="container">
                <h2>Mijn account</h2>

                <div class="account-info">
                    <p><strong>Welkom</strong> <?php echo htmlspecialchars($_SESSION["first_name"] . " " . $_SESSION["last_name"]); ?></p>
                    <p>
                        <strong>Saldo:</strong>
                        <?php echo htmlspecialchars($_SESSION["currency"]); ?> Munten
                    </p>
                </div>

                <div class="account-links">
                    <a href="cart.php" class="button">Winkelmandje</a>
                    <a href="change-password.php" class="button button-outline">Wachtwoord wijzigen</a>
                    <a href="logout.php" class="button button-outline">Uitloggen</a>
                </div>

                <div class="account-orders">
                    <h3>Mijn bestellingen</h3>

                    <?php if (count($orders) === 0): ?>
                        <p>Je hebt nog geen bestellingen.</p>
                    <?php else: ?>
                        <?php foreach ($orders as $order): ?>
                            <div class="order-card">
                                <p>
                                    <strong>Bestelling #<?php echo (int)$order["id"]; ?></strong><br>
                                    Datum: <?php echo htmlspecialchars($order["created_at"]); ?><br>
                                    Totaal: €<?php echo number_format((float)$order["total_price"], 2, ",", "."); ?>
                                </p>

                                <?php
                                $items = $orderClass->getItemsByOrderId($conn, (int)$order["id"]);
                                ?>

                                <?php if (count($items) > 0): ?>
                                    <ul style="margin: 10px 0 0 15px;">
                                        <?php foreach ($items as $item): ?>
                                            <li>
                                                <?php if (!empty($item["image"])): ?>
                                                    <img src="<?php echo htmlspecialchars($item["image"]); ?>" alt="">
                                                <?php else: ?>
                                                    <img src="https://placehold.co/60x60" alt="">
                                                <?php endif; ?>

                                                <div>
                                                    <strong><?php echo htmlspecialchars($item["product_name"]); ?></strong><br>
                                                    <?php echo (int)$item["quantity"]; ?>x —
                                                    €<?php echo number_format((float)$item["price_each"], 2, ",", "."); ?>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

            </div>
        </section>
    </main>

    <?php include_once(__DIR__ . "/footer.inc.php"); ?>
</body>

</html>