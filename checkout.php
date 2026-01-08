<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit;
}

include_once(__DIR__ . "/db.inc.php");
include_once(__DIR__ . "/classes/cart.php");
include_once(__DIR__ . "/classes/product.php");
include_once(__DIR__ . "/classes/user.php");
include_once(__DIR__ . "/classes/order.php");

$cart = new Cart();
$productClass = new Product();
$userClass = new User();
$orderClass = new Order();

$lines = $cart->getLines($conn, $productClass);
$total = $cart->getTotal($lines);

$error = "";
$success = "";

if (count($lines) === 0) {
    $error = "Je winkelmandje is leeg.";
} else {
    $currency = $userClass->getCurrencyById($conn, $_SESSION["user_id"]);

    // Afrekenen via POST
    if (!empty($_POST) && isset($_POST["checkout"])) {
        if ($currency < $total) {
            $error = "Je hebt niet genoeg munten om af te rekenen.";
        } else {
            try {
                $conn->beginTransaction();

                $orderId = $orderClass->create($conn, $_SESSION["user_id"], $total);

                foreach ($lines as $line) {
                    $orderClass->addItem(
                        $conn,
                        $orderId,
                        $line["product"]["id"],
                        $line["qty"],
                        $line["product"]["price"]
                    );
                }

                $userClass->deductCurrency($conn, $_SESSION["user_id"], (int)round($total));

                $conn->commit();

                $cart->clear();

                $_SESSION["currency"] = $userClass->getCurrencyById($conn, $_SESSION["user_id"]);

                $success = "Aankoop gelukt! Je munten zijn correct afgerekend.";
            } catch (Exception $e) {
                $conn->rollBack();
                $error = "Er liep iets mis bij het afrekenen.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Checkout</title>
</head>

<body>
    <?php include_once(__DIR__ . "/nav.inc.php"); ?>

    <main>
        <section id="checkout">
            <div class="container">
                <h2>Afrekenen</h2>
                <p><a href="cart.php">← Terug naar winkelmandje</a></p>

                <?php if ($error !== ""): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                    <p><a href="cart.php">← Terug naar winkelmandje</a></p>
                <?php endif; ?>

                <?php if ($success !== ""): ?>
                    <p><?php echo htmlspecialchars($success); ?></p>
                    <p><a href="producten.php">Verder winkelen</a></p>
                <?php endif; ?>

                <?php if ($error === "" && $success === ""): ?>
                    <p><strong>Totaal:</strong> €<?php echo number_format((float)$total, 2, ",", "."); ?></p>
                    <p><strong>Jouw munten:</strong> <?php echo (int)$currency; ?></p>

                    <?php if ($currency < $total): ?>
                        <p>Je hebt niet genoeg units om af te rekenen.</p>
                        <p><a href="cart.php">← Terug naar winkelmandje</a></p>
                    <?php else: ?>
                        <form action="checkout.php" method="post">
                            <button type="submit" name="checkout" class="button">Bevestig aankoop</button>
                        </form>
                    <?php endif; ?>
                <?php endif; ?>

            </div>
        </section>
    </main>

    <?php include_once(__DIR__ . "/footer.inc.php"); ?>
</body>

</html>