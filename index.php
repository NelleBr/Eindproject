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
                    <a href="#">Home</a>
                    <a href="#">Producten</a>
                    <a href="#">Winkelmandje</a>
                    <a href="#">Account</a>
                </div>
            </nav>
        </div>
    </header>
    <section id="intro">
        <div class="container">
            <h2>Alles voor jouw volleybalspel</h2>
            <p>Koop schoenen, kleding, volleyballen en accessoires speciaal voor volleybal.</p>
            <a href="#" class="button">Bekijk onze poducten</a>
        </div>
    </section>


    <section id="categories">
        <div class="container">
            <h2>Categorieën</h2>
            <div class="category-list">
                <article class="category-item">
                    <h3>Volleybalschoenen</h3>
                    <p>Goede grip en demping voor op het veld.</p>
                </article>
                <article class="category-item">
                    <h3>Kleding</h3>
                    <p>Shirts, shorts en trainingskleding voor volleybal.</p>
                </article>
                <article class="category-item">
                    <h3>Volleyballen</h3>
                    <p>Wedstrijd- en trainingsballen voor indoor en beach.</p>
                </article>
                <article class="category-item">
                    <h3>Bescherming</h3>
                    <p>Kniebeschermers, enkelbraces en andere bescherming.</p>
                </article>
                <article class="category-item">
                    <h3>Accessoires</h3>
                    <p>Tassen, bidons, sokken en meer.</p>
                </article>
            </div>
        </div>
    </section>

    <section id="featured-products">
        <div class="container">
            <h2>Uitgelichte producten</h2>
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
    <footer>
        <p>&copy; <?php echo date('Y'); ?> VolleyShop. Alle rechten voorbehouden.</p>
    </footer>
</body>

</html>