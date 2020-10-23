<?php 
require_once("server_fundamentals/SessionHandler.php");

getHead("Subscriber List");
?>
<?php 
$getSoc = mysqlSelect("SELECT * FROM `virtual_booths` 
left join `virtual_booth_types` on vb_vbt_id = vbt_id
left join `virtual_booth_types_subtypes` on vst_vbt_id = vbt_id
where vb_lum_id = ".$USER_ARRAY['lum_id']."
order by vb_id asc limit 1
");

?>
<style>
.dt-button{
	border:none;
	padding:10px;
	background:rgba(101,80,239,1.00);
	border-radius:5px;
	color:rgba(255,255,255,1.00);
}
.dt-button:hover{
	background-color:rgba(1,0,138,1.00);
}

</style>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" type="text/css" />

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
            <h1><?php echo $getSoc['vb_name']; ?> - Subscriber List</h1>
          </div>
          <!-- TOP CONTENT BLOCKS -->
          

            <div class="row">
                <div class="col-12 col-lg-12 col-xl-6 ">
                                <div class="card card-warning">
                                  <div class="card-header">
                                    <h4>Mailing List</h4>
                                  </div>
                                  <div class="card-body text-justify">
                                  <div class="table-responsive">
<table id="MLST" class="datatable table table-bordered table-hover">
	<thead>
    	<tr>
        	<th colspan="1">Name</th>
        	<th colspan="1">Email</th>
        </tr>
    </thead>
    <tbody>
    <?php 
	$getSignUps = mysqlSelect("select * from virtual_booth_mailing 
	left join sm_logins on bml_lum_id = lum_id 
	where bml_vb_id = ".$getSoc['vb_id']." 
	and bml_status =1 
	order by bml_id desc");
	if(is_array($getSignUps)){
		foreach($getSignUps as $SignUp){
			echo '
			<tr>
				<td>'.$SignUp['lum_fname']." ".$SignUp['lum_lname'].'</td>
				<td>'.$SignUp['lum_email'].'</td>
			</tr>			
			';
		}
	}else{
		echo '<tr>
			<td colspan="2">No Student in Mailing List</td>
		</tr>';
	}
	
	
	?>
    </tbody>
</table>

                                
    								 </div>
                                  </div>
                                </div>
                              </div>


                <div class="col-12 col-lg-12 col-xl-6 ">
                                <div class="card card-warning">
                                  <div class="card-header">
                                    <h4>Sign Ups</h4>
                                  </div>
                                  <div class="card-body text-justify">
                                  <div class="table-responsive">
<table id="SLST" class="datatable table table-bordered table-hover">
	<thead>
    	<tr>
        	<th colspan="1">Name</th>
        	<th colspan="1">Email</th>
        </tr>
    </thead>
    <tbody>
    <?php 
	$getSignUps = mysqlSelect("select * from virtual_booth_signups 
	left join sm_logins on vbsup_lum_id = lum_id 
	where vbsup_vb_id = ".$getSoc['vb_id']." 
	and vbsup_status =1 
	order by vbsup_id desc");
	if(is_array($getSignUps)){
		foreach($getSignUps as $SignUp){
			echo '
			<tr>
				<td>'.$SignUp['lum_fname']." ".$SignUp['lum_lname'].'</td>
				<td>'.$SignUp['lum_email'].'</td>
			</tr>			
			';
		}
	}else{
		echo '<tr>
			<td colspan="2">No Signups</td>
		</tr>';
	}
	
	
	?>
    </tbody>
</table>
                                
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
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>






 

<script>
$(document).ready(function() {
    $('#MLST').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>

<script>
$(document).ready(function() {
    $('#SLST').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>

</body>
</html>
