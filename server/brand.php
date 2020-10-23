<?php 
require_once("server_fundamentals/SessionHandler.php");

getHead("Home");
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
            <h1>Dashboard</h1>
          </div>
          <!-- TOP CONTENT BLOCKS -->
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                  <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                      <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                      <div class="card-header">
                        <h4>Total Branches</h4>
                      </div>
                      <div class="card-body">
                        6
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                  <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                      <i class="far fa-newspaper"></i>
                    </div>
                    <div class="card-wrap">
                      <div class="card-header">
                        <h4>Waiting</h4>
                      </div>
                      <div class="card-body">
                        3500
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                  <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                      <i class="far fa-money-bill-alt"></i>
                    </div>
                    <div class="card-wrap">
                      <div class="card-header">
                        <h4>Serving Now</h4>
                      </div>
                      <div class="card-body">
                        500
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                  <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                      <i class="fas fa-calendar-week"></i>
                    </div>
                    <div class="card-wrap">
                      <div class="card-header">
                        <h4>No Show</h4>
                      </div>
                      <div class="card-body">
                        200
                      </div>
                    </div>
                  </div>
                </div>
            </div>
          
            <div class="row">
                <div class="col-12 ">
                                <div class="card card-warning">
                                  <div class="card-header">
                                    <h4>Description </h4>
                                  </div>
                                  <div class="card-body text-justify">
                                    <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                   </p><p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                    </p>
                                  </div>
                                </div>
                              </div>
            </div>

            <div class="row">
                <div class="col-12 ">
                                <div class="card card-warning">
                                  <div class="card-header">
                                    <h4>Top 3 Recomended Societies</h4>
                                  </div>
                                  <div class="card-body text-justify">
<div class="row">
<?php
$s ='';
if(isset($_GET['title'])){
	$s = "and ((vb_name  like '%".$_GET['title']."%') or (vb_tags  like '%".$_GET['title']."%')or (vb_tagline like '%".$_GET['title']."%') or (vb_desc like '%".$_GET['title']."%'))";
}

$getSocs = mysqlSelect("SELECT * FROM `virtual_brands` where

".$s."
order by vb_name asc
");
if(is_array($getSocs)){
	foreach($getSocs as $soc){
		similar_text($USER_ARRAY['lum_interests'],$soc['vb_tags'],$percent);
		$getSocsFiltered[] = array("vb_img_src"=>$soc['vb_img_src'], "vb_name"=>$soc['vb_name'],"vb_id"=>$soc['vb_id'],"vb_accuracy"=>$percent);
		unset($percent);
	}
		$vb_accuracy  = array_column($getSocsFiltered, 'vb_accuracy');
		$vb_name = array_column($getSocsFiltered, 'vb_name');
		array_multisort($vb_accuracy, SORT_DESC, $vb_name, SORT_ASC, $getSocsFiltered);

			for($iii = 0; $iii <(count($getSocsFiltered) >=3 ? 3: count($getSocsFiltered) ); $iii++){
			 ?>
			  <div class="col-sm-12 col-lg-4">
				  <div class="section-body">
					  <div class="card author-box card-primary">
							  <div class="card-body">
								<div class="author-box-left">
								  <img alt="image" src="<?php echo $getSocsFiltered[$iii]['vb_img_src'] ?>" class="rounded-circle author-box-picture">
								  <div class="clearfix"></div>
								</div>
								<div class="author-box-details">
								  <div class="author-box-name">
									<?php echo $getSocsFiltered[$iii]['vb_name']; ?>
								  </div>
								  <div class="author-box-job"><?php echo $getSocsFiltered[$iii]['vb_name']; ?></div>
								  <div class="float-right mt-sm-0 mt-3">
									<a href="society_page?id=<?php echo md5("SALTINGSALTINGEHEIUNOIU*****siufniue".$getSocsFiltered[$iii]['vb_id']); ?>" class="btn"><button class="btn btn-warning">View More <i class="fas fa-chevron-right"></i></button></a>
								  </div>
								</div>
							  </div>
						</div>
					</div>
				</div>
				<?php
				
				}
}else{
	echo '<div class="col-12 text-center"><a class="text-center" href="socieites"><button class="btn btn-primary">View All ></button></a></div>';
}
	?>
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
