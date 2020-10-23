<?php 
require_once("server_fundamentals/SessionHandler.php");
getHead("View Booth Data");

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
            <h1>View Booth Data</h1>
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
            <th>Owner Name</th>
            <th>Owner Email</th>
            <th>Booth Name</th>
            <th>Category</th>
            <th>Action</th>
            <th>Payment</th>
        </tr>
        </thead>

        <tbody>
        <?php
	$getUsers = mysqlSelect("
	
	SELECT *,ifnull(vst_name, '-') as vst_name_filtered FROM `virtual_booths` 
		left join sm_logins on vb_lum_id = lum_id
		left join virtual_booth_types on vb_vbt_id = vbt_id
		left join virtual_booth_types_subtypes on vb_vst_id = vst_id
		left join sm_gender on lum_gender = gn_id
		where lum_type =3 and  lum_valid in (1,4) and lum_email_ver = 1
		and vb_valid in (1,4)
		 order by lum_id desc");
	
if(is_array($getUsers)){
	foreach($getUsers as $user){
	?>
    	<tr>
        	<td><?php echo $user['lum_fname']." - ".$user['lum_lname'] ?></td>
        	<td><?php echo $user['lum_email'] ?></td>
        	<td><?php echo $user['vb_name'] ?></td>
        	<td><?php echo ($user['vbt_name']." : ".$user['vst_name_filtered']); ?></td>
            <td>
            <form id="f<?php echo $user['vb_id'] ?>" action="server_fundamentals/SUController" method="post">
            	<input type="hidden" name="booth_toggle" value="<?php echo md5("IWOJNF2**838.IO".$user['vb_id']) ?>" />
            	<?php
				if($user['lum_valid'] == 1){
					echo '<button type="submit" class="mt-2 btn btn-danger">Disable</button><br>';
				}else{
					echo '<button type="submit" class="mt-2 btn btn-success">Enable</button><br>';
				}
				 ?>
                 </form>
<a href="javascript:void(0);" data-href="server_fundamentals/SUController.php?ViewBoothData=<?php echo md5(sha1("/#@*ABwjqieusCDEF".$user['lum_id'])) ?>" 
class="openPopup mt-2 mb-2 btn btn-warning">View</a><br>			
    <script>
	$(document).ready(function (e) {
    $('#f<?php echo $user['vb_id'] ?>').on('submit',(function(e) {
		me = $(this);
		var ebox = $("#f<?php echo $user['vb_id'] ?>");
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

            </td>
            <td>

            <form id="fp<?php echo $user['vb_id'] ?>" action="server_fundamentals/SUController" method="post">
            	<input type="hidden" name="booth_paid_toggle" value="<?php echo md5("paidIWOJNF2**838.IO".$user['vb_id']) ?>" />
            	<?php
				if($user['vb_paid'] == 1){
					echo '<button type="submit" class="mt-2 btn btn-danger">Mark Not Paid</button><br>';
				}else{
					echo '<button type="submit" class="mt-2 btn btn-success">Mark Paid</button><br>';
				}
				 ?>
                 </form>

    <script>
	$(document).ready(function (e) {
    $('#fp<?php echo $user['vb_id'] ?>').on('submit',(function(e) {
		me = $(this);
		var ebox = $("#fp<?php echo $user['vb_id'] ?>");
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

            </td>
            
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
    <div style="max-width:900px" class="modal-full modal-dialog">
    
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
