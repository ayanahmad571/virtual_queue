<?php 
require_once("server_fundamentals/SessionHandler.php");
$getSoc = mysqlSelect("SELECT * FROM `virtual_branch` 
left join admin_branch_type on branch_type_id = bt_id
where branch_lum_id = ".$USER_ARRAY['lum_id']."
order by branch_id asc limit 1
");
if(!is_array($getSoc)){
		header('Location: manage-branch');
		die();
}else{
	$BranchMaster = $getSoc[0];
}

if(isset($_GET['id'])){
	if(!ctype_alnum($_GET['id'])){
		header('Location: manage-branch');
		die();
	}
	$getService = mysqlSelect("SELECT * FROM `virtual_services` s
	left join `virtual_branch` b on s.service_branch_id = b.branch_id
	where s.service_status =1 and  b.branch_status =1
	
	and md5(concat('TINGEHEIUNOIU*****siufniue',service_id)) = '".$_GET['id']."'");
	
	$serviceExists = true;
	if(!is_array($getService)){
		$serviceExists = false;
	}
		$getService = $getService[0];

}else{
		$serviceExists = false;
}






getHead("Manage ".($serviceExists ? $getService['service_name']: "Services")." for ".$BranchMaster['branch_name']);

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
            <h1><?php echo ($serviceExists ? $getService['service_name']." - Service" : "Services")." at ".$BranchMaster['branch_name'];?></h1>
            
          </div>
        
<?php
if(!$serviceExists){

		$getServices= mysqlSelect("SELECT * FROM `virtual_services` where service_branch_id= ".$BranchMaster["branch_id"]);
		if(is_array($getServices)){
			?>
            <div class="row">

            <?php
			foreach($getServices as $service){
				?>
				<div class="col-sm-12 col-lg-6">
                    <div class="section-body">
                        <div class="card author-box card-primary">
                              <div class="card-body">
                                <div class="author-box-details">
                                  <div class="author-box-name">
                                    <?php echo $service['service_name']; ?>
                                  </div>
                                  <div class="author-box-job">Hosted by: <?php echo $BranchMaster['branch_name']; ?></div>
                                  <hr>
                                  <div class="authot author-body">
                                  <?php echo $service['service_desc']; ?>
                                  </div>
                                  <div class="float-right mt-sm-0 mt-4">
                                    <a href="manage-service?id=<?php echo md5("TINGEHEIUNOIU*****siufniue".$service['service_id']); ?>" class="btn"><button class="btn btn-primary">View <i class="fas fa-chevron-right"></i></button></a>
                                  </div>
                                </div>
                              </div>
                        </div>
                    </div>
				</div>
				<?php
				
				}

?>
</div>

<?php
		}else{
			echo "-";
		}
		
}else{
	#main body
?>
<div class="row">
    <div class="col-12 col-xl-6">
        <div class="card card-warning">
            <div class="card-header">
	            <h4>Add to Queue</h4>
            </div>
            
            <div class="card-body text-justify">
                <div class="row">
                	<div id="offlineQueueAdd" align="center" class="col-12">
                        <div id="offlineQueueAddFail" style="display:none; padding:10px; border-radius:10px;background-color:rgba(253,148,150,0.68); color:rgba(255,0,4,1.00)" class="mb-2 mt-2"></div>
    
                        <form id="offlineQueueAddForm" method="POST" action="server_fundamentals/ServiceController">
                        <input type="hidden" value="<?php echo md5($USER_ARRAY['lum_id']."2fr*-/r85f6a3".$getService['service_id']); ?>" name="service_hash" />
                            <p>
                            
                            </p>
                            <div id="signupFail" class="mb-4" style="display:none; background-color:rgba(255,195,196,0.3); color:rgba(255,16,16,1.00); padding:10px; border-radius:8px;">
                            
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-sm-6">
                                    <label for="offlinequeueadd_name">Name</label>
                                    <input id="offlinequeueadd_name" type="text" class="form-control" name="offlinequeueadd_name" autofocus required placeholder="John Doe">
                                </div>
                                <div class="form-group col-12 col-sm-6">
                                    <label for="offlinequeueadd_size">Size (Number of People)</label>
                                    <input id="offlinequeueadd_size" type="text" class="form-control" name="offlinequeueadd_size"  required placeholder="4">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-sm-4">
                                    <label for="offlinequeueadd_mob_code">Mobile Code</label>
                                    <input id="offlinequeueadd_mob_code" type="number" class="form-control" name="offlinequeueadd_mob_code" placeholder="971" value="971"required>
                                </div>
                                <div class="form-group col-12 col-sm-8">
                                    <label for="offlinequeueadd_mob_body">Mobile Number </label>
                                    <input id="offlinequeueadd_mob_body" type="number" class="form-control" name="offlinequeueadd_mob_body" placeholder="555555555"  required>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                Add to Queue
                                </button>
                            </div>
                        </form>
        <div id="offlineQueueAddPass" style="display:none; padding:10px; border-radius:10px;background-color:rgba(16,223,0,0.1); color:green" class="mb-2 mt-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-12 col-xl-6">
        <div class="card card-warning">
            <div class="card-header">
	            <h4>Add a Booking</h4>
            </div>
            
            <div class="card-body text-justify">
                <div class="row">
                	<div id="BookingQueueAdd" align="center" class="col-12">
                        <div id="BookingQueueAddFail" style="display:none; padding:10px; border-radius:10px;background-color:rgba(253,148,150,0.68); color:rgba(255,0,4,1.00)" class="mb-2 mt-2"></div>
    
                        <form id="BookingQueueAddForm" method="POST" action="server_fundamentals/RegisterController">
                        <input type="hidden" value="<?php echo md5("2fr*-/r85f6a3".$getService['service_id']); ?>" name="bookingqueueadd_hash" />
                            <p>
                            
                            </p>
                            <div id="BookingQueueAddFail" class="mb-4" style="display:none; background-color:rgba(255,195,196,0.3); color:rgba(255,16,16,1.00); padding:10px; border-radius:8px;">
                            
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-sm-6">
                                    <label for="bookingqueueadd_name">Name</label>
                                    <input id="bookingqueueadd_name" type="text" class="form-control" name="bookingqueueadd_name"  required placeholder="John Doe">
                                </div>
                                <div class="form-group col-12 col-sm-6">
                                    <label for="bookingqueueadd_size">Size (Number of People)</label>
                                    <input id="bookingqueueadd_size" type="text" class="form-control" name="bookingqueueadd_size"  required placeholder="4">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-sm-4">
                                    <label for="bookingqueueadd_mob_code">Mobile Code</label>
                                    <input id="bookingqueueadd_mob_code" type="number" class="form-control" name="bookingqueueadd_mob_code" placeholder="971" value="971"required>
                                </div>
                                <div class="form-group col-12 col-sm-8">
                                    <label for="bookingqueueadd_mob_body">Mobile Number </label>
                                    <input id="bookingqueueadd_mob_body" type="number" class="form-control" name="bookingqueueadd_mob_body" placeholder="555555555"  required>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                Add Booking
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>


            <div class="row">
                <div class="col-12 ">
                    <div class="card card-danger">
                      <div class="card-header">
                        <h4>Now Serving</h4>
                        <div class="card-header-action">
                        </div>
                      </div>
                      <div class="card-body table-responsive">
                      <input type="hidden" id="serving_queue_order" value="0" />
    <table class="table table-striped table-bordered " id="ServingQueueTableContainer">
	<thead>
    	<tr>
            <th>Position</th>
            <th>Full Name</th>
            <th>Mobile Number</th>
            <th>Time Elapsed</th>
            <th>Delta Time</th>
            <th>Action</th>
        </tr>
        </thead>

        <tbody>
        </tbody>
        
    </table>
                      </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-12 ">
                    <div class="card card-danger">
                      <div class="card-header">
                        <h4>Summoned</h4>
                        <div class="card-header-action">
                        </div>
                      </div>
                      <div class="card-body table-responsive">
                      <input type="hidden" id="notified_queue_order" value="0" />
    <table class="table table-striped table-bordered " id="NotifiedQueueTableContainer">
	<thead>
    	<tr>
            <th>Position</th>
            <th>Full Name</th>
            <th>Mobile Number</th>
            <th>Time Elapsed</th>
            <th>Delta Time</th>
            <th>Action</th>
        </tr>
        </thead>

        <tbody>
        </tbody>
        
    </table>
                      </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-12 ">
                    <div class="card card-danger">
                      <div class="card-header">
                        <h4>Current Queue</h4>
                        <div class="card-header-action">
                        </div>
                      </div>
                      <div class="card-body table-responsive">
                      <input type="hidden" id="queue_order" value="0" />
    <table class="table table-striped table-bordered " id="queueTableContainer">
	<thead>
    	<tr>
            <th>Position</th>
            <th>Full Name</th>
            <th>Mobile Number</th>
            <th>Time Elapsed</th>
            <th>Delta Time</th>
            <th>Action</th>
        </tr>
        </thead>

        <tbody>
        </tbody>
        
    </table>
                      </div>
                    </div>
                </div>
            </div>

            
            









<?php
	#main body
	
}
	?>
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
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<?php
$ScriptArray = array(
array("queueTableContainer",3000,"queue_order","service_order_id"),
array("NotifiedQueueTableContainer",3000,"notified_queue_order","notified_service_order_id"),
array("ServingQueueTableContainer",3000,"serving_queue_order","serving_service_order_id")
);
foreach($ScriptArray as $ScriptOne){
?>
<script>

$('#<?php echo $ScriptOne[0] ?>').DataTable({
								"order": [[ 0, "asc" ]]
								});

setInterval(function() {
var t = $('#<?php echo $ScriptOne[0] ?>').DataTable();
		var gcid = $("#<?php echo $ScriptOne[2] ?>");
		$.post("server_fundamentals/ServiceController",
		{
				service_hash: "<?php echo md5($USER_ARRAY['lum_id']."2fr*-/r85f6a3".$getService['service_id']) ?>",
				<?php echo $ScriptOne[3] ?> : 0
		},
		function(data, status){
			if($.trim(data)== "n"){
t.clear().draw();
				
			}else{
t.clear();
	var chats = JSON.parse(data);
	var controller = 0;
			for(var i = 0; i < chats.length; i++) {
				t.row.add( [
						(i+1),
						chats[i].name,
						chats[i].mobile,
						chats[i].time_elap,
						chats[i].time_delta,
						chats[i].action
					] ).draw( false );
			  controller = chats[i].order;
			  gcid.val(controller);
			  
			}
t.draw();



			}
			});
}, <?php echo $ScriptOne[1] ?>)
	
</script>

<?php
}
?>

<script>
//socials
$(document).ready(function (e) {
    $('#offlineQueueAddForm').on('submit',(function(e) {
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
						$("#offlineQueueAddForm").trigger("reset");

						$("#offlineQueueAddFail").hide();
						$("#offlineQueueAddPass").html("<strong>User Added to Queue</strong>");	
						$("#offlineQueueAddPass").fadeIn();
						setTimeout(function () {
						  $("#offlineQueueAddPass").fadeOut();
						}, 2000)			
				}else{
					$("#offlineQueueAddFail").html(data);
					$("#offlineQueueAddFail").fadeIn();
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
