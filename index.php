<?php
// Initialize the session
session_start();
$loggedIn = false;
// Check if the user is already logged in, if yes then set the $loggedIn to true
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  $loggedIn = true;
}

// Include config file
require_once "connect-db.php";

// Define variables and initialize with empty values
$firstname = $lastname = $email = $location = $eatenbefore = $diet = $eatfuture = $eatcricket = $longanswer = "";
$error = '';





?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Alternative Protein Source | Crickets</title>
  <link rel="stylesheet" href="css/styles.css">
  <link href="https://fonts.googleapis.com/css?family=Oswald:400,500,700" rel="stylesheet">
  <script src="js/jquery-3.4.0.min.js"></script>
</head>

<body>

  <!-- Navigation -->
  <?php include('inc/nav.php') ?>

  <!-- Top Section -->
  <?php include('inc/top_section.php') ?>

  <!-- Second Section -->
  <?php include('inc/second_section.php') ?>

  <!-- Third Section -->

  <?php
  // check if the form has been submitted. If it has, start to process the form and save it to the database
    if (isset($_POST['submit'])) {
      // get form data, making sure it is valid
      $firstname = mysqli_real_escape_string($connection, htmlspecialchars($_POST['firstname']));
      $lastname = mysqli_real_escape_string($connection, htmlspecialchars($_POST['lastname']));
      
      $email = mysqli_real_escape_string($connection, htmlspecialchars($_POST['email']));
      $location = mysqli_real_escape_string($connection, htmlspecialchars($_POST['location']));
      // check to make sure both fields are entered
      if ($firstname == '' || $lastname == ''  || $email == '' || $location == '') {
        // generate error message
        $error = 'ERROR: Please fill in all required fields! ';

        // if either field is blank, display the form again
        renderForm(true, $id, $firstname, $lastname, $email,$location , $eatenbefore , $diet , $eatfuture, $eatcricket, $longanswer, $error);

      } else {



        if(isset($_POST['eatenbefore'])){
                $eatenbefore = $_POST['eatenbefore'];
              }
        else {
            $eatenbefore = '';
        } 
        if(isset($_POST['protein_answer'])){
                $diet = $_POST['protein_answer'];
              }
        else {
            $diet = '';
        } 

        if(isset($_POST['eating_answer'])){
                $eatfuture = $_POST['eating_answer'];
              }
        else {
            $eatfuture = '';
        } 
         
        
        if(isset($_POST['eatCricket'])){
          $eatcricket = $_POST['eatCricket'];
        }
        else{
          $eatcricket ='';
        }

        if(isset($_POST['longanswer'])){
                $longanswer = $_POST['longanswer'];
              }
        else {
            $longanswer = '';
        } 


        // save the data to the database
        $result = mysqli_query($connection, "INSERT INTO surveys (firstname, lastname, email, location, eatenbefore, diet, eatfuture, eatcricket, longanswer) VALUES ('$firstname', '$lastname', '$email', '$location', '$eatenbefore', '$diet',  '$eatfuture', '$eatcricket', '$longanswer'  )");
        #$result = mysqli_query($connection, "INSERT INTO surveys (firstname, lastname, email, location, eatenbefore, diet, eatfuture, eatcricket, longanwer) VALUES ('$firstname', '$lastname', '$email', '$location', '$eatenbefore', '$diet',  '$eatfuture', ' $eatcricket', ' $longanswer'  )");
        
        

        $eatCricketArray = array('Not Likely','Somewhat Not Likely','Neutral','Somewhat Likely','Very Likely');

        // $value = (int)$eatcricket;
        // $cricketAnswer = $eatCricketArray[ ($value -1)];


        $cricketAnswer = $eatCricketArray[(int)$eatcricket-1] ;
        // Send email
        $email_subject = 'The Food of the Future: Survey Submission';
        $email_body = "Thank you for participating in our survey!\n\nName: $firstname $lastname \n\nEmail: $email \n\nLocation: $location \n\nHave you ever eaten insects: $eatenbefore \n\nDo you have a high protein diet?: $diet \n\nWould you consider eating insects?: $eatfuture \n\nHow likely are you to eat a cricket?:  \n\nDo you think we will globally move to crickets as a course of protein in the future?: $longanswer ";

        $mailSent = mail($email, $email_subject, $email_body);
        if ($mailSent == true){
          renderForm(false, $id, $firstname, $lastname, $email,$location , $eatenbefore , $diet , $eatfuture, $eatcricket, $longanswer, $error);
        // once saved, redirect back to the view page
        #header('Location: #survey');
        
        echo '<script type="text/javascript">
          $("html,body").animate({
              scrollTop: $("#survey").offset().top
          },
             0);
        </script>';
        
        }
        else{ 
          $error = 'Problem Sending email';
          renderForm(true, $id, $firstname, $lastname, $email,$location , $eatenbefore , $diet , $eatfuture, $eatcricket, $longanswer, $error);
        }

        
      }
    } else {
      renderForm(true,'','','','','','', '','','','','');
    }



  // creates the edit record form
  function renderForm($showForm, $id, $firstname, $lastname, $email, $location , $eatenbefore , $diet , $eatfuture, $eatcricket, $longanswer, $error) {
    if ($showForm === true){


  ?>
  <main>
    <section id="survey">
      <div class="container">

        

          <h2>TAKE THE SURVEY</h2>
          <?php 
          if ($error!= ''){
            echo 'Problem Sending email. Please wait a few minutes and try again.';
          }
          ?>

            <form method="POST"  class="form-grid">
              
              <fieldset>
                <label for="firstname">First Name *</label>
                <input class="short-answer" type="text" name="firstname" id="firstname" value="<?php echo $firstname; ?>" required>
              </fieldset>

              <fieldset class="left-margin">
                <label for="lastname">Last Name *</label>
                <input class="short-answer" type="text" name="lastname" id="lastname" value="<?php echo $lastname; ?>" required>
              </fieldset>

              <fieldset>
                <label for="email">Email *</label>
                <input class="short-answer" type="email" name="email" id="email" value="<?php echo $email; ?>" required>
              </fieldset>

              <fieldset class="left-margin">
                <label for="location">Location *</label>
                <input class="short-answer" type="text" name="location" id="location" value="<?php echo $location; ?>" required>
              </fieldset>

              <fieldset>
                <legend>Have you ever eaten insects?</legend>
                <div>
                  <input type="radio" name="eatenbefore" id="insectsy" value="yes">
                  <label for="insectsy">Yes</label>
                </div>

                <div>
                  <input type="radio" name="eatenbefore" id="insectsn" value="no">
                  <label for="insectsn">No</label>
                </div>
                
              </fieldset>

              <fieldset class="left-margin">
                <legend>Do you have a high protein diet?</legend>
                <div>
                  <input type="radio" name="protein_answer" id="proteiny" value="yes">
                  <label for="proteiny">Yes</label>
                </div>

                <div>  
                  <input type="radio" name="protein_answer" id="proteinn" value="no" >
                  <label for="proteinn">No</label>
                </div>

               
              </fieldset>

              <fieldset>
                <legend>Would you consider eating insects?</legend>
                <div>
                  <input type="radio" name="eating_answer" id="eatingy" value="yes">
                  <label for="eatingy">Yes</label>
                </div>

                <div>  
                  <input type="radio" name="eating_answer" id="eatingn" value="no">
                  <label for="eatingn">No</label>
                </div>
              
              </fieldset>

              <fieldset class="left-margin">
                <legend>How likely are you to eat a cricket?</legend>
                <select name = "eatCricket">
                  <option value="1">Not Likely</option>
                  <option value="2">Somewhat Not Likely</option>
                  <option value="3">Neutral</option>
                  <option value="4">Somewhat Likely</option>
                  <option value="5">Very Likely</option>
                </select>
              </fieldset>

              <fieldset class="full-row">
                <label for="comments">Do you think we will globally move to crickets as a source of protein in the
                  future?</label>
                <textarea name="longanswer" id="comments"> </textarea>
              </fieldset>
            
              <input type="submit" value="SUBMIT" name="submit" class="submit-button">

            </form>
        
      </div>

    </section>
    </main>
  <?php

    }
    else{
      ?>
      <main>
      <section id="survey">
        <div class="container">
          
            <h2>TAKE THE SURVEY</h2>
            <div class="container">
              <p class="thanks-message red-bground">THANK YOU FOR COMPLETING THE FORM</p>
              <p class="thanks-message spacing">A COPY OF YOUR ANSWERS HAS BEEN SENT TO YOU VIA EMAIL</p>
            </div>
          
        </div>  
      </section>
      </main>
      <?php
    }
   }
  ?>
  <!-- Footer -->
  <footer class="footer-wrapper">
    <p>SOURCES: 
      <a href="https://exoprotein.com/pages/why-crickets">exoprotein.com</a>
       | 
      <a href="http://www.aketta.com/blog/5-reasons-to-eat-cricket-protein-and-edible-insects.aspx">aketta.com</a>
    </p>
    <a id='admin-login' href='login.php'>ADMIN LOGIN</a>
   
  </footer>

  <!-- Smooth scroll with current-section highligher, from https://codepen.io/joxmar/pen/NqqMEg -->
  <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script>
    var lastId,
      topMenu = $(".main-menu"),
      topMenuHeight = topMenu.outerHeight() + 1,
      menuItems = topMenu.find("a"),
      scrollItems = menuItems.map(function () {
        var item = $($(this).attr("href"));
        if (item.length) { return item; }
      });

    menuItems.click(function (e) {
      var href = $(this).attr("href"),
        offsetTop = href === "#" ? 0 : $(href).offset().top - topMenuHeight + 1;
      $('html, body').stop().animate({
        scrollTop: offsetTop
      }, 350);
      e.preventDefault();
    });

    $(window).scroll(function () {
      var fromTop = $(this).scrollTop() + topMenuHeight;
      var cur = scrollItems.map(function () {
        if ($(this).offset().top < fromTop)
          return this;
      });
      cur = cur[cur.length - 1];
      var id = cur && cur.length ? cur[0].id : "";
      if (lastId !== id) {
        lastId = id;
        menuItems
          .parent().removeClass("is-current")
          .end().filter("[href=#" + id + "]").parent().addClass("is-current");
      }
    });
  </script>

</body>

</html>