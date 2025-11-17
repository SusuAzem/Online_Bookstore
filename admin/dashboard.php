<?php
session_start();
if (
	isset($_SESSION['admin_id']) &&
	isset($_SESSION['admin_email'])

) {
?>

	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<title>ADMIN</title>
		<link rel="stylesheet" href="../css/style.css">
		<link rel="icon" type="image/png" href="../img/favicon.png">
	</head>

	<body>
		<header class="steaky">
			<div class="menue">
				<a class="name link" href="../index.php">
					Online BookStore
					<img class="logo" src="../img/icon.png" width="100" height="100" alt="">
				</a>
				<a class="link" href="add_book.php">Add Book</a>
				<a class="link" href="view_books.php">Books</a>
				<a class="link" href="orders.php">Orders</a>
				<a class="link" href="users.php">Users</a>
				<a class="link" href="../backend/logout.php">Logout</a>
				<form class="search" role="search" action="search.php" method="GET">
					<input type="search" placeholder="Search" aria-label="Search" name="key" />
					<button type="submit">
						<img src="../img/search.png" width="20">
					</button>
				</form>
			</div>
		</header>
		<div class="main">
			<div class="center">
				<h2>Admin Dashboard</h2>
				<p>Welcome, <?php echo $_SESSION['admin_email'] ?></p>
			</div>
		</div>
		<?php
		if (isset($_GET['error'])) { ?>
			<div class="msg">
				<?php echo htmlspecialchars($_GET['error']); ?>
			</div>
		<?php } ?>
		</div>
		<footer>
		<div>
			<p>&copy; <?= date('Y') ?>, Online BookStore</p>
		</div>
	</footer>
	</body>

	</html>
<?php } else {
	header("Location: login.php");
	exit;
} ?>