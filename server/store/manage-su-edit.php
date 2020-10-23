<?php 
require_once("server_fundamentals/SessionHandler.php");
getHead("Super Admin Panel");

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
            <h1>Super Admin Panel Data Edit</h1>
          </div>
          <!-- TOP CONTENT BLOCKS -->
          
            <div class="row">
                <div class="col-12 ">
                    <div class="card card-danger">
                      <div class="card-header">
                        <h4>User Data</h4>
                        <div class="card-header-action">
                          <div class="btn-group">
                            <a id="btnUsersTableRemove" href="#" class="btn btn-danger">-</a>
                            <a id="btnUsersTableLoad" href="#" class="btn btn-warning">+</a>
                          </div>
                        </div>
                      </div>
                      <div id="btnUsersTableBody" class="card-body table-responsive">
                        <p>Enter Button to Load Data</p>
                      </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 ">
                    <div class="card card-danger">
                      <div class="card-header">
                        <h4>Societies</h4>
                        <div class="card-header-action">
                          <div class="btn-group">
                            <a id="btnSocsTableRemove" href="#" class="btn btn-danger">-</a>
                            <a id="btnSocsTableLoad" href="#" class="btn btn-warning">+</a>
                          </div>
                        </div>
                      </div>
                      <div id="btnSocsTableBody" class="card-body table-responsive">
                        <p>Enter Button to Load Data</p>
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

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>


<script>
$( "#btnUsersTableLoad" ).on( "click", function() {
	$("#btnUsersTableBody").html('<div align="center"><img src="assets/img/loader.gif" width="200px" /> </div>');
	getUserData();
	
});
$( "#btnUsersTableRemove" ).on( "click", function() {
	$("#btnUsersTableBody").html('');

});
		function getUserData(){
			
		//	setInterval(function() {
				$.post("server_fundamentals/AdminController",
				{
				load_data_user: "1"
				},
				function(data, status){
						$("#btnUsersTableBody").html(data);
							$('#btnUsersTableInnerBody').DataTable({
								"order": [[ 0, "desc" ]]
								});
								
	$('.openPopup').on('click',function(){
        var dataURL = $(this).attr('data-href');
        $('.modal-body').load(dataURL,function(){
            $('#myModal').modal({show:true});
        });
    }); 
					});
		//	}, 2000)
		
		
		}
</script>
<!-- Modal -->
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
