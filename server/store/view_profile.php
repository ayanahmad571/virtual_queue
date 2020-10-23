<?php 
require_once("server_fundamentals/SessionHandler.php");
getHead("Peer Profile");
#872g8724g87y872yr87-*-*
if(!isset($_GET['id'])){
	header("profile");
	die();
}
if(!ctype_alnum($_GET['id'])){
	header("profile");
	die();
}

$getPeer = mysqlSelect("select * from sm_logins left join sm_gender on lum_gender = gn_id where lum_valid =1 and md5(concat('872g8724g87y872yr87-*-*', lum_id)) = '".$_GET['id']."'");
if(!is_array($getPeer)){
	header("profile");
	die();
}
$peer = $getPeer[0];


?>


<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      
      <?php
	  	getTopBar();
	  	getNavbar($USER_ARRAY['type_mod_id']);
	  ?>
      

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Profile Page</h1>
          </div>
          <!-- TOP CONTENT BLOCKS -->
          
            <div class="row">
                <div class="col-12 ">
                                <div class="card card-warning">
                                  <div class="card-header">
                                    <h4>Image</h4>
                                  </div>
                                  <div class="card-body text-justify">
                <div class="row">
                	<div align="center" class="col-12 ">
                    	<img id="imgContainer" class="img-responsive" width="200px" src="<?php echo $peer['lum_img_src'] ?>" />
                    </div>
                </div>
                                  </div>
                                </div>
                              </div>
            </div>


            <div class="row">
                <div class="col-12 ">

                                <div class="card card-warning">
                                  <div class="card-header">
                                    <h4>Personal Info</h4>
                                  </div>
                                  <div class="card-body text-justify">
                                    <p>
                                    	<table class="table table-bordered table-striped table-hover">
                                            <tbody>
                                            	<tr>
                                                	<td><strong>Name:</strong></td>
                                                    <td><?php echo $peer['lum_fname']." ".$peer['lum_lname'] ?></td>
                                                </tr>
                                                
                                            	<tr>
                                                	<td><strong>Email:</strong></td>
                                                    <td><?php echo $peer['lum_email']; ?></td>
                                                </tr>
                                                
                                            	<tr>
                                                	<td><strong>Age:</strong></td>
                                                    <td><?php echo $peer['lum_age']; ?></td>
                                                </tr>
                                                
                                            	<tr>
                                                	<td><strong>Gender:</strong></td>
                                                    <td><?php echo $peer['gn_name']; ?></td>
                                                </tr>

                                            	<tr>
                                                	<td><strong>Interests:</strong></td>
                                                    <td><?php echo $peer['lum_interests']; ?></td>
                                                </tr>
                                                
                                            	<tr>
                                                	<td><strong>User Since:</strong></td>
                                                    <td><?php echo date("d-M-Y @ h:i:s A",$peer['lum_dnt']); ?></td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                    </p>
              </div>
            </div>
          </div>
        </div>

        </section>
        
        
        
      </div><!-- Main Content  -->  
      
      <?php
	  getFooter(); 
	  ?>
      
    </div><!-- Main Wrapper  -->
  </div><!-- App -->
<?php

getScripts();
?>

</body>
</html>
