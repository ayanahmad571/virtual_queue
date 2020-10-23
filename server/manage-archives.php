<?php 
require_once("server_fundamentals/SessionHandler.php");
$getSoc = mysqlSelect("SELECT * FROM `virtual_branch` 
left join admin_branch_type on branch_type_id = bt_id
where branch_lum_id = ".$USER_ARRAY['lum_id']."
order by branch_id asc limit 1
");
if(!is_array($getSoc)){
		header('Location: manage-archives');
		die();
}else{
	$BranchMaster = $getSoc[0];
}

if(isset($_GET['id'])){
	if(!ctype_alnum($_GET['id'])){
		header('Location: manage-archives');
		die();
	}
	$getService = mysqlSelect("SELECT * FROM `virtual_services` s
	left join `virtual_branch` b on s.service_branch_id = b.branch_id
	where s.service_status =1 and  b.branch_status =1
	
	and md5(concat('aTINGEHEIUNOIU*****siufniue',service_id)) = '".$_GET['id']."'");
	
	$serviceExists = true;
	if(!is_array($getService)){
		$serviceExists = false;
	}
		$getService = $getService[0];

}else{
		$serviceExists = false;
}






getHead("Manage Archives ".($serviceExists ? $getService['service_name']: "")." for ".$BranchMaster['branch_name']);

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
            <h1>Archives at <?php echo ($serviceExists ? $getService['service_name']." - Service" : "Services")." at ".$BranchMaster['branch_name'];?></h1>
            
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
                                    <a href="manage-archives?id=<?php echo md5("aTINGEHEIUNOIU*****siufniue".$service['service_id']); ?>" class="btn"><button class="btn btn-primary">View <i class="fas fa-chevron-right"></i></button></a>
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
                <div class="col-12 ">
                    <div class="card card-danger">
                      <div class="card-header">
                        <h4>No Show</h4>
                        <div class="card-header-action">
                        </div>
                      </div>
                      <div class="card-body table-responsive">
    <table class="table table-striped table-bordered " id="NoShowTable">
	<thead>
    	<tr>
            <th>Order</th>
            <th>Full Name</th>
            <th>Mobile Number</th>
            <th>Time Joined</th>
            <th>Time Removed</th>
        </tr>
        </thead>

        <tbody>
        <?php
		
		$getQueue = mysqlSelect("SELECT * FROM `virtual_queue_container` q
								left join client_logins on queue_lum_id = lum_id
								where queue_service_id = ".$getService['service_id']."
								and queue_state= 5
								order by queue_dnt asc");
			
			
			if(is_array($getQueue)){
				$i = 0;
				foreach($getQueue as $QueueObject){
					$i++;
					?>
                    <tr>
                    	<td><?php echo $i; ?></td>
                    	<td><?php echo (is_null($QueueObject['queue_lum_id']) ? $QueueObject['queue_user_name']:($QueueObject['lum_fname']." ".$QueueObject['lum_lname'])); ?></td>
                    	<td><?php echo (is_null($QueueObject['queue_lum_id']) ? ("+".$QueueObject['queue_user_mob_code']."-".$QueueObject['queue_user_mob_body']):("+".$QueueObject['lum_mob_code']."-".$QueueObject['lum_mob_body'])); ?></td>
                    	<td><?php echo round((time()-$QueueObject['queue_dnt'])/60)." mins"; ?></td>
                    	<td><?php echo round((time()-$QueueObject['queue_dnt'])/60)." mins" ?></td>
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


            <div class="row">
                <div class="col-12 ">
                    <div class="card card-danger">
                      <div class="card-header">
                        <h4>Left the Queue</h4>
                        <div class="card-header-action">
                        </div>
                      </div>
                      <div class="card-body table-responsive">
                      <input type="hidden" id="notified_queue_order" value="0" />
    <table class="table table-striped table-bordered " id="LeftQueueTable">
	<thead>
    	<tr>
            <th>Position</th>
            <th>Full Name</th>
            <th>Mobile Number</th>
            <th>Time Joined</th>
            <th>Time Left</th>
        </tr>
        </thead>

        <tbody>
        <?php
		
		$getQueue = mysqlSelect("SELECT * FROM `virtual_queue_container` q
								left join client_logins on queue_lum_id = lum_id
								where queue_service_id = ".$getService['service_id']."
								and queue_state= 6
								order by queue_dnt asc");
			
			
			if(is_array($getQueue)){
				$i = 0;
				foreach($getQueue as $QueueObject){
					$i++;
					?>
                    <tr>
                    	<td><?php echo $i; ?></td>
                    	<td><?php echo (is_null($QueueObject['queue_lum_id']) ? $QueueObject['queue_user_name']:($QueueObject['lum_fname']." ".$QueueObject['lum_lname'])); ?></td>
                    	<td><?php echo (is_null($QueueObject['queue_lum_id']) ? ("+".$QueueObject['queue_user_mob_code']."-".$QueueObject['queue_user_mob_body']):("+".$QueueObject['lum_mob_code']."-".$QueueObject['lum_mob_body'])); ?></td>
                    	<td><?php echo round((time()-$QueueObject['queue_dnt'])/60)." mins"; ?></td>
                    	<td><?php echo round((time()-$QueueObject['queue_dnt'])/60)." mins" ?></td>
                    </tr>
                    <?php
				
				}
			}
		?>        </tbody>
        
    </table>
                      </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-12 ">
                    <div class="card card-danger">
                      <div class="card-header">
                        <h4>Removed from Queue</h4>
                        <div class="card-header-action">
                        </div>
                      </div>
                      <div class="card-body table-responsive">
                      <input type="hidden" id="queue_order" value="0" />
    <table class="table table-striped table-bordered " id="RemovedTable">
	<thead>
    	<tr>
            <th>Position</th>
            <th>Full Name</th>
            <th>Mobile Number</th>
            <th>Time Joined</th>
            <th>Time Removed</th>
        </tr>
        </thead>

        <tbody>
        <?php
		
		$getQueue = mysqlSelect("SELECT * FROM `virtual_queue_container` q
								left join client_logins on queue_lum_id = lum_id
								where queue_service_id = ".$getService['service_id']."
								and queue_state= 7
								order by queue_dnt asc");
			
			
			if(is_array($getQueue)){
				$i = 0;
				foreach($getQueue as $QueueObject){
					$i++;
					?>
                    <tr>
                    	<td><?php echo $i; ?></td>
                    	<td><?php echo (is_null($QueueObject['queue_lum_id']) ? $QueueObject['queue_user_name']:($QueueObject['lum_fname']." ".$QueueObject['lum_lname'])); ?></td>
                    	<td><?php echo (is_null($QueueObject['queue_lum_id']) ? ("+".$QueueObject['queue_user_mob_code']."-".$QueueObject['queue_user_mob_body']):("+".$QueueObject['lum_mob_code']."-".$QueueObject['lum_mob_body'])); ?></td>
                    	<td><?php echo round((time()-$QueueObject['queue_dnt'])/60)." mins"; ?></td>
                    	<td><?php echo round((time()-$QueueObject['queue_dnt'])/60)." mins" ?></td>
                    </tr>
                    <?php
				
				}
			}
		?>        </tbody>
        
    </table>
                      </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 ">
                    <div class="card card-danger">
                      <div class="card-header">
                        <h4>Order Completed</h4>
                        <div class="card-header-action">
                        </div>
                      </div>
                      <div class="card-body table-responsive">
    <table class="table table-striped table-bordered " id="CompleteTable">
	<thead>
    	<tr>
            <th>Position</th>
            <th>Full Name</th>
            <th>Mobile Number</th>
            <th>Time Joined</th>
            <th>Time Completed</th>
        </tr>
        </thead>

        <tbody>
        <?php
		
		$getQueue = mysqlSelect("SELECT * FROM `virtual_queue_container` q
								left join client_logins on queue_lum_id = lum_id
								where queue_service_id = ".$getService['service_id']."
								and queue_state= 8
								order by queue_dnt asc");
			
			
			if(is_array($getQueue)){
				$i = 0;
				foreach($getQueue as $QueueObject){
					$i++;
					?>
                    <tr>
                    	<td><?php echo $i; ?></td>
                    	<td><?php echo (is_null($QueueObject['queue_lum_id']) ? $QueueObject['queue_user_name']:($QueueObject['lum_fname']." ".$QueueObject['lum_lname'])); ?></td>
                    	<td><?php echo (is_null($QueueObject['queue_lum_id']) ? ("+".$QueueObject['queue_user_mob_code']."-".$QueueObject['queue_user_mob_body']):("+".$QueueObject['lum_mob_code']."-".$QueueObject['lum_mob_body'])); ?></td>
                    	<td><?php echo round((time()-$QueueObject['queue_dnt'])/60)." mins"; ?></td>
                    	<td><?php echo round((time()-$QueueObject['queue_dnt'])/60)." mins" ?></td>
                    </tr>
                    <?php
				
				}
			}
		?>        </tbody>
        
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
array("NoShowTable"),
array("LeftQueueTable"),
array("RemovedTable"),
array("CompleteTable")
);
foreach($ScriptArray as $ScriptOne){
?>
<script>

$('#<?php echo $ScriptOne[0] ?>').DataTable({
								"order": [[ 0, "asc" ]]
								});

</script>

<?php
}
?>


</body>
</html>
