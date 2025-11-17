<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$total = isset($_GET['total']) ? $_GET['total'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Success</title>
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
			<input type="search" placeholder="Search" aria-label="Search" name="key" />
			<button type="submit">
				<img src="img/search.png" width="20">
			</button>
		</form>
	</div>
	</header>
<div class="main center">
    <h1>✅ Order Placed Successfully!</h1>
    <p>Thank you for your purchase.</p>
    <p><b>Total Paid:</b> <?= $total ?> SR</p>
    <a href="my_orders.php" class="AsButton">View My Orders</a>
</div>
<footer>
		<div>
			<p>&copy; <?= date('Y') ?>, Online BookStore</p>
		</div>
	</footer>
</body>
</html>
