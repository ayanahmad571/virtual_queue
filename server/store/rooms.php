<?php 
require_once("server_fundamentals/SessionHandler.php");
getHead("Other Booths");
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
            <h1>Rooms - Discussion Page</h1>
            <div class="section-header-breadcrumb">
            <button class="btn" data-toggle="modal" data-target="#descmodal"><i class="fa fa-question"></i></button>
            </div>
          </div>
  <div class="row" style=""> 
<div class="col-12">
                <div class="card">
                <form action="rooms" method="get">
                  <div class="card-body">
                    <div class="form-group row mb-0">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Search by text</label>
                      <div class="col-sm-12 col-md-7">

                        <input id="inputval" autofocus placeholder="Title, Description, Type ..." name="title" type="text" class="form-control"  >
                      </div>
                      <div class="col-sm-12 col-md-2 mt-2">
                        <button class="btn btn-primary">Search</button>
                        <a href="rooms?title="><button class="btn btn-danger">Reset</button></a>
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
	$s = "and ((r.vr_title  like '%".$_GET['title']."%'))";
}

$getSocs = mysqlSelect("SELECT * FROM `virtual_rooms` r
left join virtual_booths v on r.vr_vb_id = v.vb_id
where v.vb_valid =1 and  v.vb_paid=1 and
r.vr_active =1
".$s."
order by r.vr_title asc
");
if(is_array($getSocs)){
foreach($getSocs as $soc){
 ?>
  <div class="col-sm-12 col-lg-6">
      <div class="section-body">
          <div class="card author-box card-primary">
                  <div class="card-body">
                    <div class="author-box-left">
                      <img alt="image" src="<?php echo $soc['vb_img_src'] ?>" class="rounded-circle author-box-picture">
                      <div class="clearfix"></div>
                    </div>
                    <div class="author-box-details">
                      <div class="author-box-name">
                        <?php echo $soc['vr_title']; ?>
                      </div>
                      <div class="author-box-job">Hosted by: <?php echo $soc['vb_name']; ?></div>
                      <hr>
                      <div class="authot author-body">
                      <?php echo $soc['vr_desc2']; ?>
                      </div>
                      <div class="float-right mt-sm-0 mt-4">
                        <a href="rooms_chat?id=<?php echo md5("TINGEHEIUNOIU*****siufniue".$soc['vr_id']); ?>" class="btn"><button class="btn btn-primary">Discuss <i class="fas fa-chevron-right"></i></button></a>
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
