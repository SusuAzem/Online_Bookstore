<?php

session_start();

if (
    isset($_SESSION['admin_id']) &&
    isset($_SESSION['admin_email'])
) {

    include "db.php";
    include "funcs.php";
    include "books.php";

    if (
        isset($_POST['book_title'])       &&
        isset($_POST['book_description']) &&
        isset($_POST['book_author'])      &&
        isset($_POST['book_category'])    &&
        isset($_POST['book_price'])
    ) {
        $id          = $_POST['book_id'];
        $title       = $_POST['book_title'];
        $description = $_POST['book_description'];
        $author      = $_POST['book_author'];
        $category    = $_POST['book_category'];
        $price       = $_POST['book_price'];
        $current_cover = $_POST['current_cover'];
        $img_updated = false;

        $b["book_id"]     = $id;
        $b["title"]       = $title;
        $b["description"] = $description;
        $b["price"]       = $price;
        $b["author"]      = $author;
        $b["category"]    = $category;
        $b["price"]       = $price;

        if (isset($_FILES['book_cover']) && $_FILES['book_cover']['error'] == 0) {
            $cover_dir = "../covers/";
            $new_cover = $cover_dir . basename($_FILES["book_cover"]["name"]);
            $coverType = strtolower(pathinfo($new_cover, PATHINFO_EXTENSION));
            #validation
           /*  $location = "../admin/edit_book.php";
            $ms = "error";
            is_empty($title, "book title", $location, $ms, "");
            is_empty($description, "book description", $location, $ms, "");
            is_empty($author, "book author", $location, $ms, "");
            is_empty($category, "book category", $location, $ms, "");
            is_empty($price, "book price", $location, $ms, ""); */
           
            $check = getimagesize($_FILES["book_cover"]["tmp_name"]);
            if ($check == false) {
                $error_msg = "File is not an image.";
                header("Location: ../admin/edit_book.php?error0=$error_msg");
                exit;
            }

            if (file_exists($new_cover)) {
                $error_msg = "Sorry, file already exists.";
                header("Location: ../admin/edit_book.php?error1=$error_msg");
                exit;
            }

            // Check file size (e.g., limit to 500KB)
            if ($_FILES["book_cover"]["size"] > 500000) {
                $error_msg = "Sorry, your file is too large.";
                header("Location: ../admin/edit_book.php?error2=$error_msg");
                exit;
            }

            // Allow certain file formats
            if (
                $coverType != "jpg" or $coverType != "png" or $coverType != "jpeg"
                or $coverType != "gif"
            ) {
                $error_msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                header("Location: ../admin/edit_book.php?error3=$error_msg");
                exit;
            }

            if (move_uploaded_file($_FILES["book_cover"]["tmp_name"], $new_cover)) {
                # insert into database
                $b["cover"] = $new_cover;
                $book = update_book($connection, $b);
                $img_updated = true;
                unlink($current_cover);
                # success message
                $msg = "The book successfully updated! The file has been uploaded.";
                header("Location: ../admin/view_books.php?success=$msg");
                exit;
            } else {
                unlink($new_cover);
                $error_msg = "Sorry, Unknown Error Occurred!.";
                header("Location: ../admin/edit_book.php?error4=$msg");
                exit;
            }
        }

        if (!$img_updated) {
            // Update only item_name if no new image was uploaded
            $b["cover"] = $current_cover;
            $book = update_book($connection, $b);
        }
        if ($book) {
            # success message
            $msg = "The book successfully updated!";
            header("Location: ../admin/view_books.php?success=$msg");
            exit;
        } else {
            $error_msg = "Error updating book ";
            header("Location: ../admin/edit_book.php?error5=$msg");
            exit;
        }
    } else {
        $error_msg = "Sorry, Unknown Error Occurred!.";
        header("Location: ../admin/edit_book.php?error5=$msg");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
