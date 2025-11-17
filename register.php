<?php
session_start();

include "backend/db.php";
$t = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Online BookStore</title>
	<link rel="icon" type="image/png" href="img/favicon.png">
	<link rel="stylesheet" href="css/style.css">
</head>

<body>
	<header class="steaky">
		<div class="menue">
			<a class="name link" href="index.php">
				Online BookStore
				<img class="logo" src="img/icon.png" width="100" height="100" alt="">
			</a>
			<a class="link" href="Contact.php">Contact Us</a>
			<a class="link" href="cart.php">
				<img src="img/cart.png" width="20">
				<span class="cartNum"><?= $t ?></span>
			</a>
			<?php if (isset($_SESSION['admin_id'])) { ?>
				<a class="link" href="admin/dashboard.php">Admin</a>
				<a class="link" href="backend/logout.php">Logout</a>
			<?php } else if (isset($_SESSION['user_id'])) { ?>
				Hello <?= $_SESSION['user_email'] ?>
				<a class="link" href="backend/logout.php">Logout</a>
			<?php } else { ?>
				<a class="link" href="login.php">Login</a>
			<?php } ?>
		
		<form class="search" role="search" action="search.php" method="GET">
			<input type="search" placeholder="Search" aria-label="Search" name="key" class="search"/>
			<button type="submit">
				<img src="img/search.png" width="20">
			</button>
		</form>
	</div>
	</header>
	<div class="main center">
		<form class="logging" method="POST" action="backend/register.php">
			<h1>Register</h1>
			<?php
			if (isset($_GET['error'])) { ?>
				<div class="msg">
					<?php echo htmlspecialchars($_GET['error']); ?>
				</div>
			<?php } ?>
			<div class="m">
				<label for="full_name">Full Name</label>
				<input type="text" name="full_name" id="full_name" required>
			</div>

			<div class="m">
				<label for="email">Email address</label>
				<input type="email" name="email" id="email" required>
			</div>

			<div class="m">
				<label for="phone">Phone</label>
				<input type="number" name="phone" id="phone" required>
			</div>

			<div class="m">
				<label for="password">Password</label>
				<input type="password" name="password" id="password" required>
			</div>
			<button type="submit">Register</button>
		</form>
	</div>
	<footer>
		<div>
			<p>&copy; <?= date('Y') ?>, Online BookStore</p>
		</div>
	</footer>
</body>

</html>