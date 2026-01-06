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
include_once(__DIR__ . "/classes/Category.php");

$error = "";

$productClass = new Product();
$products = $productClass->getAll($conn);

$categoryClass = new Category();
$categories = $categoryClass->getAll($conn);

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
        $productId = $productClass->create($conn, $categoryId, $name, $description, $price, $stock);

        $image = $_POST["product_image"];
        if ($image !== "") {
            $productClass->addImage($conn, $productId, $image);
        }

        header("Location: admin.php");
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
    <title>Volleybal Webshop</title>
</head>

<body>
    <?php include_once(__DIR__ . "/nav.inc.php"); ?>
    <main>
        <section id="admin">
            <div class="container">
                <h2>Admin dashboard</h2>

                <div class="admin-section">
                    <h3>Nieuw product aanmaken</h3>
                    <?php if ($error !== ""): ?>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    <?php endif; ?>
                    <form action="#" method="post" class="form-card">
                        <div class="form-group">
                            <label for="product_title">Titel</label>
                            <input type="text" id="product_title" name="product_title">
                        </div>
                        <div class="form-group">
                            <label for="product_description">Beschrijving</label>
                            <textarea id="product_description" name="product_description"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="product_stock">Voorraad</label>
                            <input type="number" id="product_stock" name="product_stock">
                        </div>

                        <div class="form-group">
                            <label for="product_category">Categorie</label>
                            <select id="product_category" name="product_category">
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category["id"]; ?>">
                                        <?php echo htmlspecialchars($category["name"]); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="product_price">Prijs (€)</label>
                            <input type="number" id="product_price" name="product_price" step="0.01">
                        </div>

                        <div class="form-group">
                            <label for="product_image">Afbeelding URL</label>
                            <input type="text" id="product_image" name="product_image">
                        </div>

                        <button type="submit">Product opslaan</button>
                    </form>
                </div>

                <div class="admin-section">
                    <h3>Bestaande producten</h3>
                    <ul>
                        <?php foreach ($products as $product): ?>
                            <li>
                                <strong><?php echo htmlspecialchars($product["name"]); ?></strong><br>
                                Categorie: <?php echo htmlspecialchars($product["category_name"]); ?><br>
                                Beschrijving: <?php echo htmlspecialchars($product["description"]); ?><br>
                                Prijs: €<?php echo htmlspecialchars($product["price"]); ?><br>
                                Voorraad: <?php echo htmlspecialchars($product["stock"]); ?> <br>
                                <?php if ($product["image"] !== null && $product["image"] !== ""): ?>
                                    <img src="<?php echo htmlspecialchars($product["image"]); ?>" alt="" style="width:80px;height:80px;object-fit:cover;">
                                <?php endif; ?>
                            </li>
                            <hr>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </section>
    </main>
    <?php include_once(__DIR__ . "/footer.inc.php"); ?>
</body>

</html>