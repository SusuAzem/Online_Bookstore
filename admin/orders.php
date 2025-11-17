<?php
session_start();
include "../backend/db.php";
include "../backend/orders.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}

$orders = get_all_orders($connection);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Orders</title>
    <link rel="stylesheet" href="../css/style.css">
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
                <a class="link" href="order.php">Orders</a>
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
<div class="main center">
    <h1>All Customer Orders</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Total (SR)</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order) { ?>
                <tr>
                    <td><?= $order['order_id'] ?></td>
                    <td><?= $order['full_name'] ?></td>
                    <td><?= $order['total'] ?></td>
                    <td><?= $order['status'] ?></td>
                    <td><?= $order['created_at'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<footer>
		<div>
			<p>&copy; <?= date('Y') ?>, Online BookStore</p>
		</div>
	</footer>
</body>
</html>
