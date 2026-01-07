<?php

session_start();

include_once(__DIR__ . "/classes/Cart.php");

$cart = new Cart();
$items = $cart->getItems();



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
                        <tr>
                            <td class="cart-product">
                                <img src="https://placehold.co/100x100" alt="">
                                Demo product
                            </td>
                            <td>1</td>
                            <td>€50,00</td>
                            <td>€50,00</td>
                        </tr>

                        <tr>
                            <td class="cart-product">
                                <img src="https://placehold.co/100x100" alt="">
                                Mikasa V200W Volleybal FIVB
                            </td>
                            <td>2</td>
                            <td>€94,99</td>
                            <td>€189,98</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"><strong>Totaal</strong></td>
                            <td><strong>€239,98</strong></td>
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