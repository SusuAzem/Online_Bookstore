<?php
session_start();
include "backend/db.php";
include "backend/carts.php";
if (
    isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])
) {
    
    $t = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
    $items = get_cart_items($connection, $_SESSION["user_id"]);
    $total = set_cart_total_checkout($connection, $_SESSION["user_id"]);
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
            <?php if ($items == 0) { ?>
                <div class="msg">
                    <img src="img/empty.png" width="100">
                    There is no items in the cart
                </div>
            <?php } else { ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Book</th>
                            <th class="w-75">Details</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($items as $item) {
                            $book = get_book($connection, $item['book_id']);
                            $i++;
                        ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td>
                                    <img src="covers/<?= $book['cover'] ?>" width="80">
                                    <?= $book['title'] ?>
                                </td>
                                <td>
                                    <a href="#" class="AsButton">Price
                                        <span class="cartNum"><?= $item['price'] ?>SR</span></a>
                                    <a href="#" class="AsButton">Quantity
                                        <span class="cartNum"><?= $item['qty'] ?></span></a>
                                    <a href="#" class="AsButton">Subtotal
                                        <span class="cartNum">
                                            <?= $item['price'] * $item['qty'] ?>SR
                                        </span></a>                                  
                                </td>
                                <td>
                                    <a class="AsButton red" href="backend/remove_item.php?book_id=<?= $item['book_id'] ?>"
                                        >
                                        Remove</a>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>

            <div>
                <a href="#" class="AsButton">Total
                    <span class="cartNum"><?= $total ?>SR</span></a>
                <a href="checkout.php" class="AsButton">Checkout</a>
            </div>
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