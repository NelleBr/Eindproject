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

$error = "";
$success = "";

if (!empty($_POST)) {
    $name = $_POST["product_title"];
    $description = $_POST["product_description"];
    $categoryId = $_POST["product_category"];
    $price = $_POST["product_price"];
    $stock = $_POST["product_stock"];

    if ($name === "" || $categoryId === "" || $price === "" || $stock === "") {
        $error = "Vul alle velden in.";
    } elseif ($price <= 0) {
        $error = "Prijs moet hoger zijn dan 0.";
    } elseif ($stock < 0) {
        $error = "Vooraad kan niet negatief zijn.";
    }

    if (!empty($_POST) && $error === "") {
        $statement = $conn->prepare("INSERT INTO products (category_id, name, description, price, stock)
        VALUES (:category_id, :name, :description, :price, :stock)");

        $statement->bindValue(":category_id", $categoryId);
        $statement->bindValue(":name", $name);
        $statement->bindValue(":description", $description);
        $statement->bindValue(":price", $price);
        $statement->bindValue(":stock", $stock);

        $statement->execute();

        $success = "Product is succesvol opgeslagen.";
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
                    <?php if ($success !== ""): ?>
                        <p><?php echo htmlspecialchars($success); ?></p>
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
                                <option value="1">Volleybalschoenen</option>
                                <option value="2">Kleding</option>
                                <option value="3">Volleyballen</option>
                                <option value="4">Bescherming</option>
                                <option value="5">Accessoires</option>
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
                    <p>Later komen hier de producten vanuit mijn database</p>
                    <ul>
                        <li>Mizuno Volleybalschoenen Wave Momentum 3</li>
                        <li>Mikasa V200W Volleybal FIVB</li>
                    </ul>
                </div>
            </div>
        </section>
    </main>
    <?php include_once(__DIR__ . "/footer.inc.php"); ?>
</body>

</html>