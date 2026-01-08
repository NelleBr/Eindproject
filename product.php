<?php
session_start();

include_once(__DIR__ . "/db.inc.php");
include_once(__DIR__ . "/classes/product.php");
include_once(__DIR__ . "/classes/productOptions.php");
include_once(__DIR__ . "/classes/order.php");
include_once(__DIR__ . "/classes/review.php");

$id = $_GET["id"] ?? "";

if (!is_numeric($id)) {
    exit("ongeldig product");
}

$productClass = new Product();
$product = $productClass->getById($conn, (int)$id);

if (!$product) {
    exit("Product niet gevonden");
}

$productOptionClass = new ProductOption();
$options = $productOptionClass->getByProductId($conn, (int)$product["id"]);

$groupedOptions = [];
foreach ($options as $opt) {
    $name = $opt["option_name"];
    $value = $opt["option_value"];

    if (!isset($groupedOptions[$name])) {
        $groupedOptions[$name] = [];
    }
    $groupedOptions[$name][] = $value;
}

$isLoggedIn = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;
$canReview = false;

if ($isLoggedIn) {
    $orderClass = new Order();
    $canReview = $orderClass->userBoughtProduct($conn, (int)$_SESSION["user_id"], (int)$product["id"]);
}

$reviewClass = new Review();
$reviews = $reviewClass->getByProductId($conn, (int)$product["id"]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Volleybal webshop</title>
</head>

<body>
    <?php include_once(__DIR__ . "/nav.inc.php"); ?>
    <main>
        <section id="product-detail">
            <div class="container">
                <a href="producten.php" class="back-link">← Terug naar producten</a>

                <div class="product-detail-grid">
                    <?php if (!empty($product["image"])): ?>
                        <img src="<?php echo htmlspecialchars($product["image"]); ?>" alt="">
                    <?php else: ?>
                        <img src="https://placehold.co/500x500" alt="">
                    <?php endif; ?>
                </div>

                <div class="product-detail-right">
                    <h2><?php echo htmlspecialchars($product["name"]); ?></h2>
                    <p class="product-category"><?php echo htmlspecialchars($product["category_name"]); ?></p>
                    <p class="product-price">€<?php echo htmlspecialchars($product["price"]); ?></p>
                    <p><?php echo htmlspecialchars($product["description"]); ?></p>

                    <?php if (count($groupedOptions) > 0): ?>
                        <div class="product-options">
                            <h3>Opties</h3>

                            <form action="cart.php" method="get" class="options-form">
                                <input type="hidden" name="add" value="<?php echo (int)$product["id"]; ?>">

                                <?php foreach ($groupedOptions as $optionName => $values): ?>
                                    <div class="form-group">
                                        <label for="<?php echo htmlspecialchars($optionName); ?>">
                                            <?php echo htmlspecialchars(ucfirst($optionName)); ?>
                                        </label>

                                        <select id="<?php echo htmlspecialchars($optionName); ?>"
                                            name="option[<?php echo htmlspecialchars($optionName); ?>]">
                                            <option value="">Kies <?php echo htmlspecialchars($optionName); ?></option>

                                            <?php foreach ($values as $value): ?>
                                                <option value="<?php echo htmlspecialchars($value); ?>">
                                                    <?php echo htmlspecialchars($value); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                <?php endforeach; ?>

                                <button type="submit" class="button">Toevoegen aan winkelmandje</button>
                            </form>
                        </div>
                    <?php else: ?>
                        <a href="cart.php?add=<?php echo (int)$product["id"]; ?>" class="button">Toevoegen aan winkelmandje</a>
                    <?php endif; ?>
                </div>

                <hr style="margin:30px 0;">

                <section id="reviews">
                    <h3>Reviews</h3>

                    <?php if (!$isLoggedIn): ?>
                        <p><a href="login.php">Log in</a> om een review te plaatsen.</p>
                    <?php elseif (!$canReview): ?>
                        <p>Je kan enkel een review plaatsen als je dit product gekocht hebt.</p>
                    <?php else: ?>
                        <p id="review-error" class="form-error"></p>

                        <form id="review-form" method="post" class="review-form">
                            <input type="hidden" name="product_id" value="<?php echo (int)$product["id"]; ?>">

                            <div class="form-group">
                                <label for="rating">Rating</label>
                                <select name="rating" id="rating">
                                    <option value="">Kies rating</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="comment">Comment</label>
                                <textarea name="comment" id="comment"></textarea>
                            </div>

                            <button type="submit" class="button">Plaats review</button>
                        </form>
                    <?php endif; ?>

                    <div id="review-list" class="review-list">
                        <?php if (count($reviews) === 0): ?>
                            <p>Nog geen reviews.</p>
                        <?php else: ?>
                            <?php foreach ($reviews as $r): ?>
                                <div class="review-card">
                                    <strong><?php echo htmlspecialchars($r["first_name"] . " " . $r["last_name"]); ?></strong>
                                    <?php if ($r["rating"] !== null): ?>
                                        — <?php echo (int)$r["rating"]; ?>/5
                                    <?php endif; ?>

                                    <?php if (!empty($r["comment"])): ?>
                                        <p><?php echo nl2br(htmlspecialchars($r["comment"])); ?></p>
                                    <?php endif; ?>

                                    <small><?php echo htmlspecialchars($r["created_at"]); ?></small>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </section>
            </div>
        </section>
    </main>

    <?php include_once(__DIR__ . "/footer.inc.php"); ?>

    <?php if ($isLoggedIn && $canReview): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {

                let form = document.getElementById("review-form");
                let list = document.getElementById("review-list");
                let errorEl = document.getElementById("review-error");

                if (!form) return;

                form.addEventListener("submit", function(e) {
                    e.preventDefault();
                    errorEl.textContent = "";

                    let formData = new FormData(form);

                    fetch("review-add.php", {
                            method: "POST",
                            body: formData
                        })
                        .then(function(response) {
                            return response.json();
                        })
                        .then(function(data) {

                            if (!data.ok) {
                                errorEl.textContent = data.error;
                                return;
                            }

                            let r = data.review;

                            let div = document.createElement("div");
                            div.style.padding = "12px";
                            div.style.border = "1px solid #d8e1e8";
                            div.style.borderRadius = "8px";
                            div.style.marginTop = "10px";

                            let strong = document.createElement("strong");
                            strong.textContent = r.user_name;
                            div.appendChild(strong);

                            if (r.rating !== null) {
                                let ratingText = document.createTextNode(" — " + r.rating + "/5");
                                div.appendChild(ratingText);
                            }

                            if (r.comment) {
                                let p = document.createElement("p");
                                p.textContent = r.comment;
                                div.appendChild(p);
                            }

                            let small = document.createElement("small");
                            small.textContent = r.created_at;
                            div.appendChild(small);

                            list.prepend(div);
                            form.reset();
                        });
                });
            });
        </script>
    <?php endif; ?>
</body>

</html>