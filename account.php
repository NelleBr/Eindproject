<?php

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
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
    <?php include_once(__DIR__ . "/nav.inc.php"); ?>
    <main>
        <section id="account">
            <div class="container">
                <h2>Mijn account</h2>

                <div class="account-info">
                    <p><strong>Welkom</strong> <?php echo htmlspecialchars($_SESSION["first_name"] . " " . $_SESSION["last_name"]); ?></p>
                    <p>
                        <strong>Saldo:</strong>
                        <?php echo htmlspecialchars($_SESSION["currency"]); ?> Munten
                    </p>
                </div>

                <div class="account-actions">
                    <h3>Acties</h3>
                    <ul>
                        <li><a href="cart.php">Winkelmandje bekijken</a></li>
                        <li><a href="change-password.php">Wachtwoord wijzigen</a></li>
                        <li><a href="logout.php">Uitloggen</a></li>
                    </ul>
                </div>

                <div class="account-orders">
                    <h3>Mijn bestellingen</h3>
                    <p>Hier kan je later een overzicht van bestellingen tonen.</p>
                </div>
            </div>
        </section>
    </main>

    <?php include_once(__DIR__ . "/footer.inc.php"); ?>
</body>

</html>