<?php
session_start();

include_once(__DIR__ . "/db.inc.php");
include_once(__DIR__ . "/classes/product.php");
include_once(__DIR__ . "/classes/category.php");

$categoryFilter = "";
$search = "";

$categoryClass = new Category();
$categories = $categoryClass->getAll($conn);

if (isset($_GET["categorie"])) {
    $categoryFilter = $_GET["categorie"];
}

if (isset($_GET["zoekterm"])) {
    $search = $_GET["zoekterm"];
}

$productClass = new Product();
$products = $productClass->searchAndFilter($conn, $categoryFilter, $search);

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
        <section id="product-overview">
            <div class="container">
                <h2>Alle producten</h2>

                <form class="product-filters" action="producten.php" method="get">
                    <div class="filter-row">
                        <div class="filter-group">
                            <label for="categorie">Categorie</label>
                            <select id="categorie" name="categorie">
                                <option value="">Alle categorieën</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category["id"]; ?>"
                                        <?php if ($categoryFilter == $category["id"]) echo "selected"; ?>>
                                        <?php echo htmlspecialchars($category["name"]); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label for="zoekterm">Zoeken</label>
                            <input type="text" id="zoekterm" name="zoekterm" placeholder="Zoek een product"
                                value="<?php echo htmlspecialchars($search); ?>">
                        </div>

                        <div class="filter-actions">
                            <button type="submit" class="button">Filter</button>

                            <?php if ($categoryFilter !== "" || $search !== ""): ?>
                                <a class="button button-delete-filter" href="producten.php">Filters wissen</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>


                <div class="product-list">

                    <?php if (count($products) === 0): ?>
                        <p>Geen producten gevonden voor je zoekopdracht.</p>
                    <?php else: ?>
                        <?php foreach ($products as $product): ?>
                            <a href="product.php?id=<?php echo $product["id"]; ?>" class="product-link">
                                <article class="product-item">
                                    <?php if ($product["image"]): ?>
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
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

    <?php include_once(__DIR__ . "/footer.inc.php"); ?>
</body>

</html>