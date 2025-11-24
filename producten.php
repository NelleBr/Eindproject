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
        <section id="product-overview">
            <div class="container">
                <h2>Alle producten</h2>

                <form class="product-filters" action="#" method="get">
                    <div>
                        <label for="categorie">Categorie:</label>
                        <select id="categorie" name="categorie">
                            <option value="">Alle categorieën</option>
                            <option value="schoenen">Volleybalschoenen</option>
                            <option value="kleding">Kleding</option>
                            <option value="ballen">Volleyballen</option>
                            <option value="bescherming">Bescherming</option>
                            <option value="accessoires">Accessoires</option>
                        </select>
                    </div>

                    <div>
                        <label for="zoekterm">Zoeken:</label>
                        <input type="text" id="zoekterm" name="zoekterm" placeholder="Zoek een product">
                    </div>

                    <button type="submit">Filter</button>
                </form>

                <div class="product-list">
                    <a href="#" class="product-link">
                        <article class="product-item">
                            <img src="https://placehold.co/200x200" alt="">
                            <h3>Mizuno Volleybalschoenen Wave Momentum 3</h3>
                            <p class="product-category">Volleybalschoenen</p>
                            <p class="product-price">€89,99</p>
                        </article>
                    </a>

                    <a href="#" class="product-link">
                        <article class="product-item">
                            <img src="https://placehold.co/200x200" alt="">
                            <h3>Mikasa V200W Volleybal FIVB</h3>
                            <p class="product-category">Volleyballen</p>
                            <p class="product-price">€94,99</p>
                        </article>
                    </a>

                    <a href="#" class="product-link">
                        <article class="product-item">
                            <img src="https://placehold.co/200x200" alt="">
                            <h3>Volleybalshirt Unisex</h3>
                            <p class="product-category">Kleding</p>
                            <p class="product-price">€24,99</p>
                        </article>
                    </a>

                    <a href="#" class="product-link">
                        <article class="product-item">
                            <img src="https://placehold.co/200x200" alt="">
                            <h3>Kniebeschermers Mizuno</h3>
                            <p class="product-category">Bescherming</p>
                            <p class="product-price">€19,99</p>
                        </article>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> VolleyShop. Alle rechten voorbehouden.</p>
    </footer>
</body>
</html>