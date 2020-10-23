<?php

require_once("server_fundamentals/SessionHandler.php");
if(!isset($_GET['id'])){
	header('Location: societies');
	die();
}else{
	if(!ctype_alnum($_GET['id'])){
		header('Location: societies');
		die();
	}
}

$getSoc = mysqlSelect("SELECT * FROM `virtual_booths` where
vb_vbt_id = 1 and vb_valid =1 and vb_paid =1
and md5(concat('SALTINGSALTINGEHEIUNOIU*****siufniue',vb_id)) = '".$_GET['id']."'");

if(!is_array($getSoc)){
	header('Location: societies');
	die();
}
$pageSoc = $getSoc[0];
getHead($pageSoc['vb_name']." Virtual Booth");



$getUserRegsSignup = mysqlSelect("SELECT * FROM `virtual_booth_signups` 
where vbsup_vb_id = ".$pageSoc['vb_id']." and vbsup_lum_id =".$USER_ARRAY['lum_id']." and vbsup_status =1");

$getUserRegsMail = mysqlSelect("select * from virtual_booth_mailing 
where bml_vb_id = ".$pageSoc['vb_id']." and bml_lum_id =".$USER_ARRAY['lum_id']." and bml_status =1");

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
            <h1>Virtual Booths - <?php echo $pageSoc['vb_name'] ?></h1>
          </div>
          
<div class="row">
	<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
    	        <div align="center" class="card profile-widget mt-0 " style="padding:20px; ">
                	<div class="row">
                    	<div class=" col-md-8 offset-md-2 col-6 offset-3">
							<img class="img-fluid mt-4" style="margin:auto" src="<?php echo $pageSoc['vb_img_src'] ?>" />
                        </div>
                    </div>
                <h3 class="mt-4"><?php echo $pageSoc['vb_name'] ?></h3>
                <br>
            	<h6><?php echo $pageSoc['vb_tagline'] ?></h6>
                
                </div>
    </div>
	<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
    	        <div class="card profile-widget mt-0" >
                  <div class="card-header">
                    <h4>Membership Plans (Annual)</h4>
                  </div>
                  <div style="padding:30px">
                  <table class="table table-bordered table-md">
                	<?php if(!is_null($pageSoc['vb_plan_1'])){
						echo '<tr><td>'.$pageSoc['vb_plan_1'].'</td></tr>';
					}if(!is_null($pageSoc['vb_plan_2'])){
						echo '<tr><td>'.$pageSoc['vb_plan_2'].'</td></tr>';
					}if(!is_null($pageSoc['vb_plan_3'])){
						echo '<tr><td>'.$pageSoc['vb_plan_3'].'</td></tr>';
					}if(!is_null($pageSoc['vb_plan_4'])){
						echo '<tr><td>'.$pageSoc['vb_plan_4'].'</td></tr>';
					}
					
					?>
                      </table>
                      </div>
                </div>
    </div>


	<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
    	        <div class="card profile-widget mt-0" style="padding:20px">
                  <table class="table table-bordered table-md">
						<tr>
                        	<th colspan="1">Name</th>
                            <th colspan="2">Action</th>
                        </tr>
                        <tr>
                        	<td colspan="1">Mailing List</td>
                            <td colspan="2">
                            
                            <?php 
							if(!is_array($getUserRegsMail)){
								?>
                            	<form id="joinMailList" action="server_fundamentals/ClientController" method="post">
<div id="joinMailListFail" style="display:none; padding:10px; border-radius:10px;background-color:rgba(253,148,150,0.68); color:rgba(255,0,4,1.00)" class="mb-2 mt-2">

</div>
                                
                                	<input type="hidden" value="<?php echo md5("sAAAAAJWFOIJFIOJWF". $pageSoc['vb_id']) ?>" name="mail_list"/>
                                    	<button  style="width:100%;box-shadow:none !important; border:none !important;" class="btn btn-lg btn-success">
                                        Join 
                                        </button>
                                </form>
                                
                                
                                <?php
							}else{
								?>
                                <strong>You have joined this List</strong><br>
                            <form id="unjoinMailList" action="server_fundamentals/ClientController" method="post">
<div id="unjoinMailListFail" style="display:none; padding:10px; border-radius:10px;background-color:rgba(253,148,150,0.68); color:rgba(255,0,4,1.00)" class="mb-2 mt-2">

</div>
                                
                                	<input type="hidden" value="<?php echo md5("iuehuei5tjg8iuiuj". $getUserRegsMail[0]['bml_id']) ?>" name="un_mail_list"/>
                                    	<button  style="width:100%;box-shadow:none !important; border:none !important;" class="btn btn-lg btn-danger">
                                        De-Register 
                                        </button>
                                </form>

                                <?php
							}
							?>
                            
                            
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="1">Register</td>
                            <td colspan="2">
                                                            <?php 
							if(!is_array($getUserRegsSignup)){
								?>
                            	<form id="joinSubList" action="server_fundamentals/ClientController" method="post">
<div id="joinSubListFail" style="display:none; padding:10px; border-radius:10px;background-color:rgba(253,148,150,0.68); color:rgba(255,0,4,1.00)" class="mb-2 mt-2">

</div>
                                	<input type="hidden" value="<?php echo md5("AsAAAAJWFOIJFIOJWF". $pageSoc['vb_id']) ?>" name="sub_list"/>
                                    	<button  style="width:100%;box-shadow:none !important; border:none !important;" class="btn btn-lg btn-success">
                                        Join 
                                        </button>
                                </form>
                                
                                
                                <?php
							}else{
								?>
                                <strong>You have joined this List</strong><br>
                            	<form id="unjoinSubList" action="server_fundamentals/ClientController" method="post">
<div id="unjoinSubListFail" style="display:none; padding:10px; border-radius:10px;background-color:rgba(253,148,150,0.68); color:rgba(255,0,4,1.00)" class="mb-2 mt-2">

</div>
                                	<input type="hidden" value="<?php echo md5("oisjefkmswioergnkml". $getUserRegsSignup[0]['vbsup_id']) ?>" name="un_sub_list"/>
                                    	<button  style="width:100%;box-shadow:none !important; border:none !important;" class="btn btn-lg btn-danger">
                                        De-Register 
                                        </button>
                                </form>
                                
                                <?php
							}
							?>
                            </td>
                        </tr>
                  </table>
                </div>
    </div>

	<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
    	        <div class="card profile-widget mt-0">
                  <div class="card-header">
                    <h4>Connect with Us</h4>
                  </div>
                  	<div class="row" style="padding:20px">

                	<?php 
					if(!is_null($pageSoc['vb_facebook'])){
						echo '
						<div class="col-6 mb-3 text-center">
							<a href="'.$pageSoc['vb_facebook'].'"><button style="width:100%;box-shadow:none !important; border:none !important;background-color: #0066ff; " class="btn btn-info text-center">Facebook</button></a>
						</div>
						';
					}
					if(!is_null($pageSoc['vb_instagram'])){
						echo '
						<div class="col-6 mb-3 text-center">
							<a href="'.$pageSoc['vb_instagram'].'"><button style="width:100%;box-shadow:none !important; border:none !important;background-color: #ff6666; " class="btn btn-info text-center">Instagram</button></a>
						</div>
						';
					}
					if(!is_null($pageSoc['vb_twitter'])){
						echo '
						<div class="col-6 mb-3 text-center">
							<a href="'.$pageSoc['vb_twitter'].'"><button style="width:100%;box-shadow:none !important; border:none !important;" class="btn btn-info text-center">Twitter</button></a>
						</div>
						';
					}
					if(!is_null($pageSoc['vb_url'])){
						echo '
						<div class="col-6 mb-3 text-center">
							<a href="'.$pageSoc['vb_url'].'"><button style="width:100%;box-shadow:none !important; border:none !important;color: black" class="btn btn-warning text-center">Website</button></a>
						</div>
						';
					}
					if(!is_null($pageSoc['vb_youtube_live'])){
						echo '
						<div class="col-6 mb-3 text-center">
							<a href="'.$pageSoc['vb_youtube_live'].'"><button style="width:100%;box-shadow:none !important; border:none !important;background-color: #ff0000; " class="btn btn-info text-center">Youtube</button></a>
						</div>
						';
					}
					if(!is_null($pageSoc['vb_zoom_link'])){
						echo '
						<div class="col-6 mb-3 text-center">
							<a href="'.$pageSoc['vb_zoom_link'].'"><button style="width:100%;box-shadow:none !important; border:none !important;" class="btn btn-info text-center">Zoom</button></a>
						</div>
						';
					}
					?>
                    </div>
                </div>
    </div>
</div>
<div class="row">
    <div class="col-12 ">
        <div class="card">
          <div class="card-header">
            <h4>About the Society</h4>
          </div>
          <div class="card-body">
            <p class="profile-widget-description"><?php echo  $pageSoc['vb_desc'] ?></p>
          </div>
        </div>
    </div>
<?php 
if(!is_null($pageSoc['vb_youtube_live'])){
	$url = $pageSoc['vb_youtube_live'];
parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
  
  // Output: C4kxS1ksqtw
  ?>
<div class="col-12 col-lg-9">
    <div class="card">
        <div class="card-header">
            <h4>Youtube Live</h4>
        </div>
        
        <div class="card-body">
            <iframe style=" min-width:100%;" height="600px"src="https://www.youtube.com/embed/<?php echo $my_array_of_vars['v'];   ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        
        </div>
        
    </div>
</div>

<div class="col-12 col-lg-3">
    <div class="card">
        <div class="card-header">
	        <h4>Youtube Live Chat</h4>
        </div>
        
        <div class="card-body">
    	    <iframe style=" min-width:100%;" height="600px"src="https://www.youtube.com/live_chat?v=<?php echo $my_array_of_vars['v'];   ?>&amp;embed_domain=<?php echo $_SERVER['HTTP_HOST'] ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>

</div>

  
  <?php
}
?>

</div>

<hr>
<h3>Discussion Rooms by <?php echo $pageSoc['vb_name'] ?></h3>
<br>
<div class="row">
<?php


$getRooms = mysqlSelect("SELECT * FROM `virtual_rooms` r
where r.vr_active =1
and r.vr_vb_id = ".$pageSoc['vb_id']."
order by r.vr_title asc
");
if(is_array($getRooms)){
foreach($getRooms as $room){
 ?>
  <div class="col-sm-12 col-lg-6">
      <div class="section-body">
          <div class="card author-box card-primary">
                  <div class="card-body">
                    <div class="author-box-left">
                      <img alt="image" src="<?php echo $pageSoc['vb_img_src'] ?>" class="rounded-circle author-box-picture">
                      <div class="clearfix"></div>
                    </div>
                    <div class="author-box-details">
                      <div class="author-box-name">
                        <?php echo $room['vr_title']; ?>
                      </div>
                      <hr>
                      <div class="authot author-body">
                      <?php echo $room['vr_desc2']; ?>
                      </div>
                      <div class="float-right mt-sm-0 mt-4">
                        <a href="rooms_chat?id=<?php echo md5("TINGEHEIUNOIU*****siufniue".$room['vr_id']); ?>" class="btn"><button class="btn btn-primary">Discuss <i class="fas fa-chevron-right"></i></button></a>
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

<script>
$(document).ready(function (e) {

    $('#joinSubList').on('submit',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
				if(data.trim() != "1"){
					$("#joinSubListFail").html(data);					
					$("#joinSubListFail").fadeIn();
					
				}else{
					$('#joinSubList').html("<strong style='color:green'>Successfully Registered</strong>");
				}
            },
            error: function(data){
                alert("Contact Admin.");
            }
        });
    }));

});
    </script> 
<script>
$(document).ready(function (e) {

    $('#unjoinSubList').on('submit',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
				if(data.trim() != "1"){
					$("#unjoinSubListFail").html(data);					
					$("#unjoinSubListFail").fadeIn();
					
				}else{
					$('#unjoinSubList').html("<strong style='color:green'>Successfully Un-Registered</strong>");
				}
            },
            error: function(data){
                alert("Contact Admin.");
            }
        });
    }));

});
    </script> 

    
<script>
$(document).ready(function (e) {

    $('#joinMailList').on('submit',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
				if(data.trim() != "1"){
					$("#joinMailListFail").html(data);					
					$("#joinMailListFail").fadeIn();
					
				}else{
					$('#joinMailList').html("<strong style='color:green'>Successfully Registered</strong>");
				}
            },
            error: function(data){
                alert("Contact Admin.");
            }
        });
    }));

});
    </script> 
    
<script>
$(document).ready(function (e) {

    $('#unjoinMailList').on('submit',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
				if(data.trim() != "1"){
					$("#unjoinMailListFail").html(data);					
					$("#unjoinMailListFail").fadeIn();
					
				}else{
					$('#unjoinMailList').html("<strong style='color:green'>Successfully Un-Registered</strong>");
				}
            },
            error: function(data){
                alert("Contact Admin.");
            }
        });
    }));

});
    </script> 
    
</body>
</html>
