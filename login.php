<?php

session_start();
include_once(__DIR__ . "/db.inc.php");

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("Location: index.php");
    exit;
}

$error = "";

if (!empty($_POST)) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $statement = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
    $statement->bindValue(":email", $email);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["loggedin"] = true;
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["is_admin"] = $user["is_admin"];
        $_SESSION["first_name"] = $user["first_name"];
        $_SESSION["last_name"] = $user["last_name"];
        $_SESSION["is_admin"] = $user["is_admin"];
        $_SESSION["currency"] = $user["currency"];

        header("Location: index.php");
        exit;
    } else {
        $error = "E-mail of wachtwoord is fout!";
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
        <section id="login">
            <div class="container">
                <h2>Inloggen</h2>
                <?php if ($error !== ""): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>
                <form action="#" method="post" class="form-card">
                    <div class="form-group">
                        <label for="email">E-mailadres</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Wachtwoord</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <button type="submit">Inloggen</button>
                </form>

                <p>Nog geen account? <a href="registreer.php">Registreer hier</a>.</p>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> VolleyShop. Alle rechten voorbehouden.</p>
    </footer>
</body>

</html>