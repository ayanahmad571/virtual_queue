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
                        <h4>Total Users</h4>
                      </div>
                      <div class="card-body">
                        2,500
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
                        <h4>Societies</h4>
                      </div>
                      <div class="card-body">
                        350
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
                        <h4>Worth of deals</h4>
                      </div>
                      <div class="card-body">
                        GBP 1,500
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
                        <h4>Date</h4>
                      </div>
                      <div class="card-body">
                        14th September, 2020
                      </div>
                    </div>
                  </div>
                </div>
            </div>
          
            <div class="row">
                <div class="col-12 ">
                                <div class="card card-warning">
                                  <div class="card-header">
                                    <h4>About the Student Union</h4>
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
	<div class="col-12 col-md-8">
                <div class="card">
                  <div class="card-header">
                    <h4>What is Freshers fair?</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-6 col-sm-4">
                        <div class="list-group" id="list-tab" role="tablist">
                          <a class="list-group-item list-group-item-action active" id="list-inspired-list" data-toggle="list" href="#list-inspired" role="tab">Get Inspired</a>
                          <a class="list-group-item list-group-item-action" id="list-meet-list" data-toggle="list" href="#list-meet" role="tab">Meet New Faces</a>
                          <a class="list-group-item list-group-item-action" id="list-deals-list" data-toggle="list" href="#list-deals" role="tab">Exclusive Student Deals</a>
                          <a class="list-group-item list-group-item-action" id="list-groups-list" data-toggle="list" href="#list-groups" role="tab">Be a part of an Activity Group</a>
                        </div>
                      </div>
                      <div class="col-6 col-sm-8 ">
                        <div class="tab-content" id="nav-tabContent">
                          <div class="tab-pane fade show active" id="list-inspired" role="tabpanel" aria-labelledby="list-home-list">
                                                <h1 align="center"><i class="fa fa-heart"></i></h1>

                            University is the place to discover and pursue your ambitions and goals in life. Explore the range of exciting opportunities that lie in wait for you, and challenge yourself to dream bigger.
                          </div>
                          
                          
                          <div class="tab-pane fade" id="list-meet" role="tabpanel" aria-labelledby="list-profile-list">
                                                <h1 align="center"><i class="fa fa-smile-wink"></i></h1>

                            The new normal is virtual. This is your chance to experience a near-authentic version of freshers fair from the comfort of your home. Thousands of aspiring, talented, trend-setting individuals, all connected with each other on a single platform.
                          </div>
                          
                          
                          <div class="tab-pane fade" id="list-deals" role="tabpanel" aria-labelledby="list-messages-list">
                                                <h1 align="center"><i class="fa fa-mail-bulk"></i></h1>

                            We partner with corporates who care about enriching your student experience. We bring only the best exclusive deals in London, to set you up for the best university life.
                          </div>
                          
                          
                          <div class="tab-pane fade" id="list-groups" role="tabpanel" aria-labelledby="list-settings-list">
                                                <h1 align="center"><i class="fa fa-futbol"></i></h1>

                          
                            University is all about exploring your passion and trying out new things, and societies are the best way to find like-minded individuals who can help you advance further in your field, or explore a new interest. You will also be able to make friends along the way too!
                          </div>
                          
                          
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

    </div>
    <div class="col-12 col-md-4">
                                <div class="card">
                                  <div class="card-header">
                                    <h4>Exciting Events</h4>
                                  </div>
                                  <div class="card-body text-justify">
                                    <p>
                                    We have exciting events lined up for you.<br>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                   </p><p>
                                    <a href="schedule" class="card-cta">View Schedule <i class="fas fa-chevron-right"></i></a>
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

$getSocs = mysqlSelect("SELECT * FROM `virtual_booths` where
vb_vbt_id = 1 and vb_valid =1 and vb_paid =1
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

            <div class="row">
                <div class="col-md-6">
                    <div class="card card-large-icons">
                      <div class="card-icon bg-primary text-white">
                        <i class="fas fa-handshake"></i>
                      </div>
                      <div class="card-body">
                        <h4>Meet a Student</h4>
                        <p>Need a break? Want to meet other students ? Worry no more, we've got you covered. </p>
                        <a href="networking" class="card-cta">View More<i class="fas fa-chevron-right"></i></a>
                      </div>
                    </div>
                  </div>
                <div class="col-md-6">
                    <div class="card card-large-icons">
                      <div class="card-icon bg-primary text-white">
                        <i class="fas fa-gift"></i>
                      </div>
                      <div class="card-body">
                        <h4>Check out Our Top Deals</h4>
                        <p>New to the city? Looking for those local perks? there are plenty to grab.</p>
                        <a href="deals" class="card-cta">View more <i class="fas fa-chevron-right"></i></a>
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
