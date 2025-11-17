<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['admin_id']) &&
    isset($_SESSION['admin_email'])) {

	include "db.php";
	if (isset($_GET['book_id'])) {
		$id = $_GET['book_id'];

		# form Validation
		if (empty($id)) {
			$em = "Error Occurred!";
			header("Location: ../admin/dashboard.php?error=$em");
            exit;
		}else {
			 $sql  = "SELECT * FROM books WHERE book_id=?";
			 $statement = $connection->prepare($sql);
			 $statement->execute([$id]);
			 $book = $statement->fetch();
			 if($statement->rowCount() > 0){
				$sql2  = "DELETE FROM books WHERE book_id=?";
				$statement2 = $connection->prepare($sql2);
				$res  = $statement2->execute([$id]);               
			     if ($res) {			     	
                    $cover = $book['cover'];
                    $cover_path = "../covers/$cover";                   
                    unlink($cover_path);
                    
			     	# success message
			     	$sm = "Successfully removed!";
					header("Location: ..admin/view_book.php?success=$sm");
		            exit;
			     }else{
			     	# Error message
			     	$em = "Unknown Error Occurred!";
					header("Location: ../admin/dashboard.php?error=$em");
		            exit;
			     }
			 }else {
			 	$em = "Error Occurred! file not found.";
			    header("Location: ../admin/dashboard.php?error=$em");
                exit;
			 }
             
		}
	}else {
      header("Location: ../admin/dashboard.php");
      exit;
	}

}else{
  header("Location: ../login.php");
  exit;
}