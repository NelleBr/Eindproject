<?php

session_start();

include_once(__DIR__ . "/db.inc.php");

$error = "";
$success = "";

if (!empty($_POST)) {
    $currentPassword = $_POST["current_password"];
    $newPassword = $_POST["new_password"];
    $newPasswordConfirm = $_POST["new_password_confirm"];

    if ($currentPassword === "" || $newPassword === "" || $newPasswordConfirm === "") {
        $error = "Vul alle velden in.";
    } elseif ($newPassword !== $newPasswordConfirm) {
        $error = "Nieuwe wachtwoorden komen niet overeen.";
    }

    if ($error === "") {
        $statement = $conn->prepare("SELECT password FROM users WHERE id = :id LIMIT 1");
        $statement->bindValue(":id", $_SESSION["user_id"]);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($currentPassword, $user["password"])) {
            $error = "Je huidige wachtwoord is fout.";
        }
    }

    if ($error == "") {
        $options = ["cost" => 13];

        $password = password_hash($newPassword, PASSWORD_BCRYPT, $options);

        $update = $conn->prepare("UPDATE users SET password = :password WHERE id = :id");
        $update->bindValue(":password", $password);
        $update->bindValue(":id", $_SESSION["user_id"]);
        $update->execute();

        $success = "Je wachtwoord is succesvol gewijzigd.";
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
    <title>Wachtwoord wijzigen</title>
</head>

<body>
    <?php include_once(__DIR__ . "/nav.inc.php"); ?>

    <main>
        <section id="change-password">
            <div class="container">
                <h2>Wachtwoord wijzigen</h2>
                <?php if ($error !== ""): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>
                <?php if ($success !== ""): ?>
                    <p><?php echo htmlspecialchars($success); ?></p>
                <?php endif; ?>
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

    <?php include_once(__DIR__ . "/footer.inc.php"); ?>
</body>

</html>