<html>
	<head>
		<title>21 shop</title>
		<link rel="stylesheet" href="front/includes/css/custom.css">
		<link href="front/includes/fonts/fontawesome/css/fontawesome.css" rel="stylesheet">
		<link href="front/includes/fonts/fontawesome/css/all.css" rel="stylesheet">
	</head>
	<body class="body">
		<header class="header">
			<div class="container">
				<nav class="nav">
					<a class="nav__home" href="/"><i class="fas fa-home icon"></i></a>
					<div class="btn-group">
						<a class="nav__catalog" href="/catalog.php" class="nav__link">Catalog</a>
						<?php if ( is_logged() ): ?>
							<a class="nav__profile" href="/profile.php"><?php echo $_SESSION["logged_in_user"]; ?></a>
							<a class="nav__logout" href="/front/methods/logout.php">Logout</a>
						<?php else: ?>
							<a class="nav__sign-in" href="/profile.php">Sign In</a>
							<a class="nav__sign-up" href="/register.php">Sign Up</a>
						<?php endif; ?>
					</div>
					<a class="nav__cart" href="cart.php"><i class="fas fa-shopping-cart icon"></i></a>
				</nav>
			</div>
        </header>
        <main class="content">