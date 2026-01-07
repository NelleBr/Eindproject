<?php

session_start();

include_once(__DIR__ . "/classes/Cart.php");
include_once(__DIR__ . "/db.inc.php");
include_once(__DIR__ . "/classes/product.php");

$productClass = new Product();

$cart = new Cart();
$items = $cart->getItems();

$lines = $cart->getLines($conn, $productClass);
$total = $cart->getTotal($lines);

if (isset($_GET["add"])) {
    $productId = $_GET["add"];

    if (is_numeric($productId)) {
        $cart->add($productId);
    }

    header("Location: cart.php");
    exit;
}


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
        <section id="cart">
            <div class="container">
                <h2>Winkelmandje</h2>

                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Aantal</th>
                            <th>Prijs</th>
                            <th>Totaal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lines as $line): ?>
                            <tr>
                                <td class="cart-product">
                                    <?php if (!empty($line["product"]["image"])): ?>
                                        <img src="<?php echo htmlspecialchars($line["product"]["image"]); ?>" alt=""
                                            style="width:100px;height:100px;object-fit:cover;">
                                    <?php else: ?>
                                        <img src="https://placehold.co/100x100" alt="">
                                    <?php endif; ?>

                                    <?php echo htmlspecialchars($line["product"]["name"]); ?>
                                </td>
                                <td><?php echo (int)$line["qty"]; ?></td>
                                <td>€<?php echo number_format((float)$line["product"]["price"], 2, ",", "."); ?></td>
                                <td>€<?php echo number_format((float)$line["line_total"], 2, ",", "."); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"><strong>Totaal</strong></td>
                            <td><strong>€<?php echo number_format((float)$total, 2, ",", "."); ?></strong></td>
                        </tr>
                    </tfoot>
                </table>

                <div class="cart-actions">
                    <button type="button">Verder winkelen</button>
                    <button type="button">Afrekenen</button>
                </div>
            </div>
        </section>
    </main>

    <?php include_once(__DIR__ . "/footer.inc.php"); ?>
</body>

</html>