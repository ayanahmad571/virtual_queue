<?php 
require_once("server_fundamentals/SessionHandler.php");
getHead("Manage User Approvals");

?>
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
            <h1>User Approvals</h1>
          </div>
          <!-- TOP CONTENT BLOCKS -->
            <div class="row">
                <div class="col-12 ">
                    <div class="card card-danger">
                      <div class="card-body table-responsive">
                                            <p>
                      Once a new user Signs Up to the platform, he/she must get approved by the Administrator - <br>
                      If a user is Not-Approved, they are permanently deleted and the user is Informed - <br>
                      When you Approve a user, they can be Temporarily Disabled in the Future.
                      </p><br>

                      <input type="hidden" id="inputUserAp" value="0" />
    <table class="table table-striped table-bordered " id="tableUserAp">
	<thead>
    	<tr>
            <th>Full Name</th>
            <th>Email</th>
            <th>Gender</th>
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
$('#tableUserAp').DataTable({
								"order": [[ 0, "asc" ]]
								});
setInterval(function() {
var t = $('#tableUserAp').DataTable();
		var gcid = $("#inputUserAp");
		$.post("server_fundamentals/SUController",
		{
				user_approvals_get_data: gcid.val()
		},
		function(data, status){
			if(data== ""){
				
			}else{

	var users_a = JSON.parse(data);
	var controller = 0;
			for(var i = 0; i < users_a.length; i++) {
				t.row.add( [
						users_a[i].name,
						users_a[i].email,
						users_a[i].gender,
						users_a[i].action
					] ).draw( false );
			  controller = users_a[i].order;
			  gcid.val(controller);
			}




			}
			});
}, 2500)
	
</script>

    
</body>
</html>
