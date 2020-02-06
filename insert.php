<?php  
// Include config file
require_once "connect-db.php";

$sql = "INSERT INTO surveys (firstname, lastname, email, location, eatenbefore, diet, eatfuture, eatcricket, longanswer) VALUES('".$_POST["firstname"]."', '".$_POST["lastname"]."', '".$_POST["email"]."', '".$_POST["location"]."', '".$_POST["eatenbefore"]."', '".$_POST["diet"]."', '".$_POST["eatfuture"]."', '".$_POST["eatcricket"]."', '".$_POST["longanswer"]."')";  
if(mysqli_query($connection, $sql))  
{  
     //echo 'Data Inserted';  
}  
 ?>