<?php 
require_once("server_fundamentals/SessionHandler.php");

getHead("Manage Branch");
?>
<?php 
$getSoc = mysqlSelect("SELECT * FROM `virtual_branch` 
left join admin_branch_type on branch_type_id = bt_id
where branch_lum_id = ".$USER_ARRAY['lum_id']."
order by branch_id asc limit 1
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
            <h1><?php echo $getSoc['branch_name']; ?> - Branch Admin Panel</h1>
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
                    	<img id="imgContainer" class="img-responsive" width="200px" src="<?php echo $getSoc['branch_logo'] ?>" />
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
                                    <h4>About The Branch</h4>
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
        	<td colspan="2"><strong>Brand Name:</strong></td>
        	<td colspan="4"><?php echo $getSoc['branch_brand_name']; ?></td>
        	<td colspan="1">
            </td>
        </tr>

    	<tr>
        	<td colspan="2"><strong>Display Name:</strong></td>
        	<td colspan="4"><?php echo $getSoc['branch_name']; ?></td>
        	<td colspan="1">
            </td>
        </tr>


    	<tr>
        	<td colspan="2"><strong>Type:</strong></td>
        	<td colspan="4"><?php echo $getSoc['bt_name']; ?></td>
        	<td colspan="1">
            </td>
        </tr>

    	<tr>
        	<td colspan="2"><strong>Location:</strong></td>
        	<td colspan="4">Change</td>
        	<td colspan="1">
            </td>
        </tr>


    	<tr>


        	<td colspan="2"><strong>Short Description:</strong></td>
        	<td colspan="4"><?php echo $getSoc['branch_desc']; ?></td>
        	<td colspan="1">
                <form id="tagChangeForm" action="server_fundamentals/VBController">
                    <div id="tagChangeFail" style="display:none; padding:10px; border-radius:10px;background-color:rgba(253,148,150,0.68); color:rgba(255,0,4,1.00)" class="mb-2 mt-2">
                    
                    </div>
                
                    <input type="text" name="booth_fund_c_tag_val" class="form-control mt-3" value="<?php echo $getSoc['branch_desc']; ?>" /> <br>
                    <button type="submit" class="btn btn-success mb-2">Change</button>
                </form>
            </td>
        </tr>


        
    	<tr>
        	<td colspan="2"><strong>Status:</strong></td>
        	<td colspan="4"><?php echo (($getSoc['branch_status'] ==1 )? "<strong style='color:green'>Active (Approved)</strong>": "<strong style=\"color:red\">Pending Approval</strong>") ?></td>
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
                <div class="col-12  ">
                                <div id="red" class="card card-warning">
                                  <div class="card-header">
                                    <h4>Queueing Services </h4>
                                  </div>
                                  <div class="card-body text-justify">
                                  <div class="table-responsive">
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:20%">Service Name</th>
            <th style="width:20%">Service Desc</th>
            <th style="width:10%">Status</th>
        </tr>
    </thead>
    <tbody>
    <?php
	$getRooms = mysqlSelect("SELECT * FROM `virtual_services` where service_branch_id= ".$getSoc["branch_id"]);
	
	if(is_array($getRooms)){
		foreach($getRooms as $room){
		?>
    	<tr>
        	<td><?php echo $room['service_name'] ?></td>
        	<td><?php echo $room['service_desc'] ?></td>
        	<td>
            	<div>
                <?php
				$buttonData = '<button class="btn btn-danger mt-2">De-Activate</button>';
				$stats = "Currently <strong>Active</strong>";
					if($room['service_status'] == 0){
						$buttonData = '<button class="btn btn-success mt-2">Re-Activate</button>';
						$stats = "Currently <strong>Inactive</strong>";
					}
				?>
                	 <?php echo $stats ?><br>
                    <form action="server_fundamentals/VBController" method="post">
                    <input type="hidden" name="toggle_room_v" value="<?php echo md5('TINGkjwrgnEHEIUNOIU*****siufniue'.$room['service_id']); ?>"/>
                    <?php 

					echo $buttonData;
					?>
                    
                    </form>
                    <br>
                    <a href="manage-service?id=<?php echo md5('TINGEHEIUNOIU*****siufniue'.$room['service_id']); ?>"><button class="btn btn-success mt-2">Go to Page</button></a><br>
                    
                </div>
            </td>
        </tr>

        <?php
		}
	}else{
		?>
<tr>
	<td align="center" colspan="3">-</td>
</tr>        
		<?php
	}
	
	?>
    <tr>
    	<td colspan="3" class="text-center"><strong>Make a new Service</strong></td>
    </tr>
    <tr >
    	<td colspan="3" id="roomAddFail"  style="display:none; color:rgba(247,22,25,1.00)"  class="text-center"></td>
    </tr>
    <tr id="hideRespo">
        <form id="roomAddForm" action="server_fundamentals/VBController">
        	<td ><input placeholder="Sit Down Food " required type="text" name="service_name" class="form-control" /></td>
        	<td ><input placeholder="The Queue for Sit Down food section" required type="text" name="service_desc" class="form-control" /></td>
            <td>
            	<button class="btn btn-info" type="submit">Add Service</button>
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
			"Branch Not Found";
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
