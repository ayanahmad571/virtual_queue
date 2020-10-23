<?php 
require_once("server_fundamentals/SessionHandler.php");
getHead("Sponsors");
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
            <h1>Virtual Booths - Sponsors</h1>
          </div>
<div class="row" style=""> 
<div class="col-12">
                <div class="card">
                <form action="sponsors" method="get">
                  <div class="card-body">
                    <div class="form-group row mb-0">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Search by text</label>
                      <div class="col-sm-12 col-md-7">

                        <input id="inputval" autofocus placeholder="Title, Description, Type ..." name="title" type="text" class="form-control"  >
                      </div>
                      <div class="col-sm-12 col-md-2 mt-2">
                        <button class="btn btn-primary">Search</button>
                        <a href="sponsors?title="><button class="btn btn-danger">Reset</button></a>
                      </div>
                    </div>

                  </div>
                  </form>
                </div>
              </div>
              </div>
          
<div class="row">
<?php
$s ='';
if(isset($_GET['title'])){
	$s = "and ((vb_name  like '%".$_GET['title']."%') or (vb_tags  like '%".$_GET['title']."%')or (vb_tagline like '%".$_GET['title']."%') or (vb_desc like '%".$_GET['title']."%'))";
}

$getSocs = mysqlSelect("SELECT * FROM `virtual_booths` where
vb_vbt_id = 2 and vb_valid =1 and vb_paid =1
".$s."
order by vb_name asc
");
if(is_array($getSocs)){
foreach($getSocs as $soc){
 ?>
  <div class="col-sm-12 col-lg-4">
      <div class="section-body">
          <div class="card author-box card-primary">
                  <div class="card-body">
                    <div class="author-box-left">
                      <img alt="image" src="<?php echo $soc['vb_img_src'] ?>" class="rounded-circle author-box-picture">
                      <div class="clearfix"></div>
                    </div>
                    <div class="author-box-details">
                      <div class="author-box-name">
                        <?php echo $soc['vb_name']; ?>
                      </div>
                      <div class="author-box-job"><?php echo $soc['vb_name']; ?></div>
                      <div class="float-right mt-sm-0 mt-3">
                        <a href="sponsor_page?id=<?php echo md5("SALTINGSALTINGEHEIUNOIU*****siufniue".$soc['vb_id']); ?>" class="btn"><button class="btn btn-warning">View More <i class="fas fa-chevron-right"></i></button></a>
                      </div>
                    </div>
                  </div>
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
</body>
</html>
