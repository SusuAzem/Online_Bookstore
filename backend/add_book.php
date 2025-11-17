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
        isset($_POST['book_price'])       &&
        isset($_FILES['book_cover'])
    ) {

        $title       = $_POST['book_title'];
        $description = $_POST['book_description'];
        $author      = $_POST['book_author'];
        $category    = $_POST['book_category'];
        $price       = $_POST['book_price'];

        $cover_dir = "../covers/";
        $target_cover = $cover_dir . basename($_FILES["book_cover"]["name"]);
        $uploadOk = 1;
        $coverType = strtolower(pathinfo($target_cover, PATHINFO_EXTENSION));

        #validation
        $location = "../add-book.php";
        $ms = "error";
        is_empty($title, "book title", $location, $ms, "");
        is_empty($description, "book description", $location, $ms, "");
        is_empty($author, "book author", $location, $ms, "");
        is_empty($category, "book category", $location, $ms, "");
        is_empty($price, "book price", $location, $ms, "");


        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["book_cover"]["tmp_name"]);
            if ($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }

        if (file_exists($target_cover)) {
            $uploadOk = 0;
            $error_msg = "Sorry, file already exists.";
            header("Location: ../admin/add_book.php?error=$error_msg");
            exit;
        }

        // Check file size (e.g., limit to 500KB)
        if ($_FILES["book_cover"]["size"] > 500000) {
            $uploadOk = 0;
            $error_msg = "Sorry, your file is too large.";
            header("Location: ../admin/add_book.php?error=$error_msg");
            exit;
        }

        // Allow certain file formats
        if (
            $coverType != "jpg" && $coverType != "png" && $coverType != "jpeg"
            && $coverType != "gif"
        ) {
            $uploadOk = 0;
            $error_msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            header("Location: ../admin/add_book.php?error=$error_msg");
            exit;
        }


        # insert into database
        $b["title"]       = $title;
        $b["description"] = $description;
        $b["price"]       = $price;
        $b["author"]      = $author;
        $b["category"]    = $category;
        $b["cover"]       = $_FILES["book_cover"];
        $b = insert_book($connection, $b);

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $error_msg = "Sorry, your file was not uploaded.";
            header("Location: ../admin/add_book.php?error=$error_msg");
            exit;
        } else {
            if (move_uploaded_file($_FILES["book_cover"]["tmp_name"], $target_cover) & ($b)) {
                # success message
                $msg = "The book successfully created! The file has been uploaded.";
                header("Location: ../admin/view_books.php?success=$msg");
            } else {
                $error_msg = "Sorry, Unknown Error Occurred!.";
                header("Location: ../admin/view_books.php?error=$msg");
                exit;
            }
        }
    } else {
        $error_msg = "Sorry, there was an error adding the book.";
        header("Location: ../admin/add_book.php?error=$error_msg");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
