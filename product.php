<?php

session_start();

include_once(__DIR__ . "/db.inc.php");
include_once(__DIR__ . "/classes/product.php");

$id = "";
if (isset($_GET["id"])) {
    $id = $_GET["id"];
}

if (!is_numeric($id)) {
    exit("ongeldig product");
}

if (!is_numeric($id)) {
    exit("ongeldig product");
}

$productClass = new Product();
$product = $productClass->getById($conn, $id);

if (!$product) {
    exit("Product niet gevonden");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Volleybal webshop</title>
</head>

<body>
    <?php include_once(__DIR__ . "/nav.inc.php"); ?>
    <main>
        <section id="product-detail">
            <div class="container">
                <p><a href="producten.php">← Terug naar producten</a></p>

                <div class="product-detail-grid">
                    <div class="product-detail-left">
                        <?php if (!empty($product["image"])): ?>
                            <img src="<?php echo htmlspecialchars($product["image"]); ?>" alt="">
                        <?php else: ?>
                            <img src="https://placehold.co/500x500" alt="">
                        <?php endif; ?>
                    </div>

                    <div class="product-detail-right">
                        <h2><?php echo htmlspecialchars($product["name"]); ?></h2>
                        <p class="product-category"><?php echo htmlspecialchars($product["category_name"]); ?></p>

                        <p class="product-price">€<?php echo htmlspecialchars($product["price"]); ?></p>

                        <p><?php echo htmlspecialchars($product["description"]); ?></p>

                        <a href="cart.php?add=<?php echo $product["id"]; ?>" class="button">Toevoegen aan winkelmandje</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include_once(__DIR__ . "/footer.inc.php"); ?>
</body>

</html>