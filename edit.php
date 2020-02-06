<?php  
	// Initialize the session
    session_start();
     
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }

	// Include config file
	require_once "connect-db.php";

	$id = $_POST["id"];  
	$text = $_POST["text"];  
	$column_name = $_POST["column_name"]; 

	$sql = "UPDATE surveys SET ".$column_name."='".$text."' WHERE id='".$id."'";  
	if(mysqli_query($connection, $sql))  
	{  
		//echo 'Data Updated';  
	}  
 ?>