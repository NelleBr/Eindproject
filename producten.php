<?php
session_start();

include_once(__DIR__ . "/db.inc.php");

$categoryFilter = "";

$search = "";

if (isset($_GET["zoekterm"])) {
    $search = $_GET["zoekterm"];
}

if (isset($_GET["categorie"])) {
    $categoryFilter = $_GET["categorie"];
}

if ($categoryFilter === "" && $search === "") {
    $list = $conn->query("
        SELECT 
            products.id,
            products.name,
            products.price,
            categories.name AS category_name,
            product_images.image_path AS image
        FROM products
        JOIN categories ON products.category_id = categories.id
        LEFT JOIN product_images ON product_images.product_id = products.id
        ORDER BY products.id DESC
    ");
    $products = $list->fetchAll(PDO::FETCH_ASSOC);
} else {
    $sql = "
        SELECT 
            products.id,
            products.name,
            products.price,
            categories.name AS category_name,
            product_images.image_path AS image
        FROM products
        JOIN categories ON products.category_id = categories.id
        LEFT JOIN product_images ON product_images.product_id = products.id
        WHERE 1=1
    ";

    if ($categoryFilter !== "") {
        $sql .= " AND products.category_id = :category_id ";
    }

    if ($search !== "") {
        $sql .= " AND (products.name LIKE :search OR products.description LIKE :search) ";
    }

    $sql .= " ORDER BY products.id DESC ";

    $list = $conn->prepare($sql);

    if ($categoryFilter !== "") {
        $list->bindValue(":category_id", $categoryFilter);
    }

    if ($search !== "") {
        $list->bindValue(":search", "%" . $search . "%");
    }

    $list->execute();
    $products = $list->fetchAll(PDO::FETCH_ASSOC);
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
        <section id="product-overview">
            <div class="container">
                <h2>Alle producten</h2>

                <form class="product-filters" action="#" method="get">
                    <div>
                        <label for="categorie">Categorie:</label>
                        <select id="categorie" name="categorie">
                            <option value="">Alle categorieën</option>
                            <option value="1" <?php if ($categoryFilter == "1") echo "selected"; ?>>Volleybalschoenen</option>
                            <option value="2" <?php if ($categoryFilter == "2") echo "selected"; ?>>Kleding</option>
                            <option value="3" <?php if ($categoryFilter == "3") echo "selected"; ?>>Volleyballen</option>
                            <option value="4" <?php if ($categoryFilter == "4") echo "selected"; ?>>Bescherming</option>
                            <option value="5" <?php if ($categoryFilter == "5") echo "selected"; ?>>Accessoires</option>
                        </select>
                    </div>

                    <div>
                        <label for="zoekterm">Zoeken:</label>
                        <input type="text" id="zoekterm" name="zoekterm" placeholder="Zoek een product"
                            value="<?php echo htmlspecialchars($search); ?>">
                    </div>

                    <button type="submit">Filter</button>

                    <?php if ($categoryFilter !== ""): ?>
                        <p><a href="producten.php">Fitlers wissen</a></p>
                    <?php endif; ?>
                </form>

                <div class="product-list">

                    <?php if (count($products) === 0): ?>
                        <p>Geen producten gevonden voor je zoekopdracht.</p>
                    <?php else: ?>
                        <?php foreach ($products as $product): ?>
                            <a href="#" class="product-link">
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