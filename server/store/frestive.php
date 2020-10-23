<?php 
require_once("server_fundamentals/SessionHandler.php");
getHead("Frestive");
?>


<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      
      <?php
	  	getTopBar();
	  	getNavbar($USER_ARRAY['type_mod_id']);
	  ?>
<style>
.founder_text{
	font-size:2.3em;
}
.founder_socials{
	color: black;
	font-size:2.3em;
}
.founder_para{
	text-align:justify;
}
</style>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>About Frestive</h1>
          </div>
        
<div class="row">
	<div class="card">
        <div class="card-body">
            <div class="row">
		<?php
        $getFounder = mysqlSelect("select * from frestive_founders order by founder_name asc");
        if(is_array($getFounder)){
            foreach($getFounder as $founder){
        ?>
            <div class="col-sm-6 col-lg-6 col-xl-4">
                <div class="row">
                    <div class="card" style="box-shadow:none !important">
                        <div class="card-body">
                            <div class="col-12 text-center">
                                <img src="<?php echo $founder['founder_img_src'] ?>" style="width:60%" class="img-responsive rounded-circle" />
                            </div>
                            <div class="col-12 text-center mt-3">
                                  <strong class="founder_text"><?php echo $founder['founder_name'] ?></strong>
                            </div>
                            <div class="col-12 text-center mt-3">
                                <div class="row">
                                    <div class="col-4">
                                        <strong><a href="<?php echo $founder['founder_linkedin'] ?>"><button  class="btn"><i class="founder_socials fab fa-linkedin-in"></i></button></a></strong>
                                    </div>
                                    <div class="col-4">
                                        <strong><a href="<?php echo $founder['founder_facebook'] ?>"><button  class="btn"><i class="founder_socials fab fa-facebook"></i></button></a></strong>
                                    </div>
                                    <div class="col-4">
                                        <strong><a href="<?php echo $founder['founder_instagram'] ?>"><button  class="btn"><i class="founder_socials fab fa-instagram"></i></button></a></strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-center mt-3">
                                  <p class="founder_para"><?php echo $founder['founder_desc'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          <?php
            }
        }
          ?>  
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




