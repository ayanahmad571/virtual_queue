<?php 
require_once("server_fundamentals/SessionHandler.php");
getHead("Networking");

$chat_session_time = 300;

	$timeInPast = (time()-($chat_session_time));
	$checkForChat = mysqlSelect("select * from c_chat_groups where (cg_1_lum_id = ".$USER_ARRAY['lum_id']." or cg_2_lum_id = ".$USER_ARRAY['lum_id'].") 
	and  (".(time()-($chat_session_time -1 ))." < cg_dnt ) order by cg_dnt desc limit 1 ");
	
	$foundMember = false;
if(is_array($checkForChat)){
	$foundMember = true;
	$checkForChat = $checkForChat[0];
	$getPartnerSql = "select * from sm_logins where lum_id = ".$checkForChat['cg_1_lum_id']." and lum_valid =1";
	
	if($checkForChat['cg_1_lum_id'] == $USER_ARRAY['lum_id']){
	$getPartnerSql = "select * from sm_logins where lum_id = ".$checkForChat['cg_2_lum_id']." and lum_valid =1";

	}
	
	$getPartner = mysqlSelect($getPartnerSql);
	if(!is_array($getPartner)){
		die("Denied.");
	}
	$chatID = $checkForChat['cg_id'];
	
}


?>

<?php if($foundMember){ ?>

<meta http-equiv="refresh" content="<?php echo ($checkForChat['cg_dnt']+$chat_session_time - time() + 1) ?>">
<?php 
}
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
            <h1>Meet a Student</h1>
            <div class="section-header-breadcrumb">
            <div>
            <label>Time Left: </label> <h3 id="countdownTimer"></h3>
            
            </div>
            </div>
          </div>
          <div class="section-body">
            <h2 class="section-title">Chat Boxes</h2>
            <p class="section-lead">Frestive connects you with a random user from the university. A conversation lasts 5 minutes thereafter the page is refreshed and you get connected with a new user.</p>


<?php if($foundMember){ ?>

            <div id="ConnectedUser" class="row align-items-center justify-content-center">
              <div class="col-12 col-sm-6 col-lg-4">
                <div class="card">
                  <div class="card-header">
                    <h4>Connected User</h4>
                  </div>
                  <div class="card-body  ">
                  <div class="scrollable-content">
                    <ul class="list-unstyled list-unstyled-border ">
                      <li class="media">
                        <img alt="image" class="mr-3 rounded-circle" width="50" src="<?php echo $getPartner[0]['lum_img_src']; ?>">
                        <div class="media-body">
                          <div class="mt-0 mb-1 font-weight-bold"><?php echo $getPartner[0]['lum_fname']." ".$getPartner[0]['lum_lname']; ?></div>
                          <div class="text-success text-small font-600-bold"><i class="fas fa-circle"></i> Online</div>
                        </div>
                      </li>

                    </ul>
                    
                    <ul class="list-group mt-4">
                      <li class="list-group-item">Email: <strong><?php echo $getPartner[0]['lum_email'] ?></strong></li>
                      <li class="list-group-item">Age: <strong><?php echo $getPartner[0]['lum_age'] ?></strong></li>
                      <li class="list-group-item">Interests: <strong><?php echo $getPartner[0]['lum_interests'] ?></strong></li>
                      <li class="list-group-item">Gender: <strong><?php echo str_replace("3","Other",str_replace("2","Female",str_replace("1","Male",$getPartner[0]['lum_gender'])))?></strong></li>
                    </ul>
                    </div>
                    
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-8">
                <div class="card chat-box card-success" id="mychatbox2">
                  <div class="card-header">
                    <h4><i class="fas fa-circle text-success mr-2" title="Online" data-toggle="tooltip"></i> Chat with <?php echo $getPartner[0]['lum_fname'] ?></h4>
                  </div>
                  <div id="chatscroller" class="card-body chat-content scrollable-content">
                  <hr id="scrollend">
                  </div>
                  <div class="card-footer chat-form">
                    <form action="server_fundamentals/GChatController" id="chat-form2" method="post">
                      <input id="gc_add_t" autofocus name="gc_add_text" type="text" class="form-control" placeholder="Type a message">
                      <input id="gc_cg_id" type="hidden" name="gc_cg_id" value="<?php echo md5(md5("U2809RFHU2894HYGEW%^**".$chatID)) ?>">
                      <input id="order_gc_chat" type="hidden" name="order_gc_chat" value="0" />
                      <button class="btn btn-primary">
                        <i class="far fa-paper-plane"></i>
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
<?php 
}else{

 ?>
<div id="rowUserContainer" class="row align-items-center justify-content-center">
              <div class="col-12 col-md-10 col-lg-10 col-xl-8">
                <div class="card">
                  <div class="card-header">
                    <h4>Instructions</h4>
                  </div>
                  <div class="card-body  ">
                  <div class="row">
                  <div class="col-12 col-sm-8 col-md-6 ">
                    <ul class="list-unstyled list-unstyled-border">
                      <li class="media">
                        <img alt="image" class="mr-3 rounded-circle" width="50" src="<?php echo $USER_ARRAY['lum_img_src']; ?>">
                        <div class="media-body">
                          <div class="mt-0 mb-1 font-weight-bold"><?php echo $USER_ARRAY['lum_fname']." ".$USER_ARRAY['lum_lname']; ?></div>
                          <div id="textOnline" class="text-small font-600-bold"><i class="fas fa-circle"></i> Offline</div>
                        </div>
                      </li>
                      </ul>
                  </div>
                  <div id="btnContainer" class="col-12 col-sm-8 col-md-6 ">
						<button id="btnOnline" class="btn btn-success">Go Online</button>
                  </div>
                  
                  </div>
                  <hr>

                      <br>
                      <p id="contentContainer">
                      You are currently <strong>offline</strong>, In order to connect with a peer, click on the button above to broadcast your status as <strong>"online"</strong>.<br>
                      The process is as follows<br><br>
                            	<strong> - After the button is clicked your status is changed to online</strong><br>
                                <strong> - The System will attempt match you with a peer based on your age and interests.</strong><br>
                                <strong> - Once the system matches you with a user, you will have five minutes to get to know the person and exchange Socials.</strong><br>
                                <strong> - Lets Get Chatting!!</strong>
                      </p>


                  </div>
                </div>
              </div>
            </div>
<?php 

}
?>          </div>
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

<?php if($foundMember){ ?>
<script>
var timeleft = <?php echo ($checkForChat['cg_dnt']+$chat_session_time - time()) ?>;
var downloadTimer = setInterval(function(){
  if(timeleft <= 0){
    clearInterval(downloadTimer);
    document.getElementById("countdownTimer").innerHTML = "Finished";
  } else {
	  minutes = Math.floor( timeleft / 60);
	  seconds = timeleft - minutes * 60;
    document.getElementById("countdownTimer").innerHTML = minutes + ":" + seconds + " mins";
  }
  timeleft -= 1;
}, 1000);
</script>


<script>
// On Load for Chat Scripts.
// Load JSON, then add to chats.
$(document).ready(function (e) {
$.post("server_fundamentals/GChatController",
  {
    gc_page_id: 0,
	gc_cg_id: '<?php echo md5(md5("U2809RFHU2894HYGEW%^**".$chatID)) ?>' 
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
			$("#order_gc_chat").val(lastnumber);
			$("#chatscroller").animate({ scrollTop: $('#chatscroller')[0].scrollHeight}, 1000);
			//
			}
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
														var gcid = $("#order_gc_chat").val();
														$.post("server_fundamentals/GChatController",
														{
														gc_page_id: gcid,
														gc_cg_id: '<?php echo md5(md5("U2809RFHU2894HYGEW%^**".$chatID)) ?>' 
														},
														function(data, status){successOfPushedData(data)});

														},//END
								error: function(data){
										alert("Please Contact Administrator Access Denied");
								}
			});
		
			}
    }));

});

