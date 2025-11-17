<?php
session_start();

# If search key is not set or empty
if (!isset($_GET['key']) || empty($_GET['key'])) {
	header("Location: index.php");
	exit;
}
$key = $_GET['key'];

include "backend/db.php";
include "backend/carts.php";
$books = search_books($connection, $key);
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
				<input type="search" placeholder="Search" aria-label="Search" name="key" />
				<button type="submit">
					<img src="img/search.png" width="20">
				</button>
			</form>
		</div>
	</header>
	<div class="main">
		Search result for <b><?= $key ?></b>
		<div class="center">
			<?php if ($books == 0) { ?>
				<div class="msg">
					<img src="img/not found.png" width="100">
					<br>
					The key <b>"<?= $key ?>"</b> didn't match to any book in the store
				</div>
			<?php } else { ?>
				<div class="items">
					<?php foreach ($books as $book) { ?>
						<div class="item">
							<img src="covers/<?= $book['cover'] ?>">
							<div class="info">
								<h5 class="title"><?= $book['title'] ?></h5>
								<p>
									<b>By:<?= $book['author'] ?></b>
									<br>
									<br>
									<i><b>Price:<?= $book['price'] ?> SR<br></b></i>
								</p>
								<a href="backend/addcart.php?book_id=<?= $book['book_id'] ?>"
									class="AsButton">Add to Cart</a>
							</div>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
	</div>
	<footer>
		<div>
			<p>&copy; <?= date('Y') ?>, Online BookStore</p>
		</div>
	</footer>
</body>

</html>