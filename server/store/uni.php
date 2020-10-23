<?php 
require_once("server_fundamentals/SessionHandler.php");
getHead("University");
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
            <h1>About University</h1>
          </div>

<div class="row">

  <div class="col-sm-12 ">
      <div class="section-body">
          <div class="card author-box card-primary">
                  <div class="card-body">
                  <div class="row">
                  	<div class="col-md-4 mb-4">
                    	<img src="assets/img/slide1.jpg" style="width:100%" class="img-responsive" />
                    </div>
                    <div class="col-md-8">
 
                      <div class="author-box-name">
                        <h3 style="color:black"><?php echo UNI_NAME ?></h3>	<hr>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
                      </div>

                    </div>
                  </div>
                    <div class="author-box-details">

                      <div class="float-right mt-sm-0 mt-3">
                        <a href="#" class="btn"><button class="btn btn-warning">View More <i class="fas fa-chevron-right"></i></button></a>
                      </div>
                    </div>
                  </div>
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
