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
 $output = '';  
 $sql = "SELECT * FROM surveys ORDER BY id DESC";  
 $result = mysqli_query($connection, $sql);  
 $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">  
                <tr>  
                     <th width="10%">Id</th>  
                     <th width="10%">First Name</th>  
                     <th width="10%">Last Name</th>  
                     <th width="10%">Email</th> 
                     <th width="10%">Location</th>   
                     <th width="10%">Eaten Before?</th>  
                     <th width="10%">High Proten Diet?</th>  
                     <th width="10%">Eat in Future?</th>  
                     <th width="10%">Eat cricket?</th>  
                     <th width="10%">Comments</th>  
                     <th width="10%">Delete</th>  
                </tr>';  
 $rows = mysqli_num_rows($result);
 if($rows > 0)  
 {  
	  while($row = mysqli_fetch_array($result))  
      {  
           $output .= '  
                <tr>  
                     <td>'.$row["id"].'</td>  
                     <td class="firstname" data-id1="'.$row["id"].'" contenteditable>'.$row["firstname"].'</td>  
                     <td class="lastname" data-id2="'.$row["id"].'" contenteditable>'.$row["lastname"].'</td>  
                     <td class="email" data-id3="'.$row["id"].'" contenteditable>'.$row["email"].'</td> 
                     <td class="location" data-id4="'.$row["id"].'" contenteditable>'.$row["location"].'</td> 
                     <td class="eatenbefore" data-id5="'.$row["id"].'" contenteditable>'.$row["eatenbefore"].'</td> 
                     <td class="diet" data-id6="'.$row["id"].'" contenteditable>'.$row["diet"].'</td> 
                     <td class="eatfuture" data-id7="'.$row["id"].'" contenteditable>'.$row["eatfuture"].'</td> 
                     <td class="eatcricket" data-id8="'.$row["id"].'" contenteditable>'.$row["eatcricket"].'</td> 
                     <td class="longanswer" data-id9="'.$row["id"].'" contenteditable>'.$row["longanswer"].'</td>

                     <td><button type="button" name="delete_btn" data-id10="'.$row["id"].'" class="btn btn-xs btn-danger btn_delete">x</button></td>  
                </tr>  
           ';  
      }  
      $output .= '  
           <tr>  
                <td></td>  
                <td id="firstname" contenteditable></td>  
                <td id="lastname" contenteditable></td>  
                <td id="email" contenteditable></td>
                <td id="location" contenteditable></td>
                <td id="eatenbefore" contenteditable></td>
                <td id="diet" contenteditable></td>
                <td id="eatfuture" contenteditable></td>
                <td id="eatcricket" contenteditable></td>
                <td id="longanswer" contenteditable></td>
                <td><button type="button" name="btn_add" id="btn_add" class="btn btn-xs btn-success">+</button></td>  
           </tr>  
      ';  
 }  
 else  
 {  
      $output .= '
				<tr>  
					<td></td>  
					<td id="firstname" contenteditable></td>  
					<td id="lastname" contenteditable></td>  
          <td id="email" contenteditable></td>
          <td id="location" contenteditable></td>
          <td id="eatenbefore" contenteditable></td>
          <td id="diet" contenteditable></td>
          <td id="eatfuture" contenteditable></td>
          <td id="eatcricket" contenteditable></td>
          <td id="longanswer" contenteditable></td>
					<td><button type="button" name="btn_add" id="btn_add" class="btn btn-xs btn-success">+</button></td>  
			   </tr>';  
 }  
 $output .= '</table>  
      </div>';  
 echo $output;  
 ?>