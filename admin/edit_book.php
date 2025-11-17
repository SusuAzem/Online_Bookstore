<?php
session_start();

# If the admin is logged in
if (
    isset($_SESSION['admin_id']) &&
    isset($_SESSION['admin_email'])
) {

    if (!isset($_GET['book_id'])) {
        header("Location: dashboard.php");
        exit;
    }

    $id = $_GET['book_id'];

    include "../backend/db.php";
    include "../backend/books.php";
    $book = get_book(connection: $connection, id: $id);

    if ($book == 0) {
        header("Location: dashboard.php");
        exit;
    }
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Edit book</title>
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
                <form class="search" role="search" action="../search.php" method="GET">
                    <input type="search" placeholder="Search" aria-label="Search" name="key" />
                    <button type="submit">
                        <img src="../img/search.png" width="20">
                    </button>
                </form>
            </div>
        </header>
        <div class="main center">
            <form action="../backend/edit_book.php" method="post" enctype="multipart/form-data"
                class="logging">
                <h1>Edit Book</h1>
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
                    <label>Title</label>
                    <input type="text" class="hidden" value="<?= $book['book_id'] ?>" name="book_id">
                    <input type="text" value="<?= $book['title'] ?>" name="book_title">
                </div>

                <div class="m">
                    <label>Description</label>
                    <input type="text" value="<?= $book['description'] ?>" name="book_description">
                </div>

                <div class="m">
                    <label>Author</label>
                    <input type="text" value="<?= $book['author'] ?>" name="book_author">
                </div>

                <div class="m">
                    <label>Category</label>
                    <input type="text" value="<?= $book['category'] ?>" name="book_category">

                </div>

                 <div class="m">
                    <label>Price</label>
                    <input type="number" value="<?= $book['price'] ?>" name="book_price">

                </div>

                <div class="m">
                    <label>Cover</label>
                    <input type="file" name="book_cover">
                    <input type="text" name="current_cover" class="hidden" value="<?=$book['cover']?>">
                </div>
                <button type="submit">Update</button>
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
    header("Location: ../login.php");
    exit;
} ?>