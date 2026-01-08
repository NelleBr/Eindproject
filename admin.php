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

$productClass = new Product();
$products = $productClass->getAll($conn);

$categoryClass = new Category();
$categories = $categoryClass->getAll($conn);

if (isset($_POST["delete_id"])) {
    $deleteId = $_POST["delete_id"];

    if (is_numeric($deleteId)) {
        $productClass->deleteById($conn, $deleteId);
    }

    header("Location: admin.php?deleted=1");
    exit;
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

                <?php if (isset($_GET["deleted"])): ?>
                    <p class="success-message">
                        Product succesvol verwijderd.
                    </p>
                <?php endif; ?>

                <?php if (isset($_GET["updated"]) && $_GET["updated"] == "1"): ?>
                    <p>Product succesvol aangepast.</p>
                <?php endif; ?>

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
                                <a href="edit-product.php?id=<?php echo $product["id"]; ?>" class="edit-icon" title="Bewerk product">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" width="18" height="18">
                                        <path fill="#304674"
                                            d="M535.6 85.7C513.7 63.8 478.3 63.8 456.4 85.7L432 110.1L529.9 208L554.3 183.6C576.2 161.7 576.2 126.3 554.3 104.4L535.6 85.7zM236.4 305.7C230.3 311.8 225.6 319.3 222.9 327.6L193.3 416.4C190.4 425 192.7 434.5 199.1 441C205.5 447.5 215 449.7 223.7 446.8L312.5 417.2C320.7 414.5 328.2 409.8 334.4 403.7L496 241.9L398.1 144L236.4 305.7zM160 128C107 128 64 171 64 224L64 480C64 533 107 576 160 576L416 576C469 576 512 533 512 480L512 384C512 366.3 497.7 352 480 352C462.3 352 448 366.3 448 384L448 480C448 497.7 433.7 512 416 512L160 512C142.3 512 128 497.7 128 480L128 224C128 206.3 142.3 192 160 192L256 192C273.7 192 288 177.7 288 160C288 142.3 273.7 128 256 128L160 128z" />
                                    </svg>
                                </a>
                                <form action="admin.php" method="post" style="display:inline;">
                                    <input type="hidden" name="delete_id" value="<?php echo $product["id"]; ?>">
                                    <button type="submit" class="delete-icon"
                                        onclick="return confirm('Ben je zeker dat je dit product wilt verwijderen?');">
                                        <!-- icon komt van fontawesome -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 640 640"
                                            width="18"
                                            height="18">
                                            <path fill="#d30909"
                                                d="M232.7 69.9L224 96L128 96C110.3 96 96 110.3 96 128C96 145.7 110.3 160 128 160L512 160C529.7 160 544 145.7 544 128C544 110.3 529.7 96 512 96L416 96L407.3 69.9C402.9 56.8 390.7 48 376.9 48L263.1 48C249.3 48 237.1 56.8 232.7 69.9zM512 208L128 208L149.1 531.1C150.7 556.4 171.7 576 197 576L443 576C468.3 576 489.3 556.4 490.9 531.1L512 208z" />
                                        </svg>
                                    </button>
                                </form>
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