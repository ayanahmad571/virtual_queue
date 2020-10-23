<?php
require_once("server_fundamentals/Settings.php");
require_once("server_fundamentals/CookieController.php");
require_once("server_fundamentals/DatabaseConnection.php");
require_once("server_fundamentals/FunctionsController.php");

sec_session_start();
if(isset($_SESSION[SESSION_CONTROLLER_NAME]) && is_numeric($_SESSION[SESSION_CONTROLLER_NAME])){
	header("Location: home");
	die();
	
}
session_destroy();

if(isset($_GET['id'])){
	if(!ctype_alnum($_GET['id'])){
		header('Location: login');
	}
}else{
	header('Location: login');
}


$checkUserAcc = mysqlSelect("select * from sm_forgot_passwords where fp_hash = '".$_GET['id']."' and fp_used = 0");
if(!is_array($checkUserAcc)){
	header('Location: login');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Virtual Freshers Fairs by <?php echo BRANDING_COMPANY_NAME ?> for <?php echo UNI_NAME ?> - Reset Password</title>
  
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
              <div class="card-header"><h4>Reset Password</h4></div>

              <div class="card-body">
                    <p>
                    Enter the new password below.
                    </p>
                  	<div id="FailAttempt" class="mb-4" style="background-color:rgba(255,195,196,0.3); color:rgba(255,16,16,1.00); padding:10px; border-radius:8px;">
                    	Could not Change Password
                    </div>
                  	<div id="SuccessAttempt" class="mb-4" style="background-color:rgba(145,255,208,0.30); color:rgba(103,103,103,1.00); padding:10px; border-radius:8px;">
                    Password Change, Login again to experience Virtual Freshers like never before !!<br>
                  <div class="form-group">
                    <a href="login"><button type="button" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button></a>
                  </div>
                    </div>
                <form method="POST" id="loginForm" action="server_fundamentals/resetController">
                  <div class="form-group">
                    <label for="email">New Password</label>
                    <input id="email" type="text" class="form-control" name="new_pass" tabindex="1" required autofocus>
                    <input type="hidden" name="ux" value="<?php echo $_GET['id']; ?>" >
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Forgot Password
                    </button>
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
	$("#FailAttempt").hide();
	$("#SuccessAttempt").hide();
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
					$("#SuccessAttempt").fadeIn();
				}else{
					$("#FailAttempt").fadeIn();
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
