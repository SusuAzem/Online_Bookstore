<?php
session_start();

if (
    isset($_POST['full_name']) &&
    isset($_POST['email']) &&
    isset($_POST['phone']) &&
    isset($_POST['password'])
) {
    include "db.php";
    include "funcs.php";
    include "users.php";

    $admin_email1 = "admin@book.com";
    $admin_email2 = "super@store.com";


    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    # validation

    is_empty(var: $email, text: "Email", file: "../register.php", msg: "error", data: "");
    is_empty($password, "Password", "../register.php", "error", "");
    is_empty(var: $full_name, text: "Full Name", file: "../register.php", msg: "error", data: "");
    is_empty(var: $phone, text: "Phone", file: "../register.php", msg: "error", data: "");

    # check the email
    $sql = "SELECT * FROM users WHERE email=?";
    $statement = $connection->prepare($sql);
    $statement->execute([$email]);

    if ($statement->rowCount() === 1) {
        $em = "Email already exists";
        header("Location: ../register.php?error=$em");
    } else {
        $user["full_name"] = $full_name;
        $user["phone"] = $phone;
        $user["password"] = password_hash($password, PASSWORD_DEFAULT);
        $user["email"] = $email;
        if ($email == $admin_email1 or $email == $admin_email2) {
            $user["role"] = "admin";
        } else {
            $user["role"] = "user";
        }
        $res = seve_user($connection, $user);
        if ($res) {
            $msg = "The user successfully created!";
            # set session array
            if ($res["role"] == "admin") {
                $_SESSION['admin_id'] = $res["user_id"];
                $_SESSION['admin_email'] = $res["email"];
                header(header: "Location: ../admin/dashboard.php");
            } else if ($res["role"] === "user") {
                $_SESSION['user_id'] = $res["user_id"];
                $_SESSION['user_email'] = $res["email"];
                $_SESSION["cart"]["user_id"];
                create_cart($connection, $user);
                header("Location: ../index.php");
            }
        } else {
            $msg = "Unknown Error Occurred!";
            header("Location: ../register.php?error=$msg");
        }
        
    }
} else {
    $em = "please fill in the form";
    header("Location: ../register.php?error=$em");
}
