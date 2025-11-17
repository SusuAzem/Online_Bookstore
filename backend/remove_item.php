<?php
include "carts.php";
if (isset($_GET['book_id']) && is_numeric($_GET['book_id']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['book_id']])) {
    unset($_SESSION['cart'][$_GET['book_id']]);
    $res = remove_item($connection, $_GET['book_id']);
    if ($res) {
        # success message
        $sm = "Successfully removed!";
        header("Location: ../cart.php?success=$sm");
        exit;
    } else {
        # Error message
        $em = "Unknown Error Occurred!";
        header("Location: ../cart.php?error=$em");
        exit;
    }
}
