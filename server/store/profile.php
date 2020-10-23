<?php 
require_once("server_fundamentals/SessionHandler.php");
getHead("Profile");
?>

<style>
	.c_s{
		background-color:rgba(146,248,170,0.76);
		border-radius:10px;
		padding:10px;	
		color:rgba(5,171,65,1.00);
		display:none;
	}
	.c_e{
		background-color:rgba(255,144,145,0.53);
		color:rgba(188,0,3,1.00);
		border-radius:10px;
		padding:10px;
		display:none;	
	}
</style>

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
            <h1>Profile Page</h1>
          </div>
          <!-- TOP CONTENT BLOCKS -->
          
            <div class="row">
                <div class="col-12 ">
                                <div class="card card-warning">
                                  <div class="card-header">
                                    <h4>Image</h4>
                                  </div>
                                  <div class="card-body text-justify">
                <div class="row">
                	<div align="center" class="col-12 col-sm-6">
                    	<img id="imgContainer" class="img-responsive" width="200px" src="<?php echo $USER_ARRAY['lum_img_src'] ?>" />
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
                                    <h4>Personal Info</h4>
                                  </div>
                                  <div class="card-body text-justify">
                                    <p>
                                    	<table class="table table-bordered table-striped table-hover">
                                            <tbody>
                                            	<tr>
                                                	<td><strong>Name:</strong></td>
                                                    <td><?php echo $USER_ARRAY['lum_fname']." ".$USER_ARRAY['lum_lname'] ?></td>
                                                </tr>
                                                
                                            	<tr>
                                                	<td><strong>Email:</strong></td>
                                                    <td><?php echo $USER_ARRAY['lum_email']; ?></td>
                                                </tr>
                                                
                                            	<tr>
                                                	<td><strong>Password:</strong></td>
                                                    <td>
                                                        <div class="c_s">
                                                            
                                                        </div>
                                                        <div class="c_e">
                                                    
                                                        </div>

                                                        <form action="server_fundamentals/ClientController" method="post" id="formID">
                                                        	<input type="text" name="change_password_user" class="mt-2 input form-control" placeholder="New Password" /><br>
                                                            <button class="btn btn-success mb-2 " type="submit">Change Password</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                
                                            	<tr>
                                                	<td><strong>Age:</strong></td>
                                                    <td><?php echo $USER_ARRAY['lum_age']; ?></td>
                                                </tr>
                                                
                                            	<tr>
                                                	<td><strong>Gender:</strong></td>
                                                    <td><?php echo $USER_ARRAY['gn_name']; ?></td>
                                                </tr>

                                            	<tr>
                                                	<td><strong>Interests:</strong></td>
                                                    <td><?php echo $USER_ARRAY['lum_interests']; ?></td>
                                                </tr>
                                                
                                            	<tr>
                                                	<td><strong>User Since:</strong></td>
                                                    <td><?php echo date("d-M-Y @ h:i:s A",$USER_ARRAY['lum_dnt']); ?></td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                    </p>
                                  </div>
                                </div>

                                <div class="card card-warning">
                                  <div class="card-header">
                                    <h4>Virtual Booths Joined</h4>
                                  </div>
                                  <div class="card-body text-justify">
                                    <p>
