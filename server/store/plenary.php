<?php 
require_once("server_fundamentals/SessionHandler.php");
getHead("Plenary");
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
            <h1>Plenary - Currently Live</h1>
          </div>

          
<div class="row">
  <div class="col-sm-12">
      <div class="section-body">
          <div class="card author-box card-primary">
                  <div class="card-body">
                  	<div class="row">


<div class="col-12 col-md-8" style="padding:10px">
    <iframe style=" min-width:100%; height:36vw" src="https://www.youtube.com/embed/DDU-rZs-Ic4" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>

<div class="col-12 col-md-4" style="padding:10px">
<div class="card card-secondary">
  <div class="card-header">
    <h4>Now Live</h4>
  </div>
  <div class="card-body">
    <h5 align="center"><strong>Intro to DUL</strong></h5>

<div class="row">
	<div class="col-6">
    	<img alt="image" style="width:100%" src="assets/img/ayan.jpg" class="rounded-circle profile-widget-picture">
        <h6 align="center" class="mt-4"><u>Ayan Ahmad</u> (DULSU)</h6>
    </div>
	<div class="col-6">
    	<img alt="image" style="width:100%" src="assets/img/kostas.jpg" class="rounded-circle profile-widget-picture">
        <h6 align="center" class="mt-4"><u>Kostas</u> (VP)</h6>
    </div>
</div>

  </div>
</div>
<div class="mt-4 card card-warning">
  <div class="card-header">
    <h4>Upcoming Talk</h4>
  </div>
  <div class="card-body">
    <h3>The Internet of things</h3>
    <p>Tech Soc</p>
    <p>1pm - 2pm</p>
  </div>
</div>
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
