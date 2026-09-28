<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoppn E-Commerce</title>
    <link rel="stylesheet" href= <?= BASE_URL . '/css/style.css' ?>>
</head>
<body>
    <header>
        <div class="logo">
            <a href="index.php">
                <img src= <?= BASE_URL . '/images/logo_placeholder.jpg' ?> alt="Shoppn Logo">
            </a>
        </div>

        <div class="search-bar">
            <form action="views/search_results.php" method="GET">
                <input type="text" name="user_query" placeholder="Search for products..." required>
                <button type="submit">Search</button>
            </form>
        </div>

        <div class="cart-summary">
            <?php
                $cart_count = 0;
                $cart_total = 0.00;
            ?>
            <span>Shopping Cart - Total Items: <?= $cart_count ?> | Total Price: GHS <?= number_format($cart_total, 2) ?></span>
            <a href= <?= BASE_URL . '/views/cart.php' ?> >Go to Cart</a>
        </div>

        <nav>
            <ul>
                <li><a href= <?= BASE_URL . '/index.php' ?> >Home</a></li>
                <?php if (is_logged_in()): ?>
                    <li>Welcome, <?= htmlspecialchars($_SESSION['customer_name'] ?? 'User') ?></li>
                    <li><a href= <?= BASE_URL . '/views/account/my_account.php' ?> >My Account</a></li>

                    <!-- Admin only options -->
                    <?php if (is_admin()): ?>
                        <li><a href= <?= BASE_URL . '/views/admin/brand.php' ?> >Brands</a></li>
                        <li><a href= <?= BASE_URL . '/views/admin/category.php' ?> >Categories</a></li>
                        <li><a href= <?= BASE_URL . '/views/admin/product.php' ?> >Products</a></li>
                    <?php endif; ?>

                    <li><a href= <?= BASE_URL . '/logout.php' ?> >Logout</a></li>
                <?php else: ?>
                    <li><a href= <?= BASE_URL . '/views/register.php' ?> >Register</a></li>
                    <li><a href= <?= BASE_URL . '/views/login.php' ?> >Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
</body>
</html>