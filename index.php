<?php

session_start();

include_once(__DIR__ . "/db.inc.php");
include_once(__DIR__ . "/classes/Category.php");
include_once(__DIR__ . "/classes/Product.php");

$categoryClass = new Category();
$categories = $categoryClass->getAll($conn);

$productClass = new Product();
$featuredProducts = $productClass->getLatest($conn, 4);

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
    <section id="intro">
        <div class="container">
            <h2>Alles voor jouw volleybalspel</h2>
            <p>Koop schoenen, kleding, volleyballen en accessoires speciaal voor volleybal.</p>
            <a href="producten.php" class="button">Bekijk onze poducten</a>
        </div>
    </section>


    <section id="categories">
        <div class="container">
            <h2>Categorieën</h2>
            <div class="category-list">
                <?php foreach ($categories as $category): ?>
                    <a href="producten.php?categorie=<?php echo $category["id"]; ?>" class="category-item">
                        <h3><?php echo htmlspecialchars($category["name"]); ?></h3>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="featured-products">
        <div class="container">
            <h2>Uitgelichte producten</h2>
            <div class="product-list">
                <?php foreach ($featuredProducts as $product): ?>
                    <a href="product.php?id=<?php echo $product["id"]; ?>" class="product-link">
                        <article class="product-item">
                            <?php if (!empty($product["image"])): ?>
                                <img src="<?php echo htmlspecialchars($product["image"]); ?>" alt="">
                            <?php else: ?>
                                <img src="https://placehold.co/200x200" alt="">
                            <?php endif; ?>

                            <h3><?php echo htmlspecialchars($product["name"]); ?></h3>
                            <p class="product-category"><?php echo htmlspecialchars($product["category_name"]); ?></p>
                            <p class="product-price">€<?php echo htmlspecialchars($product["price"]); ?></p>
                        </article>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php include_once(__DIR__ . "/footer.inc.php"); ?>
</body>

</html>