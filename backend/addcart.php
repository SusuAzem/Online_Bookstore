<?php
session_start();

if (
    isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])
) {

    include "db.php";
    include "carts.php";

    if (isset($_GET['book_id'])) {

        $book_id = $_GET['book_id'];
        $book = get_book($connection, $book_id);
        if ($book) {
            if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                if (array_key_exists($book_id, $_SESSION['cart'])) {               
                    $_SESSION['cart'][$book_id] += 1;
                } else {                
                    $_SESSION['cart'][$book_id] = 1;
                }
            } else {
                $_SESSION['cart'] = array($book_id => 1);
            }
        }
        $cartitem = insert_item($connection, $_SESSION['user_id'], $book_id);
        if ($cartitem) {
            $msg = "Book added to cart successfully.";
            header("Location: ../index.php?success=$msg");
            exit();         
        } else {
            $error_msg = "Sorry, there was an error adding the book to the cart.";
            header("Location: ../index.php?error=$error_msg");
        }
    }
    // Prevent form resubmission...
    header('location: ../index.php');
} else {
    header("Location: ../login.php");      
}
?>
