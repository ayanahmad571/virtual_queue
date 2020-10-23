<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require('mailer/src/Exception.php');
require('mailer/src/PHPMailer.php');
require('mailer/src/SMTP.php');



require_once("Settings.php");
function checkPost($htmlname){
	if(is_array($htmlname)){
		foreach($htmlname as $name){
			if(!isset($_POST[$name])){
				die("Invalid ".$name);
			}
			
		}
	}else{
		if(!isset($_POST[$htmlname])){
			die("Invalid ".$htmlname);
		}
	}
}

function checkEmail($email){
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	  die("Invalid email format");
	}
}

function genHash($email, $pass){
	return md5(md5(sha1($email."<><>:;-H0Q834{7TH}{MC[44283TH7M-".$pass)));
}

function uploadImage($fnm){
	$fileInternalName = $fnm;
	$target_dir = "img/user_uploads/";
	$path_t  =pathinfo($_FILES[$fnm]["name"]);
	$target_file = $target_dir.md5(time()).rand(1,111).".".$path_t["extension"];
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$errorRows = "<br>Image error";

// Check if image file is a actual image or fake image
  $check = getimagesize($_FILES[$fnm]["tmp_name"]);
  if($check !== false) {
    $uploadOk = 1;
  } else {
    $errorRows .=  "<br>File is not an image.";
    $uploadOk = 0;
  }

// Check if file already exists
if (file_exists($target_file)) {
  $errorRows .= "<br>Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES[$fnm]["size"] > 500000) {
  $errorRows .=  "<br>Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  $errorRows .=  "<br>Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  $errorRows .=  "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES[$fnm]["tmp_name"], $target_file)) {
    return array(1,$target_file);
  } else {
    $errorRows .=  "<br>Sorry, there was an error uploading your file.";
	return array(0,$errorRows );
  }
}

}

function loginMakeSession($uid){
	sec_session_start();
	session_destroy();
	sec_session_start();
	$_SESSION[SESSION_CONTROLLER_NAME] = $uid;
	
}

function inRange($number, $min, $max, $inclusive = FALSE)
{
    if (is_numeric($number) && is_numeric($min) && is_numeric($max))
    {
        return $inclusive
            ? ($number >= $min && $number <= $max)
            : ($number > $min && $number < $max) ;
    }

    return false;
}

function wrapSingle($string){
	$string = "'".$string."'";
	return $string;
}
###########

function getNavbar($ids){
	echo '
      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="home">'.BRANDING_COMPANY_NAME.'</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="home">'.BRANDING_COMPANY_NAME_SHORT.'</a>
          </div>
          <ul class="sidebar-menu">
	';
	$si = "in (".$ids.")";
	if(trim($ids) == "*"){
	$si = "not in (0)";
	}
$getModules  = mysqlSelect("SELECT * FROM `admin_ui_modules` m 
left join admin_ui_module_groups g on m.mod_mg_id = g.mg_id 
WHERE mod_id ".$si."
and mod_valid =1 
and mod_visible = 1
order by mg_id,mod_name asc");
if(is_array($getModules)){
#active check
$prevHeader = '';
foreach($getModules as $module){
	$active = '';
	if(trim(pathinfo(basename($_SERVER['PHP_SELF']), PATHINFO_FILENAME)) == trim($module['mod_href'])){
	$active = 'active';
	}
	
	if($prevHeader != $module['mg_name']){
		$prevHeader = $module['mg_name'];
		echo '<li class="menu-header">'.$module['mg_name'].'</li>';
	}
	echo '<li class="'.$active.'"><a class="nav-link" href="'.$module['mod_href'].'"><i class="'.$module['mod_icon'].'"></i> <span>'.$module['mod_name'].'</span></a></li>';
	
}
	}else{
		?>
      <li class="menu-header">Please Contact Administrator</li>
        <?php
	}
echo '
            </ul>

        </aside>
      </div>
';	
}

function getHead($name){
	?>
    <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?php echo $name ?> - <?php echo BRANDING_COMPANY_NAME ?></title>

  <!-- Favicon -->
  <link rel="icon" 
      type="image/png" 
      href="<?php echo BRANDING_COMPANY_LOGO_FAVICON; ?>">


  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css"  />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
</head>


    <?php
}

function getScripts(){
	?>
  <!-- General JS Scripts -->
  <script src="assets/js/jquery.min.js" ></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="assets/js/stisla.js"></script>

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
    <?php
}

function getFooter(){
	?>
      <footer style="background-color:#f4f6f9" class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2020 Aethn Aega <div class="bullet"></div> Designed by <a href="http://aethnaega.com">Aethn Aega</a>, Theme by <a href="https://studentessentials.co/">Stisla</a>
        </div>
      </footer>
   <?php   
}

function getTopBar(){
	?>
      <nav id="topBarHeader" class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
          </ul>
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="../assets/img/avatar/avatar-3.png" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi, <?php echo $GLOBALS['USER_ARRAY']['lum_fname']." ".$GLOBALS['USER_ARRAY']['lum_lname']; ?></div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-title"><?php echo strtoupper($GLOBALS['USER_ARRAY']['type_name']);?></div>
              <a href="profile" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
              </a>
              <div class="dropdown-divider"></div>
              <a href="logout" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
    <?php
}
/*
function appendLogs($lpv_text, $lpv_href, $lpv_post, $lpv_session, $lpv_server, $lpv_get,$lpv_ip, $lpv_time, $lpv_user = NULL  ){
		$lpv_post = base64_encode(json_encode($lpv_post));
		$lpv_session = base64_encode(json_encode($lpv_session));
		$lpv_server= base64_encode(json_encode($lpv_server));
		$lpv_get= base64_encode(json_encode($lpv_get));

$sqltext = "
INSERT INTO `logs_page_view`( `lpv_lum_id`, `lpv_text`, `lpv_href`, `lpv_post_dump`, `lpv_get_dump`, `lpv_session_dump`, `lpv_server_dump`, `lpv_ip`, `lpv_dnt`) VALUES (
'".$lpv_user."',
'".$lpv_text."',
'".$lpv_href."',
'".$lpv_post."',
'".$lpv_get."',
'".$lpv_session."',
'".$lpv_server."',
'".$lpv_ip."',
'".$lpv_time."'
)
";
return $sqltext;

}
*/

function emailSend($e_to, $e_to_name, $e_subject, $e_html_body,$e_alt_body){
	#####################


$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 0;                               // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP

#      // Specify main and backup SMTP servers


	/*
	$mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'badboyzzbookingz@gmail.com';                 // SMTP username
    $mail->Password = 'mojiman123';
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to
	$mail->setFrom('badboyzzbookingz@gmail.com', 'Frestive');
    $mail->addAddress($mailindiv['e_to_email'],$mailindiv['e_to_name']);     // Add a recipient
	$mail->addBCC('ayanahmad.ahay@gmail.com');
	*/

    $mail->Host = 'smtp.flockmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'info@frestive.online';                 // SMTP username
    $mail->Password = 'k4FAvL6vbeRR3Ym';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to
	$mail->setFrom('info@frestive.online', 'Qista');
    $mail->addAddress($e_to,$e_to_name);     // Add a recipient
	$mail->addBCC('ayanahmad.ahay@gmail.com');

/*    //Attachments
    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
*/
    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $e_subject;

    $mail->Body    = $e_html_body;
    $mail->AltBody = $e_alt_body;

    $mail->send();
	return true;
} catch (Exception $e) {
	return false;
}
	  


	#####################
}
?>
