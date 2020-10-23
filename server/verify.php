<?php

require_once("server_fundamentals/Settings.php");
require_once("server_fundamentals/CookieController.php");
require_once("server_fundamentals/DatabaseConnection.php");
require_once("server_fundamentals/FunctionsController.php");
//------------
sec_session_start();
if(isset($_SESSION[SESSION_CONTROLLER_NAME]) && is_numeric($_SESSION[SESSION_CONTROLLER_NAME])){
	header("Location: home");
	die();
	
}
//------------
session_destroy();

//------------
if(isset($_GET['id'])){
	if(!ctype_alnum($_GET['id'])){
		header('Location: login');
	}
}else{
	header('Location: login');
	die();
}

//------------
$checkUserAcc = mysqlSelect("select * from admin_sm_email_ver where ver_hash = '".$_GET['id']."' and ver_used = 0 and ver_dnt >= ".(time()-(24*60*60)));
if(!is_array($checkUserAcc)){
	header('Location: login');
	die();
}
//------------
$checkDup = mysqlSelect("select * from admin_sm_logins where lum_email = '".$checkUserAcc[0]['ver_lum_email']."' and ((lum_valid = 1) or (lum_valid = 0))");
if(is_array($checkDup)){
	die("An Account with the Same Email already exists, contact the Admin or re-register with a different email.");
}
//------------


	//------------
		$insertLumData = mysqlInsertData("INSERT INTO `admin_sm_logins`(`lum_fname`, `lum_lname`, `lum_email`, `lum_hash`, `lum_type`, `lum_dnt`,`lum_valid`, `lum_email_ver`) VALUES 
			(
			'".$checkUserAcc[0]['ver_lum_fname']."',
			'".$checkUserAcc[0]['ver_lum_lname']."',
			'".$checkUserAcc[0]['ver_lum_email']."',
			'".$checkUserAcc[0]['ver_lum_hash']."',
			'".$checkUserAcc[0]['ver_lum_type']."',
			'".$checkUserAcc[0]['ver_lum_dnt']."',
			'".$checkUserAcc[0]['ver_lum_valid']."',
			1
			 )",true);
		if(!is_numeric($insertLumData)) die("F1");

		$makeBooth = mysqlInsertData("
		INSERT INTO `virtual_branch`(`branch_type_id`, `branch_lum_id`, `branch_brand_name`, `branch_name`, `branch_desc`, `branch_logo`,`branch_dnt`) VALUES (
				'".$checkUserAcc[0]['ver_brand_industry']."',
				'".$insertLumData."', 
				'".$checkUserAcc[0]['ver_brand_name']."',
				'".$checkUserAcc[0]['ver_branch_name']."',
				'".$checkUserAcc[0]['ver_brand_desc']."',
				'assets/img/frestive/shop.png',
				'".time()."'
			 )",true);
		if(!is_numeric($makeBooth)){
			die("F34");
		}

	//------------
	

//------------


$updateData2 = mysqlUpdateData("update admin_sm_email_ver set ver_used =1  where ver_lum_email =  '".$checkUserAcc[0]['ver_lum_email']."'",true);
if(!is_numeric($updateData2)){
	die('F2');
}




?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Signup - Virtual Queue by <?php echo BRANDING_COMPANY_NAME ?></title>
  
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
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="assets/img/FRESTIVE.svg" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

            <div class="card card-primary">
                <div class="card-header"><h4>Verification</h4></div>
                
                <div class="card-body">
                    <div id="SuccessAttempt" class="mb-4" style="background-color:rgba(145,255,208,0.30); color:rgba(103,103,103,1.00); padding:10px; border-radius:8px;">
                    Email has been verified.<br>
                    Login now to Queue Up
               <a href="login"><button class="btn btn-primary mt-4">Login</button></a>
                    </div>
                </div>
            </div>
            <div class="simple-footer">
              Powered by Aethn Aega, Theme by Stisla.
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="assets/js/jquery.min.js" ></script>
  <script src="assets/js/bootstrap.min.js"></script>


</body>
</html>
