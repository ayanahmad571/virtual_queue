<?php 
require_once("server_fundamentals/SessionHandler.php");
getHead("Societies");
?>


<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      
      <?php
	  	getTopBar();
	  	getNavbar($USER_ARRAY['type_mod_id']);
		$labelcols = ' col-12 col-sm-4 col-md-4 col-lg-2 col-xl-1 '; #*2
		$inputcols = 'col-12 col-sm-8 col-md-8 col-lg-4 col-xl-4 mb-2'; #*2
		$btncols = 'col-12 col-sm-12 col-md-12 col-lg-12 col-xl-2 '; #*1
	  ?>


      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Virtual Booths - Societies</h1>
          </div>
<div class="row" style=""> 
<div class="col-12">
                <div class="card">
                <form action="societies" method="get">
                  <div class="card-body">
                    <div class="form-group row mb-0">
                      <label class="col-form-label text-md-right <?php echo $labelcols; ?>">Search </label>
                      <div class=" <?php echo $inputcols; ?>">
                        <input id="inputval" autofocus placeholder="Title, Description, Type ..." name="title" type="text" class="form-control"  >
                      </div>
                      
                      <label class="col-form-label text-md-right <?php echo $labelcols; ?>">Sub Type </label>
                      <div class=" <?php echo $inputcols; ?>">
						<select name="sub_t" class="form-control" >
                        	<option value="<?php echo md5("0A"); ?>" selected>All</option>
                            <?php 
							$getGroups = mysqlSelect("SELECT * FROM `virtual_booth_types_subtypes` where vst_vbt_id = 1");
								if(is_array($getGroups)){
									foreach($getGroups as $oneGroup){
										$selected = '  ';
if(isset($_GET['sub_t'])){
	if(ctype_alnum($_GET['sub_t'])){
		if(trim($_GET['sub_t']) == md5("AKJN90U903T09". $oneGroup['vst_id'])){
			#$selected = ' selected ';
		}
	}
}
			 echo '<option '.$selected.' value="'.md5("AKJN90U903T09".$oneGroup['vst_id']).'">'.$oneGroup['vst_name'].'</option>';

										
									}
								}
							 ?>
                        </select>
                      </div>
                      
                      
                      <div class=" <?php echo $btncols; ?>">
                        <button class="btn btn-primary mt-2">Search</button>
                        <a href="societies?"><button class="btn btn-danger mt-2">Reset</button></a>
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
	if($_GET['title'] != '')$s = "and ((vb_name  like '%".$_GET['title']."%') or (vb_tags  like '%".$_GET['title']."%')or (vb_tagline like '%".$_GET['title']."%') or (vb_desc like '%".$_GET['title']."%'))";
}
$s2 ='';
if(isset($_GET['sub_t'])){
	if(ctype_alnum($_GET['sub_t'])){
		if(md5("0A") != $_GET['sub_t']) $s2 = 'and md5(concat("AKJN90U903T09",vb_vst_id)) = "'.$_GET['sub_t'].'" ';
	}
}

$getSocs = mysqlSelect("SELECT * FROM `virtual_booths` where
vb_vbt_id = 1 and vb_valid =1 and vb_paid =1
".$s."
".$s2."
order by vb_name asc
");
if(is_array($getSocs)){
foreach($getSocs as $soc){
 ?>
  <div class="col-sm-12 col-lg-6 col-xl-4">
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
                        <a href="society_page?id=<?php echo md5("SALTINGSALTINGEHEIUNOIU*****siufniue".$soc['vb_id']); ?>" class="btn"><button class="btn btn-warning">View More <i class="fas fa-chevron-right"></i></button></a>
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