setInterval(function() {
		var gcid = $("#order_gc_chat").val();
		$.post("server_fundamentals/GChatController",
		{
		gc_page_id: gcid,
		gc_cg_id: '<?php echo md5(md5("U2809RFHU2894HYGEW%^**".$chatID)) ?>' 
		},
		function(data, status){
			if(data== ""){
				
			}else{
			successOfPushedData(data);
			}
			});
}, 3000)



function successOfPushedData(data){
	var gccid = $("#order_gc_chat").val();
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
			
			
			
			$("#order_gc_chat").val(gccid);
			
			//
	
	  
	  
}
</script>

<?php }else{ ?>


<script>
<?php
if(isset($_GET['id'])){
 ?>
$(document).ready(function() {

$('#btnOnline').trigger('click')



});

<?php
}
?>

$( "#btnOnline" ).on( "click", function() {
	$("#textOnline").addClass("text-success");
	$("#textOnline").html('<i class="fas fa-circle"></i> Online');
	$( "#btnContainer" ).html('<a href="networking"><button class="btn btn-danger">Go Offline</button></a>');
	contentContainer
	$("#contentContainer").html('<div align="center"><img src="assets/img/loader.gif" width="200px" /><br>Finding you a peer (upto 1 minute)... </div>');
	checkMatch();
	
});
function checkMatch(){
	
	setInterval(function() {
		$.post("server_fundamentals/GChatController",
		{
		gc_online_handler: "<?php echo md5(md5($USER_ARRAY['lum_id']."AIOUO***/.***G*g*43*wh")); ?>"
		},
		function(data, status){
			if(data== "1"){
				window.location = "networking?id=<?php echo md5(uniqid()) ?>";
			}else{
				
			}
			});
	}, 2000)


}
</script>

<?php } ?>
</body>
</html>
