<?php 
require_once("server_fundamentals/SessionHandler.php");
getHead("Manage Booth App");

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
            <h1>Booth Approvals</h1>
          </div>
          <!-- TOP CONTENT BLOCKS -->
            <div class="row">
                <div class="col-12 ">
                    <div class="card card-danger">
                      <div class="card-body table-responsive">
                                            <p>
                      Once a new user Booth is registered to the platform, it is marked as Inactive.<br>
                      Each booth is assosciated with a User Login Account. <br>
                      Login accounts ending with your University Domain are Automatically approved after email verification whereas non university email accounts are not. <br>
                      When you delete a Booth, they are permanently Deleted. <br>
                      A booth can only be marked as approved once the Login account associated with it is approved.
                      When you Approve a Booth, they can be Temporarily Disabled in the Future.
                      </p><br>

                      <input type="hidden" id="inputUserAp" value="0" />
    <table class="table table-striped table-bordered " id="tableUserAp">
	<thead>
    	<tr>
            <th>Owner Name</th>
            <th>Email</th>
            <th>Booth Name</th>
            <th>Category</th>
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
				booth_approvals_get_data: gcid.val()
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
						users_a[i].boothname,
						users_a[i].category,
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
