<?php
session_start();
include "backend/db.php";
include "backend/carts.php";
include "backend/orders.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include "backend/db.php";
$t = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

$user_id = $_SESSION['user_id'];
$total = set_cart_total_checkout($connection, $user_id);

if (isset($_POST['place_order'])) {
    if (create_order($connection, $user_id, $total)) {
        //Delete cart contents after ordering
        $connection->query("DELETE FROM cart_items WHERE cart_id IN (SELECT cart_id FROM carts WHERE user_id='$user_id')");
        header("Location: order_success.php?total=$total");
        exit;
    } else {
        $error = "Something went wrong while placing the order.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
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
    <h1>Checkout</h1>
    <p>Total amount to pay: <b><?= $total ?> SR</b></p>

    <?php if (isset($error)) { echo "<div class='msg red'>$error</div>"; } ?>

    <form method="POST">
        <button type="submit" name="place_order" class="AsButton">Place Order</button>
    </form>
</div>
<footer>
		<div>
			<p>&copy; <?= date('Y') ?>, Online BookStore</p>
		</div>
	</footer>
</body>
</html>
