<?php 
require_once("server_fundamentals/SessionHandler.php");

getHead("Manage Booth");
?>
<?php 
$getSoc = mysqlSelect("SELECT * FROM `virtual_brands` 
where vb_lum_id = ".$USER_ARRAY['lum_id']."
order by vb_id asc limit 1
");

?>

<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      
      <?php
	  	getTopBar();
	  	getNavbar($USER_ARRAY['type_mod_id']);
		if(is_array($getSoc)){
			$getSoc = $getSoc[0];
	  ?>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?php echo $getSoc['vb_name']; ?> - Brand Admin Panel</h1>
          </div>
          <!-- TOP CONTENT BLOCKS -->
          
            <div class="row">
                <div class="col-12 ">
                                <div class="card card-warning">
                                  <div class="card-header">
                                    <h4>Logo</h4>
                                  </div>
                                  <div class="card-body text-justify">
                <div class="row">
                	<div align="center" class="col-12 col-sm-6">
                    	<img id="imgContainer" class="img-responsive" width="200px" src="<?php echo $getSoc['vb_img_src'] ?>" />
                    </div>
                	<div id="UploadFileSuc" align="center" class="col-12 col-sm-6">
                    <div id="ImgChangeFail" style="display:none; padding:10px; border-radius:10px;background-color:rgba(253,148,150,0.68); color:rgba(255,0,4,1.00)" class="mb-2 mt-2">
                    	
                    </div>

            <form class="mt-2" id="formUploadFile" name="upload" enctype="multipart/form-data">
				<strong>Change Image:</strong> <input id="imgFile" class="form-control" type="file" name="image[]" >
				<input class="mt-3 form-control btn btn-danger" type="submit" name="upload" value="Upload">
			</form>

                    </div>
                </div>
                                  </div>
                                </div>
                              </div>
            </div>

            <div class="row">
                <div class="col-12 ">
                                <div class="card card-warning">
                                  <div class="card-header">
                                    <h4>About You (User)</h4>
                                  </div>
                                  <div class="card-body text-justify">
                                  <div class="table-responsive">
<table class="table table-bordered table-hover">
	<thead>
    	<tr>
        	<th colspan="4">Name</th>
        	<th colspan="4">User Type</th>
        	<th colspan="4">Email</th>
        	<th colspan="4">Password Change</th>
        </tr>
    </thead>
    <tbody>
    	<tr>
        	<td colspan="4" ><?php echo $USER_ARRAY['lum_fname']. " ".$USER_ARRAY['lum_lname']; ?></td>
        	<td colspan="4"><?php echo $USER_ARRAY['type_name']; ?></td>
        	<td colspan="4"><?php echo $USER_ARRAY['lum_email']; ?></td>
        	<td colspan="4" id="passChangeBox">
            	<form id="pwChangeForm" action="server_fundamentals/VBController">
                	<div id="pwChangeFail" style="display:none; padding:10px; border-radius:10px;background-color:rgba(253,148,150,0.68); color:rgba(255,0,4,1.00)" class="mb-2 mt-2">
                    	
                    </div>
                	<input required type="text" name="change_pw" class="form-control mt-3" /> <br>
                    <button type="submit" class="btn btn-success mb-2">Change Password</button>
                </form>
            </td>
        </tr>
    </tbody>
</table>
                                
    								 </div>
                                  </div>
                                </div>
                              </div>
            </div>

            <div class="row">
                <div class="col-12 ">
                                <div class="card card-warning">
                                  <div class="card-header">
                                    <h4>About The Booth</h4>
                                  </div>
                                  <div class="card-body text-justify">
                                  <div class="table-responsive">
<table class="table table-bordered table-hover">
	<thead>
    	<tr>
        	<th colspan="2">Attribute</th>
        	<th colspan="4">Value</th>
        	<th colspan="1">Action</th>
        </tr>
    </thead>
    <tbody>
    	<tr>
        	<td colspan="2"><strong>Name:</strong></td>
        	<td colspan="4"><?php echo $getSoc['vb_name']; ?></td>
        	<td colspan="1">
            </td>
        </tr>

    	<tr>
        	<td colspan="2"><strong>Type:</strong></td>
        	<td colspan="4"><?php echo $getSoc['vbt_name']; ?></td>
        	<td colspan="1">
            </td>
        </tr>


    	<tr>
        	<td colspan="2"><strong>Sub-Type:</strong></td>
        	<td colspan="4"><?php echo $getSoc['vst_name']; ?></td>
        	<td colspan="1">
            </td>
        </tr>


    	<tr>


        	<td colspan="2"><strong>Tags:</strong></td>
        	<td colspan="4"><?php echo $getSoc['vb_tags']; ?></td>
        	<td colspan="1">
                <form id="tagChangeForm" action="server_fundamentals/VBController">
                    <div id="tagChangeFail" style="display:none; padding:10px; border-radius:10px;background-color:rgba(253,148,150,0.68); color:rgba(255,0,4,1.00)" class="mb-2 mt-2">
                    
                    </div>
                
                    <input type="text" name="booth_fund_c_tag_val" class="form-control mt-3" value="<?php echo $getSoc['vb_tags']; ?>" /> <br>
                    <button type="submit" class="btn btn-success mb-2">Change</button>
                </form>
            </td>
        </tr>


    	<tr>
        	<td colspan="2"><strong>Tagline:</strong></td>
        	<td colspan="4"><?php echo $getSoc['vb_tagline']; ?></td>
        	<td colspan="1">
                <form id="taglineChangeForm" action="server_fundamentals/VBController">
                    <div id="taglineChangeFail" style="display:none; padding:10px; border-radius:10px;background-color:rgba(253,148,150,0.68); color:rgba(255,0,4,1.00)" class="mb-2 mt-2">
                    
                    </div>
                
                    <input type="text" name="booth_fund_c_tagline_val" class="form-control mt-3" value="<?php echo $getSoc['vb_tagline']; ?>" /> <br>
                    <button type="submit" class="btn btn-success mb-2">Change</button>
                </form>
            </td>
        </tr>
        
    	<tr>
        	<td colspan="2"><strong>Status:</strong></td>
        	<td colspan="4"><?php echo (($getSoc['vb_valid'] ==1 && $getSoc['vb_paid'] == 1 )? "<strong style='color:green'>Active (Approved)</strong>": "<strong style=\"color:red\">Pending Approval</strong>") ?></td>
        	<td colspan="1">
            </td>
        </tr>

    </tbody>
</table>
                                  </div>
                                  </div>
                                </div>
                              </div>
            </div>

            <div class="row">
                <div class="col-12 ">
                                <div class="card card-warning">
                                  <div class="card-header">
                                    <h4>Description</h4>
                                  </div>
                                  <div  class="card-body text-justify">
                                    <div id="descBodyData"><?php echo $getSoc['vb_desc']; ?></div>
                                    <hr>
                                    <h3 class="mt-3"><strong>Edit</strong></h3><br>
        <form id="descChangeForm" action="server_fundamentals/VBController">
                    <div id="descChangeFail" style="display:none; padding:10px; border-radius:10px;background-color:rgba(253,148,150,0.68); color:rgba(255,0,4,1.00)" class="mb-2 mt-2">
            
                    </div>

                                  <textarea style="height:300px" id="mytextarea" name="edit_booth_desc">
                                  <?php echo $getSoc['vb_desc']; ?>
                                   </textarea><br>
		<button type="submit" class="btn btn-danger mt-2">Change</button>
       </form>
                                  </div>
                                </div>
              </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-6 ">
                                <div class="card card-warning">
                                  <div class="card-header">
                                    <h4>Plans</h4>
                                  </div>
                                  <div class="card-body text-justify">
                                  <div class="table-responsive">
<form id="plansChangeForm" action="server_fundamentals/VBController">
                    <div id="plansChangeFail" style="display:none; padding:10px; border-radius:10px;background-color:rgba(253,148,150,0.68); color:rgba(255,0,4,1.00)" class="mb-2 mt-2">
            
                    </div>

<table class="table table-bordered table-hover">
    <tbody>
    	<tr>
        	<td colspan="2"><strong>Plan 1:</strong></td>
        	<td colspan="4"><input name="booth_c_plans_1" class="form-control" value="<?php echo $getSoc['vb_plan_1']; ?>" /></td>
        </tr>

    	<tr>
        	<td colspan="2"><strong>Plan 2:</strong></td>
        	<td colspan="4"><input name="booth_c_plans_2" class="form-control" value="<?php echo $getSoc['vb_plan_2']; ?>" /></td>
        </tr>


    	<tr>
        	<td colspan="2"><strong>Plan 3:</strong></td>
        	<td colspan="4"><input name="booth_c_plans_3" class="form-control" value="<?php echo $getSoc['vb_plan_3']; ?>" /></td>
        </tr>

    	<tr>
        	<td colspan="2"><strong>Plan 4:</strong></td>
        	<td colspan="4"><input name="booth_c_plans_4" class="form-control" value="<?php echo $getSoc['vb_plan_4']; ?>" /></td>
        </tr>


    </tbody>
</table>
<br>
<button class="btn btn-danger">Save Changes</button>
        </form>
                                  </div>
                                  </div>
                                </div>
                              </div>


                <div class="col-12 col-lg-6 ">
                                <div class="card card-warning">
                                  <div class="card-header">
                                    <h4>Socials</h4>
                                  </div>
                                  <div class="card-body text-justify">
                                  <div class="table-responsive">
<form id="socialsChangeForm" action="server_fundamentals/VBController">
                    <div id="socialsChangeFail" style="display:none; padding:10px; border-radius:10px;background-color:rgba(253,148,150,0.68); color:rgba(255,0,4,1.00)" class="mb-2 mt-2">
            
                    </div>

<table class="table table-bordered table-hover">
    <tbody>
    	<tr>
        	<td colspan="2"><strong>Facebook:</strong></td>
        	<td colspan="4"><input name="booth_c_socials_fb" class="form-control" value="<?php echo $getSoc['vb_facebook']; ?>" /></td>
        </tr>

    	<tr>
        	<td colspan="2"><strong>Instagram:</strong></td>
        	<td colspan="4"><input name="booth_c_socials_ig" class="form-control" value="<?php echo $getSoc['vb_instagram']; ?>" /></td>
        </tr>


    	<tr>
        	<td colspan="2"><strong>Twitter:</strong></td>
        	<td colspan="4"><input name="booth_c_socials_twitter" class="form-control" value="<?php echo $getSoc['vb_twitter']; ?>" /></td>
        </tr>

    	<tr>
        	<td colspan="2"><strong>Website:</strong></td>
        	<td colspan="4"><input name="booth_c_socials_web" class="form-control" value="<?php echo $getSoc['vb_url']; ?>" /></td>
        </tr>


    </tbody>
</table>
<br>
<button class="btn btn-danger">Save Changes</button>
        </form>
                                  </div>
                                  </div>
                                </div>
                              </div>


            </div>


            <div class="row">
                <div class="col-12  ">
                                <div class="card card-warning">
                                  <div class="card-header">
                                    <h4>Live Links (Users Will need to refresh the page)</h4>
                                  </div>
                                  <div class="card-body text-justify">
                                  <div class="table-responsive">
<form id="liveChangeForm" action="server_fundamentals/VBController">
                    <div id="liveChangeFail" style="display:none; padding:10px; border-radius:10px;background-color:rgba(253,148,150,0.68); color:rgba(255,0,4,1.00)" class="mb-2 mt-2">
            
                    </div>

<table class="table table-bordered table-hover">
    <tbody>
    	<tr>
        	<td colspan="2"><strong>Youtube:</strong></td>
        	<td colspan="4"><input name="booth_live_yt" class="form-control" value="<?php echo $getSoc['vb_youtube_live']; ?>" /></td>
        </tr>

    	<tr>
        	<td colspan="2"><strong>Zoom:</strong></td>
        	<td colspan="4"><input name="booth_live_zoom" class="form-control" value="<?php echo $getSoc['vb_zoom_link']; ?>" /></td>
        </tr>


    </tbody>
</table>
<br>
<button class="btn btn-danger">Save Changes</button>
        </form>
                                  </div>
                                  </div>
                                </div>
                              </div>


                


            </div>

            <div class="row">
                <div class="col-12  ">
                                <div id="red" class="card card-warning">
                                  <div class="card-header">
                                    <h4>Rooms Currently Active</h4>
                                  </div>
                                  <div class="card-body text-justify">
                                  <div class="table-responsive">
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:20%">Room Title</th>
            <th style="width:20%">Room Tagline</th>
            <th style="width:35%">Panel Desc</th>
            <th style="width:15%">Chats</th>
            <th style="width:10%">Status</th>
        </tr>
    </thead>
    <tbody>
    <?php
	$getRooms = mysqlSelect("SELECT * FROM `virtual_rooms` where vr_vb_id = ".$getSoc["vb_id"]);
	
	if(is_array($getRooms)){
		foreach($getRooms as $room){
		?>
    	<tr>
        	<td><?php echo $room['vr_title'] ?></td>
        	<td><?php echo $room['vr_tagline'] ?></td>
        	<td><?php echo $room['vr_desc2'] ?></td>
        	<td>
            	<div>
                	<strong>Total Chats</strong>: 123<br>
                	<strong>Approved Chats</strong>: 123<br>
                	<strong>Non-Approved Chats</strong>: 123<br>
                </div>
            </td>
        	<td>
            	<div>
                <?php
				$buttonData = '<button class="btn btn-danger mt-2">De-Activate</button>';
				$stats = "Currently <strong>Active</strong>";
					if($room['vr_active'] == 0){
						$buttonData = '<button class="btn btn-success mt-2">Re-Activate</button>';
						$stats = "Currently <strong>Inactive</strong>";
					}
				?>
                	 <?php echo $stats ?><br>
                    <form action="server_fundamentals/VBController" method="post">
                    <input type="hidden" name="toggle_room_v" value="<?php echo md5('TINGkjwrgnEHEIUNOIU*****siufniue'.$room['vr_id']); ?>"/>
                    <?php 

					echo $buttonData;
					?>
                    
                    </form>
                    <br>
                    <a href="rooms_chat?id=<?php echo md5('TINGEHEIUNOIU*****siufniue'.$room['vr_id']); ?>"><button class="btn btn-success mt-2">Go to Page</button></a><br>
                    
                </div>
            </td>
        </tr>

        <?php
		}
	}
	
	?>
    <tr>
    	<td colspan="5" class="text-center"><strong>Make a new Room (Pages are non-editiable)</strong></td>
    </tr>
    <tr >
    	<td colspan="5" id="roomAddFail"  style="display:none; color:rgba(247,22,25,1.00)"  class="text-center"></td>
    </tr>
    <tr id="hideRespo">
        <form id="roomAddForm" action="server_fundamentals/VBController">
        	<td ><input placeholder="Name" required type="text" name="add_room_name" class="form-control" /></td>
        	<td><input placeholder="Tagline" required type="text" name="add_room_tagline" class="form-control" /></td>
        	<td colspan="2"><textarea name="add_room_desc" class="form-control" placeholder="Short Description about the room"></textarea></td>
            <td>
            	<button class="btn btn-info" type="submit">Add Room</button>
            </td>
        </form>
    </tr>
    </tbody>
</table>
<br>
                                  </div>
                                  </div>
                                </div>
                              </div>


                


            </div>

        </section>
        
        
        
      </div><!-- Main Content  -->  
      
      <?php
		}else{
			"Booth Not Found";
		}
	  getFooter(); 
	  ?>
      
    </div><!-- Main Wrapper  -->
  </div><!-- App -->
<?php

getScripts();
?>
<script src='https://cdn.tiny.cloud/1/by74ria054lnubei3wydkfmwirk6hyz3otmidzorwoatn1fn/tinymce/5/tinymce.min.js' referrerpolicy="origin">
  </script>
  <script>
    tinymce.init({
      selector: '#mytextarea'
    });
  </script>
  
  
<script>
//pw
$(document).ready(function (e) {
    $('#pwChangeForm').on('submit',(function(e) {
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
				if(data.trim() == ""){
						$("#pwChangeForm").html("Password Changed Successfully");				
				}else{
					$("#pwChangeFail").html(data);
					$("#pwChangeFail").fadeIn();
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
//tags
$(document).ready(function (e) {
    $('#tagChangeForm').on('submit',(function(e) {
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
				if(data.trim() == ""){
						$("#tagChangeForm").hide();
						$("#tagChangeForm").html("<strong>Tags Changed Successfully. Refresh page to see changes</strong>");	
						$("#tagChangeForm").fadeIn();			
				}else{
					$("#tagChangeFail").html(data);
					$("#tagChangeFail").fadeIn();
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
//tagline
$(document).ready(function (e) {
    $('#taglineChangeForm').on('submit',(function(e) {
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
				if(data.trim() == ""){
						$("#taglineChangeForm").hide();
						$("#taglineChangeForm").html("<strong>Tagline Changed Successfully. Refresh page to see changes</strong>");	
						$("#taglineChangeForm").fadeIn();			
				}else{
					$("#taglineChangeFail").html(data);
					$("#taglineChangeFail").fadeIn();
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
//desc
$(document).ready(function (e) {
    $('#descChangeForm').on('submit',(function(e) {
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
				if(data.trim() == ""){
						$("#descChangeForm").hide();
						$("#descBodyData").fadeOut();
						$("#descChangeForm").html("<strong>Description Changed Successfully. Refresh page to see changes</strong>");	
						$("#descChangeForm").fadeIn();			
				}else{
					$("#descChangeFail").html(data);
					$("#descChangeFail").fadeIn();
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
//plans
$(document).ready(function (e) {
    $('#plansChangeForm').on('submit',(function(e) {
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
				if(data.trim() == ""){
						$("#plansChangeForm").hide();
						$("#plansChangeForm").html("<strong>Plans Changed Successfully. Refresh page to see changes</strong>");	
						$("#plansChangeForm").fadeIn();			
				}else{
					$("#plansChangeFail").html(data);
					$("#plansChangeFail").fadeIn();
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
//socials
$(document).ready(function (e) {
    $('#socialsChangeForm').on('submit',(function(e) {
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
				if(data.trim() == ""){
						$("#socialsChangeForm").hide();
						$("#socialsChangeForm").html("<strong>Socials Changed Successfully. Refresh page to see changes</strong>");	
						$("#socialsChangeForm").fadeIn();			
				}else{
					$("#socialsChangeFail").html(data);
					$("#socialsChangeFail").fadeIn();
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
//live
$(document).ready(function (e) {
    $('#liveChangeForm').on('submit',(function(e) {
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
				if(data.trim() == ""){
						$("#liveChangeForm").hide();
						$("#liveChangeForm").html("<strong>Live Data Changed Successfully. Refresh page to see changes</strong>");	
						$("#liveChangeForm").fadeIn();			
				}else{
					$("#liveChangeFail").html(data);
					$("#liveChangeFail").fadeIn();
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
//room
$(document).ready(function (e) {
    $('#roomAddForm').on('submit',(function(e) {
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
				if(data.trim() == ""){
						$("#hideRespo").hide();
						$("#roomAddFail").html("<strong style='color: green'>Room created Successfully. Refresh page to see changes</strong>");	
						$("#roomAddFail").fadeIn();			
				}else{
					$("#roomAddFail").html(data);
					$("#roomAddFail").fadeIn();
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
    $('#formUploadFile').on('submit',(function(e) {
        e.preventDefault();

        var fd = new FormData(this);

        $.ajax({
            url: 'server_fundamentals/ImageHandlers/upload',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
				var data = JSON.parse(response);
                if(data.status != 0){
					$("#ImgChangeFail").fadeOut();
					$("#UploadFileSuc").html("<strong style='color:green'>Image Uploaded</strong>");
                    $("#imgContainer").attr("src",data.datum); 
                }else{
					$("#ImgChangeFail").html(data.datum);
					$("#ImgChangeFail").fadeIn();

                }
            },
        });
	}));
});
 </script>
</body>
</html>
