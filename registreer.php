<?php

session_start();
include_once(__DIR__ . "/db.inc.php");

$error = "";

if (!empty($_POST)) {
    $firstName = $_POST["first_name"];
    $lastName = $_POST["last_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordConfirm = $_POST["password_confirm"];

    if ($firstName === "" || $lastName === "" || $email === "" || $password === "" || $passwordConfirm === "") {
        $error = "Vul alle velden in.";
    } elseif ($password !== $passwordConfirm) {
        $error = "Wachtwoorden komen niet overeen.";
    } else {
        $check = $conn->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
        $check->bindvalue(":email", $email);
        $check->execute();

        $existingUser = $check->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            $error = "Er bestaat al een account met dit e-mailadres.";
        } else {
            $options = ['cost' => 13,];
            $password = password_hash($password, PASSWORD_BCRYPT, $options);
        }
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
    <section id="register">
        <div class="container">
            <h2>Account aanmaken</h2>
            <?php if ($error !== ""): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <form action="#" method="post" class="form-card">
                <div class="form-group">
                    <label for="first_name">Voornaam</label>
                    <input type="text" id="first_name" name="first_name">
                </div>

                <div class="form-group">
                    <label for="last_name">Achternaam</label>
                    <input type="text" id="last_name" name="last_name">
                </div>

                <div class="form-group">
                    <label for="email">E-mailadres</label>
                    <input type="email" id="email" name="email">
                </div>

                <div class="form-group">
                    <label for="password">Wachtwoord</label>
                    <input type="password" id="password" name="password">
                </div>

                <div class="form-group">
                    <label for="password_confirm">Herhaal wachtwoord</label>
                    <input type="password" id="password_confirm" name="password_confirm">
                </div>

                <button type="submit">Registreren</button>
            </form>

            <p>Heb je al een account? <a href="login.php">Log hier in</a>.</p>
        </div>
    </section>
</main>

<footer>
    <p>&copy; <?php echo date('Y'); ?> VolleyShop. Alle rechten voorbehouden.</p>
</footer>
</body>

</html>