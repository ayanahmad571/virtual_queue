<?php 
require_once("server_fundamentals/SessionHandler.php");
getHead("Manage User Data");

?>
<script src="assets/js/jquery.min.js"></script>

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" type="text/css" />
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
            <h1>View User Data</h1>
          </div>
          <!-- TOP CONTENT BLOCKS -->
            <div class="row">
                <div class="col-12 ">
                    <div class="card card-danger">
                      <div class="card-body table-responsive">
                      <input type="hidden" id="inputUserAp" value="0" />
    <table class="table table-striped table-bordered " id="tableUserAp">
	<thead>
    	<tr>
            <th>Full Name</th>
            <th>Email</th>
            <th>Type</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        </thead>

        <tbody>
        <?php
	$getUsers = mysqlSelect("select * from sm_logins 
	left join sm_user_groups on lum_type = type_id
	left join sm_gender on lum_gender = gn_id
	left join sm_status on lum_valid = ss_id
	where lum_type not in  (1)
	and lum_valid in (1,4)
	 order by lum_id desc");
	
if(is_array($getUsers)){
	foreach($getUsers as $user){
	?>
    	<tr>
        	<th><?php echo $user['lum_fname']." - ".$user['lum_lname'] ?></th>
        	<th><?php echo $user['lum_email'] ?></th>
        	<th><?php echo $user['type_name'] ?></th>
        	<th><?php echo date("d-M-Y @ h:i:s A",$user['lum_dnt']) ?></th>
            <th>
            <form id="f<?php echo $user['lum_id'] ?>" action="server_fundamentals/SUController" method="post">
            	<input type="hidden" name="user_toggle" value="<?php echo md5("IWOJNF2838.IO".$user['lum_id']) ?>" />
            	<?php
				if($user['lum_valid'] == 1){
					echo '<button type="submit" class="mt-2 btn btn-danger">Disable</button><br>';
				}else if($user['lum_valid'] == 4){
					echo '<button type="submit" class="mt-2 btn btn-success">Enable</button><br>';
				}else{
					echo $user['ss_name'];
				}
				 ?>
                 </form>
<a href="javascript:void(0);" data-href="server_fundamentals/SUController.php?ViewUserPage=<?php echo md5(sha1("/#@*ABCDEF".$user['lum_id'])) ?>" 
class="openPopup mt-2 mb-2 btn btn-warning">View</a><br>			
    <script>
	$(document).ready(function (e) {
    $('#f<?php echo $user['lum_id'] ?>').on('submit',(function(e) {
		me = $(this);
		var ebox = $("#f<?php echo $user['lum_id'] ?>");
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
							ebox.html(data);
											},//END
					error: function(data){
							ebox.html("Error Acessing the Folder. Contact Admin");
					}
				});
		    }));
		});
	</script>

            </th>
        </tr>
    <?php
	}
}

?>


        </tbody>
        
    </table>



                      </div>
                    </div>
                </div>
            </div>


        </section>
        
        
        
      </div>
      <!-- Main Content  -->  
      
      <?php
	  getFooter(); 
	  ?>
      
    </div><!-- Main Wrapper  -->
  </div><!-- App -->
<?php

getScripts();
?>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script>
$('#tableUserAp').DataTable();

	$('.openPopup').on('click',function(){
        var dataURL = $(this).attr('data-href');
        $('.modal-body').load(dataURL,function(){
            $('#myModal').modal({show:true});
        });
    }); 

</script>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
      
    </div>
</div>

</body>
</html>
