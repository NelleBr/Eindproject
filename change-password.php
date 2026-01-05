<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Wachtwoord wijzigen</title>
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
        <section id="change-password">
            <div class="container">
                <h2>Wachtwoord wijzigen</h2>

                <form action="" method="post" class="form-card">
                    <div class="form-group">
                        <label for="current_password">Huidig wachtwoord</label>
                        <input type="password" id="current_password" name="current_password">
                    </div>

                    <div class="form-group">
                        <label for="new_password">Nieuw wachtwoord</label>
                        <input type="password" id="new_password" name="new_password">
                    </div>

                    <div class="form-group">
                        <label for="new_password_confirm">Herhaal nieuw wachtwoord</label>
                        <input type="password" id="new_password_confirm" name="new_password_confirm">
                    </div>

                    <button type="submit">Wachtwoord wijzigen</button>
                </form>

            </div>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> VolleyShop. Alle rechten voorbehouden.</p>
    </footer>
</body>

</html>