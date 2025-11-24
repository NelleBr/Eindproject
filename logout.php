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
        <section id="logout">
            <div class="container">
                <h2>Je bent uitgelogd</h2>
                <p>Je bent succesvol uitgelogd.</p>
                <p><a href="index.php">Ga terug naar de homepagina</a></p>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> VolleyShop. Alle rechten voorbehouden.</p>
    </footer>
</body>
</html>