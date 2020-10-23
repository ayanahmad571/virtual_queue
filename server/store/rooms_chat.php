<?php

require_once("server_fundamentals/SessionHandler.php");
if(!isset($_GET['id'])){
	header('Location: rooms');
	die();
}else{
	if(!ctype_alnum($_GET['id'])){
		header('Location: rooms');
		die();
	}
}

$getSoc = mysqlSelect("SELECT * FROM `virtual_rooms` r
left join virtual_booths v on r.vr_vb_id = v.vb_id
where v.vb_valid =1 and  v.vb_paid=1 and
r.vr_active =1  
and md5(concat('TINGEHEIUNOIU*****siufniue',vr_id)) = '".$_GET['id']."'");

if(!is_array($getSoc)){
	header('Location: rooms');
	die();
}

$pageSoc = $getSoc[0];
getHead($pageSoc['vr_title']." Discussion Room");
?>


<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      
      <?php
	  	getTopBar();
	  	getNavbar($USER_ARRAY['type_mod_id']);
	  ?>
<style>
.scrollable-content {
   overflow-y: scroll !important;
   height: 450px !important;}
</style>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Room - <?php echo $pageSoc['vr_title'] ?></h1>
          </div>
          
            <div class="row align-items-center justify-content-center">
              <div class="col-12 col-sm-6 col-lg-4">
                <div class="card">
                  <div class="card-header">
                    <h4>Peers</h4>
                  </div>
                  <div class="card-body  ">
                    <ul class="list-unstyled list-unstyled-border scrollable-content">
						<?php 
							$selectUsers = mysqlSelect("select * from sm_logins where lum_valid =1");
							if(is_array($selectUsers)){
								foreach($selectUsers as $users){?>
                      <li class="media">
                        <img alt="image" class="mr-3 rounded-circle" width="50" src="<?php echo $users['lum_img_src']; ?>">
                        <div class="media-body">
                          <div class="mt-0 mb-1 font-weight-bold"><?php echo $users['lum_fname']." ".$users['lum_lname']; ?></div>
                          <div class="text-success text-small font-600-bold"><i class="fas fa-circle"></i> Online</div>
                        </div>
                      </li>
								<?php }
							}
						?>

                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-8">
                <div class="card chat-box card-success" id="mychatbox2">
                  <div class="card-header">
                    <h4><i class="fas fa-circle text-success mr-2" title="Online" data-toggle="tooltip"></i> Discussion Panel</h4>
                  </div>
                  <div id="chatscroller" class="card-body chat-content scrollable-content">
                  <hr id="scrollend">
                  </div>
                  <div class="card-footer chat-form">
                    <form action="server_fundamentals/RChatController" id="chat-form2" method="post">
                      <input autocomplete="off" id="gc_add_t" autofocus name="rc_add_text" type="text" class="form-control" placeholder="Type a message">
                      <input id="order_rc_chat" type="hidden" name="order_rc_chat" value="0" />
                      <input id="rc_vr" type="hidden" name="rc_vr" value="<?php echo md5("BHU38Q9EFRO23jt-94-9UN90V89974**--WSD".$pageSoc['vr_id']) ?>" />
                      <button class="btn btn-primary">
                        <i class="far fa-paper-plane"></i>
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>


<div class="row">
    <div class="col-12 ">
        <div class="card">
          <div class="card-header">
            <h4>About the Room</h4>
          </div>
          <div class="card-body">
            <p class="profile-widget-description"><?php echo  $pageSoc['vr_desc2'] ?></p>
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
// On Load for Chat Scripts.
// Load JSON, then add to chats.
$(document).ready(function (e) {
$.post("server_fundamentals/RChatController",
  {
    rc_page_id: 0,
	rc_page_vr : $("#rc_vr").val()
  },
  function(data, status){
//
	if(data == ""){
		}else{
				var chats = JSON.parse(data);
				var lastnumber = 0;
				for(var i = 0; i < chats.length; i++) {
						  var type = 'text';
							  if(chats[i].typing != undefined) type = 'typing';
									  $.chatCtrl('#mychatbox2', {
											text: (chats[i].text != undefined ? chats[i].text : ''),
											picture: chats[i].imageurl,
											time: chats[i].time_f,
											position: 'chat-'+chats[i].position,
											type: type
									  });
						  
						  lastnumber = chats[i].order;
				}
				$("#order_rc_chat").val(lastnumber);
				$("#chatscroller").animate({ scrollTop: $('#chatscroller')[0].scrollHeight}, 1000);
				//
		}
  //else ended
  });
  

});
    </script> 
    
<script>
function updateScroll(){
    var element = document.getElementById("mychatbox2");
    element.scrollTop = element.scrollHeight;
}
//on click of submit button 
// prevent default 

$(document).ready(function (e) {
    $('#chat-form2').on('submit',(function(e) {
		me = $(this);
		e.preventDefault();

			if($("#gc_add_t").val().trim().length > 0) {
						var formData = new FormData(this);
				
						$.ajax({
								type:'POST',
								url: $(this).attr('action'),
								data:formData,
								cache:false,
								contentType: false,
								processData: false,//Start
								success:function(data){
														$("#gc_add_t").val("");
														var gcid = $("#order_rc_chat").val();
														$.post("server_fundamentals/RChatController",
														{
															rc_page_id: gcid,
															rc_page_vr : $("#rc_vr").val()
														},
														function(data, status){
															successOfPushedData(data)})  .fail(function() {
																	alert( "Access Denied. Please Re-Login." );
																  });
														
												},//END
								error: function(data){
										alert("Access Denied");
								}
			});
		
			}
    }));

});

setInterval(function() {
		var gcid = $("#order_rc_chat").val();
		$.post("server_fundamentals/RChatController",
		{
															rc_page_id: gcid,
															rc_page_vr : $("#rc_vr").val()
		},
		function(data, status){
			if(data== ""){
				
			}else{
			successOfPushedData(data);
			}
			});
}, 5000)



function successOfPushedData(data){
	var gccid = $("#order_rc_chat").val();
	const out = document.getElementById("chatscroller");		
	const isScrolledToBottom = (out.scrollHeight - out.clientHeight <= out.scrollTop + 10);
	//
	var chats = JSON.parse(data);
			for(var i = 0; i < chats.length; i++) {
			  var type = 'text';
				  if(chats[i].typing != undefined) type = 'typing';
						  $.chatCtrl('#mychatbox2', {
							text: (chats[i].text != undefined ? chats[i].text : ''),
							picture: chats[i].imageurl,
							time: chats[i].time_f,
							position: 'chat-'+chats[i].position,
							type: type
				  });
			  
			  gccid = chats[i].order;
			}
			
			// scroll to bottom if isScrolledToBottom is true
				if (isScrolledToBottom) {
					$("#chatscroller").animate({ scrollTop: $('#chatscroller')[0].scrollHeight}, 1000);
				}
			
			
			
			$("#order_rc_chat").val(gccid);
			
			//
	
	  
	  
}
</script>
</body>
</html>
