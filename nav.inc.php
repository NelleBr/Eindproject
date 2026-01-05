<header>
    <div class="container">
        <h1>VolleyShop</h1>
        <nav>
            <div>
                <a href="index.php">Home</a>
                <a href="producten.php">Producten</a>
                <a href="cart.php">Winkelmandje</a>
                <a href="account.php">Account</a>

                <?php if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 1): ?>
                    <a href="admin.php">Admin</a>
                <?php endif; ?>
            </div>
        </nav>
    </div>
</header>