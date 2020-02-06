<?php
    // Initialize the session
    session_start();
     
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html> 
    <head>  
        <title>Alternative Protein Source | Admin Area</title>  
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <link href="https://fonts.googleapis.com/css?family=Oswald:400,500,700" rel="stylesheet">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
    </head>  
    <body>  
        <section id="admin">
            <div class="container">  
                <main>
                    <h1 class="header-font">ADMIN AREA</h1>
                    <div class="admin-area-grid">
                        <h2 class="sub-header-font">User survey data</h2>
                        <a href='logout.php' class="btn btn-danger log-out-btn">Log out</a>
                    </div>
                    <div class="table-responsive">  	
        				<span id="result"></span>
        				<div id="live_data"></div>                 
        			</div>  
                </main>
    		</div>
        </section>

    
    </body>  
</html>  
<script>  
$(document).ready(function(){  
    function fetch_data()  
    {  
        $.ajax({  
            url:"select.php",  
            method:"POST",  
            success:function(data){  
				$('#live_data').html(data);  
            }  
        });  
    }  
    fetch_data();  
    $(document).on('click', '#btn_add', function(){ 

        var firstname = $('#firstname').text();  
        var lastname = $('#lastname').text();  
        var email = $('#email').text();  
        var location = $('#location').text();  
        var eatenbefore = $('#eatenbefore').text();  
        var diet = $('#diet').text();  
        var eatfuture = $('#eatfuture').text();  
        var eatcricket = $('#eatcricket').text();  
        var longanswer = $('#longanswer').text();  


        if(firstname == '')  
        {  
            alert("Enter First Name");  
            return false;  
        }  
        if(lastname == '')  
        {  
            alert("Enter Last Name");  
            return false;  
        }  
        if(email == '')  
        {  
            alert("Enter Email");  
            return false;  
        } 
        if(location == '')  
        {  
            alert("Enter Location");  
            return false;  
        }   
        $.ajax({  
            url:"insert.php",  
            method:"POST",  
            data:{firstname:firstname, lastname:lastname, email:email, location:location, eatenbefore:eatenbefore, diet:diet, eatfuture:eatfuture, eatcricket:eatcricket, longanswer:longanswer},  
            dataType:"text",  
            success:function(data)  
            {  
                //alert('Data Inserted');  
                fetch_data();  
            }  
        })  
    });  
    
	function edit_data(id, text, column_name)  
    {  
        $.ajax({  
            url:"edit.php",  
            method:"POST",  
            data:{id:id, text:text, column_name:column_name},  
            dataType:"text",  
            success:function(data){  
                //alert('Data Updated');
				//$('#result').html("<div class='alert alert-success'>"+data+"</div>");
            }  
        });  
    }  
    $(document).on('blur', '.firstname', function(){  
        var id = $(this).data("id1");  
        var firstname = $(this).text();  
        edit_data(id, firstname, "firstname");  
    });  
    $(document).on('blur', '.lastname', function(){  
        var id = $(this).data("id2");  
        var lastname = $(this).text();  
        edit_data(id,lastname, "lastname");  
    });  
    $(document).on('blur', '.email', function(){  
        var id = $(this).data("id3");  
        var email = $(this).text();  
        edit_data(id,email, "email");  
    });
    $(document).on('blur', '.location', function(){  
        var id = $(this).data("id4");  
        var location = $(this).text();  
        edit_data(id,location, "location");  
    });
    $(document).on('blur', '.eatenbefore', function(){  
        var id = $(this).data("id5");  
        var eatenbefore = $(this).text();  
        edit_data(id,eatenbefore, "eatenbefore");  
    });
    $(document).on('blur', '.diet', function(){  
        var id = $(this).data("id6");  
        var diet = $(this).text();  
        edit_data(id,diet, "diet");  
    });
    $(document).on('blur', '.eatfuture', function(){  
        var id = $(this).data("id7");  
        var eatfuture = $(this).text();  
        edit_data(id,eatfuture, "eatfuture");  
    });
    $(document).on('blur', '.eatcricket', function(){  
        var id = $(this).data("id8");  
        var eatcricket = $(this).text();  
        edit_data(id,eatcricket, "eatcricket");  
    });
    $(document).on('blur', '.longanswer', function(){  
        var id = $(this).data("id9");  
        var longanswer = $(this).text();  
        edit_data(id,longanswer, "longanswer");  
    });



    $(document).on('click', '.btn_delete', function(){  
        var id=$(this).data("id10");  
        if(confirm("Are you sure you want to delete this?"))  
        {  
            $.ajax({  
                url:"delete.php",  
                method:"POST",  
                data:{id:id},  
                dataType:"text",  
                success:function(data){  
                    //alert(data);  
                    fetch_data();  
                }  
            });  
        }  
    });  
});  
</script>