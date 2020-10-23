<?php 
require_once("server_fundamentals/SessionHandler.php");
getHead("Profile");
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
                                    	-
                                    </p>
                                  </div>
                                </div>

                                <div class="card card-warning">
                                  <div class="card-header">
                                    <h4>Virtual Booths Joined</h4>
                                  </div>
                                  <div class="card-body text-justify">
                                    <p>
                                    List of all Virtual Booths  Student has Joined
                                    </p>
                                  </div>
                                </div>
                                <div class="card card-warning">
                                  <div class="card-header">
                                    <h4>Mailing Lists Joined</h4>
                                  </div>
                                  <div class="card-body text-justify">
                                    <p>
                                    List of all Virtual Booth Mailing Lists Student has Joined
                                    </p>
                                  </div>
                                </div>
                                <div class="card card-warning">
                                  <div class="card-header">
                                    <h4>Rooms Q and Chats </h4>
                                  </div>
                                  <div class="card-body text-justify">
                                    <p>
                                    List of rooms you interacted in along with the chats
                                    </p>
                                  </div>
                                </div>
                                <div class="card card-warning">
                                  <div class="card-header">
                                    <h4>Meet a student chats</h4>
                                  </div>
                                  <div class="card-body text-justify">
                                    <p>
                                    List of all students that you interacted with and the chats
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

</body>
</html>
