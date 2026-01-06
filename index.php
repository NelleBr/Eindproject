<?php

session_start();

include_once(__DIR__ . "/db.inc.php");
include_once(__DIR__ . "/classes/Category.php");

$categoryClass = new Category();
$categories = $categoryClass->getAll($conn);

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

                <a href="#" class="product-link">
                    <article class="product-item">
                        <img src="https://placehold.co/200x200" alt="">
                        <h3>Mizuno Volleybalschoenen Wave Momentum 3</h3>
                        <p class="product-category">Volleybalschoenen</p>
                        <p class="product-price">€89,99</p>
                    </article>
                </a>

                <a href="#" class="product-link">
                    <article class="product-item">
                        <img src="https://placehold.co/200x200" alt="">
                        <h3>Mikasa V200W Volleybal FIVB</h3>
                        <p class="product-category">Volleyballen</p>
                        <p class="product-price">€94,99</p>
                    </article>
                </a>

                <a href="#" class="product-link">
                    <article class="product-item">
                        <img src="https://placehold.co/200x200" alt="">
                        <h3>Volleybalshirt Unisex</h3>
                        <p class="product-category">Kleding</p>
                        <p class="product-price">€24,99</p>
                    </article>
                </a>

                <a href="#" class="product-link">
                    <article class="product-item">
                        <img src="https://placehold.co/200x200" alt="">
                        <h3>Kniebeschermers Mizuno</h3>
                        <p class="product-category">Bescherming</p>
                        <p class="product-price">€19,99</p>
                    </article>
                </a>

            </div>
        </div>
    </section>
    <?php include_once(__DIR__ . "/footer.inc.php"); ?>
</body>

</html>