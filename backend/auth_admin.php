<?php 
session_start();

if (isset($_POST['email']) && 
	isset($_POST['password'])) {
    
    # Database File
	include "db.php";	
	include "funcs.php";
	include "carts.php";

	$email = $_POST['email'];
	$password = $_POST['password'];

	# validation

	is_empty(var: $email, text: "Email", file: "../login.php", msg: "error", data: "");
 	is_empty($password, "Password", "../login.php", "error", "");

    # lookup the email
    $sql = "SELECT * FROM users WHERE email=?";
    $statement = $connection->prepare($sql);
    $statement ->execute([$email]);

    if ($statement->rowCount() === 1) {
    	$user = $statement->fetch();
		# fetch user data from database
    	$user_id = $user['user_id'];
    	$user_email = $user['email'];
    	$user_password = $user['password'];
		$user_role = $user['role'];
		if ($user_role === "admin") {
			if (password_verify($password, $user_password)) {
				# setting session data adter login success
    			$_SESSION['admin_id'] = $user_id;
    			$_SESSION['admin_email'] = $user_email;
    			header("Location: ../admin/dashboard.php");
    		}else {
    	        $em = "Incorrect password admin .. try again";
    	        header("Location: ../login.php?error=$em");
    		}   		
    	}else if ($user_role === "user"){
			if (password_verify($password, $user_password)) {
				# setting session data adter login success
    			$_SESSION['user_id'] = $user_id;
    			$_SESSION['user_email'] = $user_email;
				$_SESSION['cart'] = get_cart_items($connection, $user_id);
    			header("Location: ../index.php");
    		}else {
    	        $em = "Incorrect password .. try again";
    	        header("Location: ../login.php?error=$em");
    		}   		   	    
    	}
    }else{
    	$em = "Incorrect email or password";
    	header("Location: ../login.php?error=$em");
    }
}else {
	$em = "please fill in the email and password";
	header("Location: ../login.php");
}
