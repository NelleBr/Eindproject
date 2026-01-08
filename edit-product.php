<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] != 1) {
    header("Location: index.php");
    exit;
}

include_once(__DIR__ . "/db.inc.php");
include_once(__DIR__ . "/classes/product.php");
include_once(__DIR__ . "/classes/category.php");

$error = "";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    exit("Ongeldig product");
}

$id = $_GET["id"];

$productClass = new Product();
$categoryClass = new Category();

$categories = $categoryClass->getAll($conn);
$product = $productClass->getById($conn, $id);

if (!$product) {
    exit("Product niet gevonden");
}

if (!empty($_POST)) {
    $name = $_POST["product_title"];
    $description = $_POST["product_description"];
    $categoryId = $_POST["product_category"];
    $price = $_POST["product_price"];
    $stock = $_POST["product_stock"];
    $image = $_POST["product_image"];

    if ($name === "" || $categoryId === "" || $price === "" || $stock === "") {
        $error = "Vul alle velden in.";
    } elseif ($price <= 0) {
        $error = "Prijs moet hoger zijn dan 0.";
    } elseif ($stock < 0) {
        $error = "Voorraad kan niet negatief zijn.";
    }

    if ($error === "") {
        $productClass->update($conn, $id, $categoryId, $name, $description, $price, $stock);
        $productClass->replaceImage($conn, $id, $image);

        header("Location: admin.php?updated=1");
        exit;
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
    <title>Product bewerken</title>
</head>

<body>
    <?php include_once(__DIR__ . "/nav.inc.php"); ?>

    <main>
        <section id="admin">
            <div class="container">
                <h2>Product bewerken</h2>

                <?php if ($error !== ""): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>

                <form action="" method="post" class="form-card">
                    <div class="form-group">
                        <label for="product_title">Titel</label>
                        <input type="text" id="product_title" name="product_title"
                            value="<?php echo htmlspecialchars($product["name"]); ?>">
                    </div>

                    <div class="form-group">
                        <label for="product_description">Beschrijving</label>
                        <textarea id="product_description" name="product_description"><?php echo htmlspecialchars($product["description"]); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="product_stock">Voorraad</label>
                        <input type="number" id="product_stock" name="product_stock"
                            value="<?php echo htmlspecialchars($product["stock"]); ?>">
                    </div>

                    <div class="form-group">
                        <label for="product_category">Categorie</label>
                        <select id="product_category" name="product_category">
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category["id"]; ?>"
                                    <?php if ($category["name"] === $product["category_name"]) echo "selected"; ?>>
                                    <?php echo htmlspecialchars($category["name"]); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="product_price">Prijs (€)</label>
                        <input type="number" id="product_price" name="product_price" step="0.01"
                            value="<?php echo htmlspecialchars($product["price"]); ?>">
                    </div>

                    <div class="form-group">
                        <label for="product_image">Afbeelding URL</label>
                        <input type="text" id="product_image" name="product_image"
                            value="<?php echo htmlspecialchars($product["image"]); ?>">
                    </div>

                    <button type="submit">Opslaan</button>
                </form>

                <p><a class="back-link" href="admin.php">← Terug naar admin</a></p>
            </div>
        </section>
    </main>

    <?php include_once(__DIR__ . "/footer.inc.php"); ?>
</body>

</html>