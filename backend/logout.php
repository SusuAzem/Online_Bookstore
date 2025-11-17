<?php 
include "db.php";
include "carts.php";
session_start();
session_unset();
session_destroy();
header("Location: ../login.php");
exit;
?>