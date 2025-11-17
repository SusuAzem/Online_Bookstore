<?php
session_start();

include "../backend/db.php";
include "../backend/users.php";
$users = list_users($connection);
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
            <?php if ($users == 0) { ?>
                <div class="msg">
                    <img src="../img/empty.png" width="100">
                    There is no users in the database
                </div>
            <?php } else { ?>
                <h4>All Users</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($users as $user) {
                            $i++;
                        ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $user['full_name'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td><?= $user['phone'] ?></td>
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