<table class="table table-bordered table-striped table-hover">
											<thead>
                                            <tr>
                                            	<th>#</th>
                                                <th>Booth Name</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
											$getJoins = mysqlSelect("SELECT * FROM `virtual_booth_signups` 
											left join virtual_booths on vbsup_vb_id = vb_id
											where 
											vb_valid = 1 and 
											vbsup_status=1 and vbsup_lum_id=".$USER_ARRAY['lum_id']);
											if(is_array($getJoins)){
												$x = 1;
												foreach($getJoins as $joins){
													echo '
                                            	<tr>
                                                    <td>'.$x.'</td>
                                                    <td>'.$joins['vb_name'].'</td>
                                                </tr>
													';
													$x++;
												}
											}
											?>
                                                

                                                
                                            </tbody>
                                        </table>                                    
                                    </p>
                                  </div>
                                </div>
                                <div class="card card-warning">
                                  <div class="card-header">
                                    <h4>Mailing Lists Joined</h4>
                                  </div>
                                  <div class="card-body text-justify">
                                    <p>
<table class="table table-bordered table-striped table-hover">
											<thead>
                                            <tr>
                                            	<th>#</th>
                                                <th>Booth Name</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
											$getJoins = mysqlSelect("SELECT * FROM `virtual_booth_mailing` 
											left join virtual_booths on bml_vb_id = vb_id
											where 
											vb_valid = 1 and 
											bml_status=1 and bml_lum_id=".$USER_ARRAY['lum_id']);
											if(is_array($getJoins)){
												$x = 1;
												foreach($getJoins as $joins){
													echo '
                                            	<tr>
                                                    <td>'.$x.'</td>
                                                    <td>'.$joins['vb_name'].'</td>
                                                </tr>
													';
													$x++;
												}
											}
											?>
                                                

                                                
                                            </tbody>
                                        </table>                                    
                                    </p>
                                  </div>
                                </div>
                                <div class="card card-warning">
                                  <div class="card-header">
                                    <h4>Rooms Q and Chats </h4>
                                  </div>
                                  <div class="card-body text-justify">
                                    <p>
                                    Chats of all the rooms you have interacted in
                                    </p>
                                    <p>
                                    <table class="table table-bordered table-striped table-hover">
											<thead>
                                            <tr>
                                            	<th>#</th>
                                                <th>Room Name</th>
                                                <th>Booth Name</th>
                                                <th>Chat Text</th>
                                                <th>Time</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
											$getChats = mysqlSelect("
											SELECT * FROM `c_chat_rooms` 
											left join virtual_rooms on vr_id = ccr_vr_id
											left join virtual_booths on vb_id = vr_vb_id
											where 
											ccr_approved = 1 and 
											vr_active = 1 and 
											vb_valid = 1 and ccr_lum_id=".$USER_ARRAY['lum_id']);
											if(is_array($getChats)){
												$x = 1;
												foreach($getChats as $chats){
													echo '
                                            	<tr>
                                                    <td>'.$x.'</td>
                                                    <td>'.$chats['vr_title'].'</td>
                                                    <td>'.$chats['vb_name'].'</td>
                                                    <td>'.$chats['ccr_text'].'</td>
                                                    <td>'.date("d-M-Y @ h:i:s A",$chats['ccr_dnt']).'</td>
                                                </tr>
													';
													$x++;
												}
											}
											?>
                                                

                                                
                                            </tbody>
                                        </table>                                    
                                    </p>
                                  </div>
                                </div>
                                
                                
                                
                                <div class="card card-warning">
                                  <div class="card-header">
                                    <h4>Meet a student chats</h4>
                                  </div>
                                  <div class="card-body text-justify">
                                    <p>
                                        <table class="table table-bordered table-striped table-hover">
											<thead>
                                            <tr>
                                            	<th>#</th>
                                                <th>Match Name</th>
                                                <th>Time</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
											$getMeets = mysqlSelect("
											SELECT *,l1.lum_id as id1, l2.lum_id as id2, concat(l1.lum_fname,' ',l1.lum_lname) as lum1name ,concat(l2.lum_fname,' ',l2.lum_lname) as lum2name 
											FROM `c_chat_groups` c 
											left join sm_logins l1 on l1.lum_id = c.cg_1_lum_id 
											left join sm_logins l2 on l2.lum_id = c.cg_2_lum_id 
											where c.cg_1_lum_id = ".$USER_ARRAY['lum_id']." or c.cg_2_lum_id = ".$USER_ARRAY['lum_id']);
											if(is_array($getMeets)){
												$x = 1;
												foreach($getMeets as $meets){
													echo '
                                            	<tr>
                                                    <td>'.$x.'</td>
                                                    <td>'.($meets['id1'] == $USER_ARRAY['lum_id'] ? $meets['lum2name'] : $meets['lum1name']).'</td>
                                                    <td>'.date("d-M-Y @ h:i:s A",$meets['cg_dnt']).'</td>
						                            <td>
														<a href="view_profile?id='.md5("872g8724g87y872yr87-*-*".($meets['id1'] == $USER_ARRAY['lum_id'] ? $meets['id2'] : $meets['id1'])).'">
															<button class="btn btn-primary">
															View
															</button>
														</a>
													</td>
                                                </tr>
													';
													$x++;
												}
											}
											?>
                                                

                                                
                                            </tbody>
                                        </table>  
                                    </p>
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

 <script>
$(document).ready(function (e) {
    $('#formUploadFile').on('submit',(function(e) {
        e.preventDefault();

        var fd = new FormData(this);

        $.ajax({
            url: 'server_fundamentals/ImageHandlers/upload_user',
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
 
 
     <script>
	$(document).ready(function (e) {
    $('#formID').on('submit',(function(e) {
		me = $(this);
		var ebox = $(".c_e");
		var sbox = $(".c_s");
		ebox.fadeOut();
		sbox.fadeOut();
		e.preventDefault();
			var formData = new FormData(this);
			$.ajax({
					type:'POST',
					url: $(this).attr('action'),
					data:formData,
					cache:false,
					contentType: false,
					processData: false,//Start
					success:function(data){
						if(data == ""){
							sbox.html("The Password was updated successfully.");
							sbox.fadeIn();
						}else{
							ebox.html(data);
							ebox.fadeIn();
						}
											},//END
					error: function(data){
							ebox.html("Error Acessing the Folder. Contact Admin");
							ebox.fadeIn();
					}
				});
		    }));
		});
	</script>
                                                    
                                                    
                                          

</body>
</html>
