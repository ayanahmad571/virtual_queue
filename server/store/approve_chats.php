<?php 
require_once("server_fundamentals/SessionHandler.php");

getHead("Manage Booth");
?>
<?php 
$getSoc = mysqlSelect("SELECT * FROM `virtual_booths` 
left join `virtual_booth_types` on vb_vbt_id = vbt_id
left join `virtual_booth_types_subtypes` on vst_vbt_id = vbt_id
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
			
			$getRooms = mysqlSelect("SELECT * FROM `virtual_rooms`  where vr_active = 1 and vr_vb_id = ".$getSoc['vb_id']);
			
			if(is_array($getRooms)){
	  ?>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?php echo $getSoc['vb_name']; ?> - Chat Approvals</h1>
          </div>
          <!-- TOP CONTENT BLOCKS -->
          <?php 
		  foreach($getRooms as $room){
		  ?>
            <div class="row">
                <div class="col-12 ">
                    <div class="card card-danger">
                      <div class="card-header">
                        <h4>Room - <?php echo $room['vr_title'] ?></h4>
                        <div class="card-header-action">
                        </div>
                      </div>
                      <div class="card-body table-responsive">
                      <input type="hidden" id="vb_order<?php echo md5("SHEEEMMM".$room['vr_id']) ?>" value="0" />
    <table class="table table-striped table-bordered " id="<?php echo md5("SHEEEMMM".$room['vr_id']) ?>">
	<thead>
    	<tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Text</th>
            <th>Time</th>
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
		  }
			?>


        </section>
        
        
        
      </div><!-- Main Content  -->  
      
      <?php
	  
			}else{
				echo 'You currently do not have any open rooms.';
			}
			
			
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

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<?php
if(is_array($getSoc)){
if(is_array($getRooms)){
	foreach($getRooms as $room){
 ?>


<script>
$('#<?php echo md5("SHEEEMMM".$room['vr_id']) ?>').DataTable({
								"order": [[ 0, "asc" ]]
								});
setInterval(function() {
var t = $('#<?php echo md5("SHEEEMMM".$room['vr_id']) ?>').DataTable();
		var gcid = $("#vb_order<?php echo md5("SHEEEMMM".$room['vr_id']) ?>");
		$.post("server_fundamentals/VBController",
		{
				vb_chat_id: "<?php echo md5("oijdwoijfe".$room['vr_id']); ?>",
				vb_order_id : gcid.val()
		},
		function(data, status){
			if(data== ""){
				
			}else{

	var chats = JSON.parse(data);
	var controller = 0;
			for(var i = 0; i < chats.length; i++) {
				t.row.add( [
						chats[i].order,
						chats[i].name,
						chats[i].text,
						chats[i].time,
						chats[i].action
					] ).draw( false );
			  controller = chats[i].order;
			  gcid.val(controller);
			}




			}
			});
}, 2500)
	
</script>
<!-- Modal -->
<?php 
	}
?>

<?php		
}
}
?>

</body>
</html>
