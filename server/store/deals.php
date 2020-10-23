<?php 
require_once("server_fundamentals/SessionHandler.php");
getHead("Deals");
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
            <h1>Exciting Deals</h1>
            <div class="section-header-breadcrumb">
            <button class="btn" data-toggle="modal" data-target="#descmodal"><i class="fa fa-question"></i></button>
            </div>
          </div>
        
<div class="row">
<?php
$getSocs = mysqlSelect("SELECT * FROM `virtual_deals` 
where deal_valid = 1
");
if(is_array($getSocs)){
foreach($getSocs as $soc){
 ?>
              
              <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                <article style="height:400px" class="article article-style-b">
                  <div class="article-header">
                    <div class="article-image" data-background="<?php echo $soc['deal_img_src'] ?>">
                    </div>
                  </div>
                  <div class="article-details">
                    <div class="article-title">
                      <h2><a href="#"><?php echo $soc['deal_name'] ?></a></h2>
                    </div>
                    <p><?php echo $soc['deal_text'] ?></p>
                    <div class="article-cta align-bottom">
                      <a href="#"><button class="btn btn-secondary">Grab Offer <i class="fas fa-chevron-right"></i></button></a>
                    </div>
                  </div>
                </article>
              </div>
    <?php
	
	}
}else{
	echo "-";
}
	?>
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
        <div class="modal fade" tabindex="-1" role="dialog" id="descmodal">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>What is a room you may ask? Societie/Student Union opens up discussion a discussion topic where prospectrive freshers may partake and show their interest.</p>
                
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-success" data-dismiss="modal">Okay!</button>
              </div>
            </div>
          </div>
        </div>
</body>
</html>




