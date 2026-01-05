<?php

session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("Location: index.php");
    exit;
}

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
        $check->bindValue(":email", $email);
        $check->execute();

        $existingUser = $check->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            $error = "Er bestaat al een account met dit e-mailadres.";
        } else {
            $options = ['cost' => 13,];
            $password = password_hash($password, PASSWORD_BCRYPT, $options);


            $statement = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, is_admin, currency)
            VALUES (:first_name, :last_name, :email, :password, :is_admin, :currency)");

            $statement->bindValue(":first_name", $firstName);
            $statement->bindValue(":last_name", $lastName);
            $statement->bindValue(":email", $email);
            $statement->bindValue(":password", $password);
            $statement->bindValue(":is_admin", 0);
            $statement->bindValue(":currency", 1000);

            $statement->execute();

            header("Location: index.php");
            exit;
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
<?php include_once(__DIR__ . "/nav.inc.php"); ?>
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

<?php include_once(__DIR__ . "/footer.inc.php"); ?>
</body>

</html>