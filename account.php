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

                <div class="account-actions">
                    <h3>Acties</h3>
                    <ul>
                        <li><a href="cart.php">Winkelmandje bekijken</a></li>
                        <li><a href="change-password.php">Wachtwoord wijzigen</a></li>
                        <li><a href="logout.php">Uitloggen</a></li>
                    </ul>
                </div>

                <div class="account-orders">
                    <h3>Mijn bestellingen</h3>

                    <?php if (count($orders) === 0): ?>
                        <p>Je hebt nog geen bestellingen.</p>
                    <?php else: ?>
                        <?php foreach ($orders as $order): ?>
                            <div class="order-card" style="margin-top:15px; padding:15px; border:1px solid #d8e1e8; border-radius:8px;">
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
                                            <li style="display:flex; gap:12px; align-items:center; margin-bottom:10px;">
                                                <?php if (!empty($item["image"])): ?>
                                                    <img src="<?php echo htmlspecialchars($item["image"]); ?>" alt=""
                                                        style="width:60px;height:60px;object-fit:cover;border-radius:6px;">
                                                <?php else: ?>
                                                    <img src="https://placehold.co/60x60" alt=""
                                                        style="width:60px;height:60px;object-fit:cover;border-radius:6px;">
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