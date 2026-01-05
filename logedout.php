<?php

session_start();


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
        <section id="logout">
            <div class="container">
                <h2>Je bent uitgelogd</h2>
                <p>Je bent succesvol uitgelogd.</p>
                <p><a href="index.php">Ga terug naar de homepagina</a></p>
            </div>
        </section>
    </main>

    <?php include_once(__DIR__ . "/footer.inc.php"); ?>
</body>

</html>