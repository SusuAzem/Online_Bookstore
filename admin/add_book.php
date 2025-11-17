<?php
session_start();
include "../backend/db.php";
# If the admin is logged in
if (
    isset($_SESSION['admin_id']) &&
    isset($_SESSION['admin_email'])
) {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
		<meta charset="UTF-8">
		<title>Add book</title>
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
		<div class="main center">
            <form action="../backend/add_book.php" method="post" enctype="multipart/form-data" class="logging">
                <h1>Add New Book</h1>
                <?php if (isset($_GET['error'])) { ?>
                    <div class="msg">
                        <?= htmlspecialchars($_GET['error']); ?>
                    </div>
                <?php } ?>
                <?php if (isset($_GET['success'])) { ?>
                    <div class="msg">
                        <?= htmlspecialchars($_GET['success']); ?>
                    </div>
                <?php } ?>
                <div class="m">
                    <label> Title</label>
                    <input type="text" name="book_title" required>
                </div>

                <div class="m">
                    <label >Author</label>
                    <input type="text" name="book_author" required>
                </div>

                <div class="m">
                    <label>Description</label>
                    <input type="text" name="book_description" required>
                </div>

                <div class="m">
                    <label>Category</label>
                    <input type="text" name="book_category" required>
                </div>

                <div class="m">
                    <label>Price</label>
                    <input type="number" name="book_price" required>
                </div>

                <div class="m">
                    <label>Cover</label>
                    <input type="file" name="book_cover" required>
                </div>

                <button type="submit" name="submit">Add Book</button>
            </form>
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