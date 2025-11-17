<?php
session_start();
include "../backend/db.php";
include "../backend/books.php";
$books = list_books($connection);
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
            <?php if ($books == 0) { ?>
                <div class="msg">
                    <img src="../img/empty.png" width="100">
                    There is no book in the database
                </div>
            <?php } else { ?>
                <h4>All Books</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($books as $book) {
                            $i++;
                        ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td>
                                    <img src="../covers/<?= $book['cover'] ?>" width="80">
                                    <br>
                                    <?= $book['title'] ?>
                                </td>
                                <td><?= $book['author'] ?></td>
                                <td><?= $book['description'] ?></td>
                                <td><?= $book['category'] ?></td>
                                <td>
                                    <a href="#" class="AsButton">Price
                                        <span class="cartNum"><?= $book['price'] ?>SR</span></a>
                                    <a href="edit_book.php?book_id=<?= $book['book_id'] ?>"
                                        class="AsButton">Edit</a>
                                    <a href="../backend/delete_book.php?book_id=<?= $book['book_id'] ?>"
                                        class="AsButton red">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
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