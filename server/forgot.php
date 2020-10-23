<?php
require_once("server_fundamentals/Settings.php");
require_once("server_fundamentals/CookieController.php");
sec_session_start();
if(isset($_SESSION[SESSION_CONTROLLER_NAME]) && is_numeric($_SESSION[SESSION_CONTROLLER_NAME])){
	header("Location: home");
	die();
	
}
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Virtual Freshers Fairs by <?php echo BRANDING_COMPANY_NAME ?> for <?php echo UNI_NAME ?> - Forgot Password</title>
  
  <!-- Favicon -->
  <link rel="icon" 
      type="image/png" 
      href="assets/img/frestive/frestive_short.png">

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" >
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">


  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
</head>


<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="assets/img/FRESTIVE.svg" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4>Forgot Password</h4></div>

              <div class="card-body">
                                	<div id="loginFail" class="mb-4" style="background-color:rgba(141,248,183,0.30); color:rgba(110,110,110,1.00); padding:10px; border-radius:8px;">
                    	A password reset email has been sent. It can take up to 60 minutes to be delivered. Read it for further instructions.
                        <br><br><a href='login'><button class='btn btn-warning'>Continue..</button></a>
                    </div>

                <form method="POST" id="loginForm" action="server_fundamentals/ForgotController">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Forgot Password
                    </button>
                  </div>
                <div class="mt-5 text-center">
                Go back to <a href="login">Login Page</a>
              </div>

                </form>
              </div>
            </div>
            <div class="simple-footer">
              (Copyright &copy; Student Essentials) Powered by Student Essential and Aethn Aega, Made by Stisla.
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="assets/js/jquery.min.js" ></script>
  <script src="assets/js/bootstrap.min.js"></script>

  <!-- Page Specific JS File -->
<script>
$(document).ready(function (e) {
	$("#loginFail").hide();

    $('#loginForm').on('submit',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
				if(data.trim() == "ok"){
					$("#loginForm").fadeOut();
					$("#loginFail").fadeIn();

				}else{
					$("#loginForm").fadeOut();
					$("#loginFail").fadeIn();
				}
            },
            error: function(data){
                alert("Contact Admin.");
            }
        });
    }));

});
    </script> 
</body>
</html>
