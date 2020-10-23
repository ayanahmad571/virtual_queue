<?php 
require_once("server_fundamentals/SessionHandler.php");
getHead("University Services");
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
            <h1>University Services</h1>
            <div class="section-header-breadcrumb">
            <button class="btn" data-toggle="modal" data-target="#descmodal"><i class="fa fa-question"></i></button>
            </div>
          </div>
        
<div class="row">
<?php
$getSocs = mysqlSelect("SELECT * FROM `virtual_services` 
where service_active = 1");
if(is_array($getSocs)){
foreach($getSocs as $soc){
 ?>
<div class="col-6">            
        <div class="card">
                <div class="card-header">
		                <h4><?php echo $soc['service_name'] ?></h4>
                </div>
                <div class="card-body">
                    <?php echo $soc['service_tagline'] ?>
                </div>
        
                <div class="card-footer text-right">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#descmodal<?php echo $soc['service_id'] ?>">Learn More</button>
                </div>
        </div>
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


<?php
if(is_array($getSocs)){
foreach($getSocs as $soc){
 ?>

        <div class="modal fade" tabindex="-1" role="dialog" id="descmodal<?php echo $soc['service_id'] ?>">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><?php echo $soc['service_name'] ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
              <h4><?php echo $soc['service_tagline'] ?></h4>
                <p><?php echo $soc['service_text'] ?></p>
                <br>
                <p>Contact us at: <u><strong><?php echo $soc['service_number'] ?></strong></u></p>
                
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>



    <?php
	
	}

}

?>
</body>
</html>




