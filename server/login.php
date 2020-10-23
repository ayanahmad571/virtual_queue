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
  <title>Login - Virtual Queue by <?php echo BRANDING_COMPANY_NAME ?></title>
  
  <!-- Favicon -->
  <link rel="icon" 
      type="image/png" 
      href="<?php echo BRANDING_COMPANY_LOGO_FAVICON ?>">

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
      <div class="d-flex flex-wrap align-items-stretch">
        <div class="col-lg-4 col-md-6 col-sm-12 col-12 order-lg-1 min-vh-100 order-1">
          <div class="p-4 m-3">
            <img src="<?php echo BRANDING_COMPANY_LOGO_FAVICON ?>" alt="logo" width="80" class="shadow-light rounded-circle mb-5 mt-2">
            <h4 class="text-dark font-weight-normal">Welcome to the first Comprehensice VQMS (Virtual Queue Managment System) by <span class="font-weight-bold"><?php echo BRANDING_COMPANY_NAME ?></span></h4>
            <p class="text-muted">Before you get started, you must login or register a brand if you don't already have an account.</p>
            <form id="loginForm" method="POST" action="server_fundamentals/LoginController" class="needs-validation">

                <div id="loginFail" style="margin-bottom:10px; color:rgba(209,19,23,1.00)" >
                  Login Failed, Try again.
                </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
              </div>

              <div class="form-group">
                <div class="d-block">
                  <label for="password" class="control-label">Password</label>
                </div>
                <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
              </div>


              <div class="form-group text-right">
                <a href="forgot" class="float-left mt-3">
                  Forgot Password?
                </a>
                <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="3">
                  Login
                </button>
              </div>

              <div class="mt-5 text-center">
                Don't have an account? <a href="signup">Create new one</a>
              </div>
            </form>

            <div class="text-center mt-5 text-small">
              Powered by Aethn Aega, Theme by Stisla.
              <div class="mt-2">
                <a target="_blank" href="privacy-policy">Privacy Policy</a>
                <div class="bullet"></div>
                <a target="_blank" href="terms-of-service">Terms of Service</a>
              </div>
            </div>
          </div>
        </div>
        <div class="d-none d-md-block col-md-6 col-lg-8 col-12 order-lg-2 order-2 min-vh-100" style=" background-image:url(assets/img/slide2.jpg)">
          <div class="absolute-bottom-left index-2">
            <div class="text-light p-5 pb-2">
              <div class="mb-5 pb-3">
                <h1 class="mb-2 display-4 font-weight-bold">Hello There!!</h1>
                <h5 class="font-weight-normal text-muted-transparent">Warm welcome to our platform.</h5>
              </div>
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
				if(data.trim() == "-"){
					$("#loginFail").fadeIn();
					
				}else{
					window.location = data;
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
