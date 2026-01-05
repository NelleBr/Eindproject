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
    <header>
        <div class="container">
            <h1>VolleyShop</h1>
            <nav>
                <div>
                    <a href="index.php">Home</a>
                    <a href="producten.php">Producten</a>
                    <a href="cart.php">Winkelmandje</a>
                    <a href="account.php">Account</a>
                </div>
            </nav>
        </div>
    </header>
    <main>
        <section id="admin">
            <div class="container">
                <h2>Admin dashboard</h2>

                <div class="admin-section">
                    <h3>Nieuw product aanmaken</h3>
                    <form action="#" method="post" class="form-card">
                        <div class="form-group">
                            <label for="product_title">Titel</label>
                            <input type="text" id="product_title" name="product_title" required>
                        </div>

                        <div class="form-group">
                            <label for="product_category">Categorie</label>
                            <select id="product_category" name="product_category">
                                <option value="schoenen">Volleybalschoenen</option>
                                <option value="kleding">Kleding</option>
                                <option value="ballen">Volleyballen</option>
                                <option value="bescherming">Bescherming</option>
                                <option value="accessoires">Accessoires</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="product_price">Prijs (€)</label>
                            <input type="number" id="product_price" name="product_price" step="0.01" required>
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
    <footer>
        <p>&copy; <?php echo date('Y'); ?> VolleyShop. Alle rechten voorbehouden.</p>
    </footer>
</body>

</html>