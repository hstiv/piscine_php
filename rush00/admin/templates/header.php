<html>
    <head>
        <title>Admin Page</title>
    </head>
    <body>
        <header>
            <div class="admin__menu">
                <a href="/index.php">Shop</a>
                <?php if ( is_admin() ): ?>
                    <a href="/admin/news.php">News</a>
                    <a href="/admin/categories.php">Categories</a>
                    <a href="/admin/orders.php">Orders</a>
                    <a href="/admin/products.php">Products</a>
                    <?php if ( is_root() ): ?>
                        <a href="/admin/users.php">Users</a>
                    <? endif; ?>
                    <a href="/admin/methods/logout.php">Log Out</a>
                <?php endif; ?>
            </div>
        </header>
        <main>