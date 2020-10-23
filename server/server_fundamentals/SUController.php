<?php
require_once("SessionHandler.php");
require_once("Settings.php");
require_once("DatabaseConnection.php");
require_once("FunctionsController.php");

if(isset($_POST['booth_approvals_get_data'])){
	if(!is_numeric($_POST['booth_approvals_get_data'])) die("");
	$r = array();
	#
		$getUserData = mysqlSelect("SELECT *,ifnull(vst_name, '-') as vst_name_filtered FROM `virtual_booths` 
		left join sm_logins on vb_lum_id = lum_id
		left join virtual_booth_types on vb_vbt_id = vbt_id
		left join virtual_booth_types_subtypes on vb_vst_id = vst_id
		left join sm_gender on lum_gender = gn_id
		where lum_type =3 and  (lum_valid = 0 or lum_valid = 1) and lum_email_ver = 1 and 
		vb_valid = 0 and vb_id > ".$_POST['booth_approvals_get_data']." order by lum_id asc");
	if(!is_array($getUserData)) die();
	foreach($getUserData as $userD){
		$u = uniqid();
		$r[] = array("name"=>"<strong>".($userD['lum_fname']." ".$userD['lum_lname']).'</strong><br> Email Verified and User '.($userD['lum_valid'] == 1 ? "
		<strong>Approved</strong>":"<strong>Not-Approved</strong>"),
		
		 "email"=>$userD['lum_email'],
		"boothname"=>$userD['vb_name'],
		 "category"=>($userD['vbt_name']." : ".$userD['vst_name_filtered']), 
		 "order"=>$userD['vb_id'],
		 "time"=>date("D-M-Y",$userD['lum_dnt']),
		  "action"=>'
		<div id="c'.$u.'">
		<div id="e'.$u.'" class="mt-1 mb-1" style="color:#b00">
		</div>
		<form method="post" id="a'.$u.'" action="server_fundamentals/SUController">
			<input type="hidden" name="boothApproval" value="'.md5("j3tuisbrhiujr8u9rh**".$userD['vb_id']).'"/>
			<button class="btn btn-success mt-2 mb-2">Approve</button>
		</form>
		<form  method="post" id="b'.$u.'" action="server_fundamentals/SUController">
			<input type="hidden" name="boothDelete" value="'.md5("njrdifnweenerwnijodn4ei**".$userD['vb_id']).'"/>
			<button class="btn btn-danger mt-2 mb-2">Delete</button>
		</form>
		</div>
		
		<script>
$(document).ready(function (e) {
    $(\'#a'.$u.'\').on(\'submit\',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:\'POST\',
            url: $(this).attr(\'action\'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
				if(data == "-"){
					$(\'#c'.$u.'\').html("Approved Booth and User");
				}else{
					$("#e'.$u.'").html(data);
				}
					
            },
            error: function(data){
                alert("Contact Admin.");
            }
        });
    }));

});
    </script> 
		<script>
$(document).ready(function (e) {
    $(\'#b'.$u.'\').on(\'submit\',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:\'POST\',
            url: $(this).attr(\'action\'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
				if(data == "-"){
					$("#c'.$u.'").html("Deleted User and Booth");
				}else{
					$("#e'.$u.'").html(data);
				}
					
					
            },
            error: function(data){
                alert("Contact Admin.");
            }
        });
    }));

});
    </script> 


		');
	}
	echo json_encode($r);
}
#
if(isset($_POST['user_approvals_get_data'])){
	if(!is_numeric($_POST['user_approvals_get_data'])) die("");
	$r = array();
	#
	$getUserData = mysqlSelect("select * from sm_logins 
	left join sm_gender on lum_gender = gn_id
	where lum_type =2 and  lum_valid = 0 and lum_email_ver = 1 and lum_id > ".$_POST['user_approvals_get_data']." order by lum_id asc");
	if(!is_array($getUserData)) die();
	foreach($getUserData as $userD){
		$u = uniqid();
		$r[] = array("name"=>($userD['lum_fname']." ".$userD['lum_lname']), "email"=>$userD['lum_email'],
		"gender"=>$userD['gn_name'], "order"=>$userD['lum_id'],"time"=>date("D-M-Y",$userD['lum_dnt']), "action"=>'
		<div id="c'.$u.'">
		<div id="e'.$u.'" class="mt-1 mb-1" style="color:#b00">
		</div>
		<form method="post" id="a'.$u.'" action="server_fundamentals/SUController">
			<input type="hidden" name="userApproval" value="'.md5("jufsidnjrwgbfrwknhnhg34098iowr**".$userD['lum_id']).'"/>
			<button class="btn btn-success mt-2 mb-2">Approve</button>
		</form>
		<form  method="post" id="b'.$u.'" action="server_fundamentals/SUController">
			<input type="hidden" name="userDelete" value="'.md5("wjeioshujbwirdsh**".$userD['lum_id']).'"/>
			<button class="btn btn-danger mt-2 mb-2">Delete</button>
		</form>
		</div>
		
		<script>
$(document).ready(function (e) {
    $(\'#a'.$u.'\').on(\'submit\',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:\'POST\',
            url: $(this).attr(\'action\'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
				if(data == "-"){
					$(\'#c'.$u.'\').html("Approved User");
				}else{
					$("#e'.$u.'").html(data);
				}
					
            },
            error: function(data){
                alert("Contact Admin.");
            }
        });
    }));

});
    </script> 
		<script>
$(document).ready(function (e) {
    $(\'#b'.$u.'\').on(\'submit\',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:\'POST\',
            url: $(this).attr(\'action\'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
				if(data == "-"){
					$("#c'.$u.'").html("Deleted User");
				}else{
					$("#e'.$u.'").html(data);
				}
					
					
            },
            error: function(data){
                alert("Contact Admin.");
            }
        });
    }));

});
    </script> 


		');
	}
	echo json_encode($r);
}
#
if(isset($_POST['user_toggle'])){
	if(!ctype_alnum($_POST['user_toggle'])){
		die("Not Found");
	}
		$getUser = mysqlSelect("select * from sm_logins where md5(concat('IWOJNF2838.IO',lum_id)) = '".$_POST['user_toggle']."'");
		
		if(!is_array($getUser)){
			die("User Not Found");
		}
		
		$updateSql = "";
		$retdata = '
		<input type="hidden" name="user_toggle" value="'.md5("IWOJNF2838.IO".$getUser[0]['lum_id']).'" />
		
		';
		
		if($getUser[0]['lum_valid'] == 1){
			#disable
		$updateSql = "UPDATE `sm_logins` SET `lum_valid` = 4 where lum_id = ".$getUser[0]['lum_id']."";
		$retdata .= '<button type="submit" class="mt-2 btn btn-success">Enable</button><br>';
		}else{
			#enable
		$updateSql = "UPDATE `sm_logins` SET `lum_valid` = 1 where lum_id = ".$getUser[0]['lum_id']."";
		$retdata .= '<button type="submit" class="mt-2 btn btn-danger">Disable</button><br>';
		}
		
$updateData = mysqlUpdateData($updateSql,true);
if(!is_numeric($updateData)){
	die('Could Not Update User data. 503 Server Error');
}
	echo $retdata;	
		

}
#
if(isset($_POST['booth_toggle'])){
	if(!ctype_alnum($_POST['booth_toggle'])){
		die("Not Found");
	}
		$getUser = mysqlSelect("
		SELECT *,ifnull(vst_name, '-') as vst_name_filtered FROM `virtual_booths` 
		left join sm_logins on vb_lum_id = lum_id
		left join virtual_booth_types on vb_vbt_id = vbt_id
		left join virtual_booth_types_subtypes on vb_vst_id = vst_id
		left join sm_gender on lum_gender = gn_id
		where lum_type =3 and  lum_valid in (1,4) and lum_email_ver = 1
		and vb_valid in (1,4) and  md5(concat('IWOJNF2**838.IO',vb_id)) = '".$_POST['booth_toggle']."'");
		
		if(!is_array($getUser)){
			die("Booth Not Found");
		}
		
		$updateSql = "";
		$updateSql2 = "";
		$retdata = '
		<input type="hidden" name="booth_toggle" value="'.md5("IWOJNF2**838.IO".$getUser[0]['vb_id']).'" />
		
		';
		
		if($getUser[0]['lum_valid'] == 1){
			#disable
		$updateSql = "UPDATE `virtual_booths` SET `vb_valid` = 4 where vb_id = ".$getUser[0]['vb_id']."";
		$updateSql2 = "UPDATE `sm_logins` SET `lum_valid` = 4 where lum_id = ".$getUser[0]['lum_id']."";
		$retdata .= '<button type="submit" class="mt-2 btn btn-success">Enable</button><br>';
		}else{
			#enable
		$updateSql = "UPDATE `virtual_booths` SET `vb_valid` = 1 where vb_id = ".$getUser[0]['vb_id']."";
		$updateSql2 = "UPDATE `sm_logins` SET `lum_valid` = 1 where lum_id = ".$getUser[0]['lum_id']."";
		$retdata .= '<button type="submit" class="mt-2 btn btn-danger">Disable</button><br>';
		}
$updateData = mysqlUpdateData($updateSql,true);
$updateData2 = mysqlUpdateData($updateSql2 ,true);
if(is_numeric($updateData) && is_numeric($updateData2)  ){
	die($retdata);	
	
}else{
	die('Could Not Update Booth data. 503 Server Error');
}
		

}
#
if(isset($_POST['booth_paid_toggle'])){
	if(!ctype_alnum($_POST['booth_paid_toggle'])){
		die("Booth Not Found");
	}
		$getUser = mysqlSelect("
		SELECT *,ifnull(vst_name, '-') as vst_name_filtered FROM `virtual_booths` 
		left join sm_logins on vb_lum_id = lum_id
		left join virtual_booth_types on vb_vbt_id = vbt_id
		left join virtual_booth_types_subtypes on vb_vst_id = vst_id
		left join sm_gender on lum_gender = gn_id
		where lum_type =3 and  lum_valid in (1,4) and lum_email_ver = 1
		and vb_valid in (1,4) and  md5(concat('paidIWOJNF2**838.IO',vb_id)) = '".$_POST['booth_paid_toggle']."'");
		
		if(!is_array($getUser)){
			die("Booth Not Found");
		}
		
		$updateSql = "";
		$updateSql2 = "";
		$retdata = '
		<input type="hidden" name="booth_paid_toggle" value="'.md5("paidIWOJNF2**838.IO".$getUser[0]['vb_id']).'" />
		
		';
		
		if($getUser[0]['vb_paid'] == 1){
			#disable
		$updateSql = "UPDATE `virtual_booths` SET `vb_paid` = 0 where vb_id = ".$getUser[0]['vb_id']."";
		$retdata .= '<button type="submit" class="mt-2 btn btn-success">Mark Paid</button><br>';
		}else{
			#enable
		$updateSql = "UPDATE `virtual_booths` SET `vb_paid` = 1 where vb_id = ".$getUser[0]['vb_id']."";
		$retdata .= '<button type="submit" class="mt-2 btn btn-danger">Mark Not Paid</button><br>';
		}
$updateData = mysqlUpdateData($updateSql,true);
if(is_numeric($updateData) ){
	die($retdata);	
	
}else{
	die('Could Not Mark Booth as Paid');
}
		

}
#
#user
if(isset($_POST['userApproval'])){
	$getUser = mysqlSelect("select *, concat(lum_fname, ' ', lum_lname) as lum_name from sm_logins 
	where lum_type =2 and  lum_valid = 0 and lum_email_ver = 1 and md5(concat('jufsidnjrwgbfrwknhnhg34098iowr**',lum_id)) = '".$_POST['userApproval']."' ");
	
	if(!is_array($getUser)) die("User Not Found");
	$updtStatus = mysqlUpdateData("update sm_logins set lum_valid = 1 where lum_id = ".$getUser[0]['lum_id'],true);
	
	if(!is_numeric($updtStatus)) die("User Not Approved. Contact Admin ERR9981"); 
	
	$sendEmail = mysqlInsertData("
INSERT INTO `m_email`(`e_to_name`, `e_to_email`, `e_subject`, `e_body_t_id`, `e_body_json`, `e_alt_body`, `e_dnt_posted`) VALUES (
'".$getUser[0]['lum_name']."',
'".$getUser[0]['lum_email']."',
'Account Approvals by Frestive for ".$getUser[0]['lum_name']."',
2,
'Approved',
'Approved',
'".time()."');", true);

	if(!is_numeric($sendEmail)) die("Email Not Sent, but User has been Approved"); 

	die("-");
}
#
if(isset($_POST['userDelete'])){
	$getUser = mysqlSelect("select *,concat(lum_fname, ' ', lum_lname) as lum_name from sm_logins 
	where lum_type =2 and  lum_valid = 0 and lum_email_ver = 1 and md5(concat('wjeioshujbwirdsh**',lum_id)) = '".$_POST['userDelete']."' ");
	
	if(!is_array($getUser)) die("User Not Found");
	$updtStatus = mysqlUpdateData("update sm_logins set lum_valid = 2 where lum_id = ".$getUser[0]['lum_id'],true);
	
	if(!is_numeric($updtStatus)) die("User Not Deleted. Contact Admin ERR9981"); 

	$sendEmail = mysqlInsertData("
INSERT INTO `m_email`(`e_to_name`, `e_to_email`, `e_subject`, `e_body_t_id`, `e_body_json`, `e_alt_body`, `e_dnt_posted`) VALUES (
'".$getUser[0]['lum_name']."',
'".$getUser[0]['lum_email']."',
'Account Approvals by Frestive for ".$getUser[0]['lum_name']."',
5,
'Not Approved',
'Not Approved',
'".time()."');", true);

	if(!is_numeric($sendEmail)) die("Email Not Sent, but User has been Approved"); 

	die("-");
}
#
if(isset($_POST['boothApproval'])){
	$getUser = mysqlSelect("
	SELECT *, concat(lum_fname, ' ', lum_lname) as lum_name ,ifnull(vst_name, '-') as vst_name_filtered FROM `virtual_booths` 
	left join sm_logins on vb_lum_id = lum_id
	left join virtual_booth_types on vb_vbt_id = vbt_id
	left join virtual_booth_types_subtypes on vb_vst_id = vst_id
	left join sm_gender on lum_gender = gn_id
	where lum_type =3 and  (lum_valid = 0 or lum_valid = 1) and lum_email_ver = 1 and 
	vb_valid = 0 and md5(concat('j3tuisbrhiujr8u9rh**',vb_id)) = '".$_POST['boothApproval']."' ");
	
	if(!is_array($getUser)) die("Booth Not Found");
	
	$updtStatus = mysqlUpdateData("update sm_logins set lum_valid = 1 where lum_id = ".$getUser[0]['lum_id'],true);
	
	if(!is_numeric($updtStatus)) die("User Not Approved. Contact Admin ERRE1"); 


	$updtStatus2 = mysqlUpdateData("update virtual_booths set vb_valid = 1 where vb_id = ".$getUser[0]['vb_id'],true);
	
	if(!is_numeric($updtStatus2)) die("Booth Not Approved. Contact Admin ERRE2"); 

	
	$sendEmail = mysqlInsertData("
INSERT INTO `m_email`(`e_to_name`, `e_to_email`, `e_subject`, `e_body_t_id`, `e_body_json`, `e_alt_body`, `e_dnt_posted`) VALUES (
'".$getUser[0]['lum_name']."',
'".$getUser[0]['lum_email']."',
'Booth Active on Frestive - ".$getUser[0]['vb_name']."',
8,
'User and Booth Approved',
'User and Booth Approved',
'".time()."');", true);

	if(!is_numeric($sendEmail)) die("Email Not Sent, but Booth and User have been Approved"); 

	die("-");
}
######################################################################################################
if(isset($_POST['boothDelete'])){
	$getUser = mysqlSelect("SELECT *, concat(lum_fname, ' ', lum_lname) as lum_name ,ifnull(vst_name, '-') as vst_name_filtered FROM `virtual_booths` 
	left join sm_logins on vb_lum_id = lum_id
	left join virtual_booth_types on vb_vbt_id = vbt_id
	left join virtual_booth_types_subtypes on vb_vst_id = vst_id
	left join sm_gender on lum_gender = gn_id
	where lum_type =3 and  (lum_valid = 0 or lum_valid = 1) and lum_email_ver = 1 and 
	vb_valid = 0 and md5(concat('njrdifnweenerwnijodn4ei**',vb_id)) = '".$_POST['boothDelete']."' ");
	
	if(!is_array($getUser)) die("Booth Not Found");

	$updtStatus = mysqlUpdateData("update sm_logins set lum_valid = 2 where lum_id = ".$getUser[0]['lum_id'],true);
	if(!is_numeric($updtStatus)) die("Booth Owner Not Deleted. Contact Admin ERRB1"); 

	$updtStatus2 = mysqlUpdateData("update virtual_booths set vb_valid = 2 where vb_id = ".$getUser[0]['vb_id'],true);
	if(!is_numeric($updtStatus2)) die("Booth Not Deleted. Contact Admin ERRB2"); 


	$sendEmail = mysqlInsertData("
INSERT INTO `m_email`(`e_to_name`, `e_to_email`, `e_subject`, `e_body_t_id`, `e_body_json`, `e_alt_body`, `e_dnt_posted`) VALUES (
'".$getUser[0]['lum_name']."',
'".$getUser[0]['lum_email']."',
'Booth Not Approved by Frestive - ".$getUser[0]['vb_name']."',
9,
'User and Booth Deleted',
'User and Booth Deleted',
'".time()."');", true);

	if(!is_numeric($sendEmail)) die("Email Not Sent, but Booth and User have been Deleted"); 

	die("-");
}
#
if(isset($_GET['ViewUserPage'])){
	if(!ctype_alnum($_GET['ViewUserPage'])){
		die("User Not Found");
	}
	$getUsers = mysqlSelect("select * from sm_logins 
	left join sm_user_groups on lum_type = type_id
	left join sm_gender on lum_gender = gn_id
	where lum_type not in  (1) 
	and md5(sha1(concat('/#@*ABCDEF',lum_id))) = '".$_GET['ViewUserPage']."'");
	
if(!is_array($getUsers)){
	die("User Doesnt Exist ");
}
$getUsers = $getUsers[0];
	?>
    <style>
		.c_s{
			background-color:rgba(146,248,170,0.76);
			border-radius:10px;
			padding:10px;	
			color:rgba(5,171,65,1.00);
			display:none;
		}
		.c_e{
			background-color:rgba(255,144,145,0.53);
			color:rgba(188,0,3,1.00);
			border-radius:10px;
			padding:10px;
			display:none;	
		}
	</style>
    <div class="c_s">
    	
    </div>
    <div class="c_e">

    </div>
    <br>
    	<div class="form-group">
            <label>Email</label>
        	<input class="form-control form-control-sm" value="<?php echo $getUsers['lum_email'] ?>" disabled />
        </div>
        
    	<div class="form-group">
            <label>First Name</label>
        	<input class="form-control form-control-sm" value="<?php echo $getUsers['lum_fname'] ?>" />
        </div>
        
    	<div class="form-group">
            <label>Last Name</label>
        	<input  class="form-control form-control-sm" value="<?php echo $getUsers['lum_lname'] ?>" />
        </div>
        
    	<div class="form-group">
            <label>Img</label>
        	<input  class="form-control form-control-sm" value="<?php echo $getUsers['lum_img_src'] ?>" />
        </div>
        
    	<div class="form-group">
            <label>Age</label>
        	<input class="form-control form-control-sm" value="<?php echo $getUsers['lum_age'] ?>" />
        </div>

    	<div class="form-group">
            <label>Interests</label>
        	<input  class="form-control form-control-sm" value="<?php echo $getUsers['lum_interests'] ?>" />
        </div>
        
    	<div class="form-group">
            <label>Gender</label>
            <select class="form-control" >
            <?php
			$getGenders = mysqlSelect("SELECT * FROM sm_gender");
				if(is_array($getGenders)){
					foreach($getGenders as $gg){
						$ss = '';
						if($gg['gn_id'] == $getUsers['lum_gender']){
							$ss = 'selected';
						}
						echo '<option  '.$ss.' value="'.$gg['gn_id'].'">'.$gg['gn_name'].'</option>';
					}
				}else{
					echo '<option value="0">None Found</option>';
				}
			?>
           		
            </select>
        </div>

    	<div class="form-group">
            <label>Type</label>
            <select class="form-control" >
            <?php
			$getTypes = mysqlSelect("SELECT * FROM sm_user_groups");
				if(is_array($getTypes)){
					foreach($getTypes as $gg){
						$ss = '';
						if($gg['type_id'] == $getUsers['lum_type']){
							$ss = 'selected';
						}
						echo '<option  '.$ss.' value="'.$gg['type_id'].'">'.$gg['type_name'].'</option>';
					}
				}else{
					echo '<option value="0">None Found</option>';
				}
			?>
           		
            </select>
        </div>
        
    <?php	
	
}
#
if(isset($_GET['ViewBoothData'])){
	if(!ctype_alnum($_GET['ViewBoothData'])){
		die("User Not Found");
	}
	$getUsers = mysqlSelect("SELECT *,ifnull(vst_name, '-') as vst_name_filtered FROM `virtual_booths` 
		left join sm_logins on vb_lum_id = lum_id
		left join virtual_booth_types on vb_vbt_id = vbt_id
		left join virtual_booth_types_subtypes on vb_vst_id = vst_id
		left join sm_gender on lum_gender = gn_id
		left join sm_status on vb_valid = ss_id
		where lum_type =3 and  lum_valid in (1,4) and lum_email_ver = 1
		and vb_valid in (1,4)
	and md5(sha1(concat('/#@*ABwjqieusCDEF',lum_id))) = '".$_GET['ViewBoothData']."'");
	
if(!is_array($getUsers)){
	die("Booth Doesnt Exist ");
}
$getUsers = $getUsers[0];

?>
<style>
.scrollable-content {
   overflow-y: scroll !important;
   height: 450px !important;}
</style>

<div class="row ">
	<h3 class="mb-3">Booth Information</h3>
    <div class="col-12 scrollable-content ">
        <table class="table table-hover table-striped">
            <tbody>
                <tr>
                    <td>Booth Name:</td>
                    <td><?php echo $getUsers['vb_name']; ?></td>
                </tr>
                <tr>
                    <td>Image:</td>
                    <td><img src="<?php echo $getUsers['vb_img_src']; ?>" class="img-responsive" style="max-width:100px" /></td>
                </tr>
                <tr>
                    <td>Booth Owner:</td>
                    <td><?php echo $getUsers['lum_fname']." ".$getUsers['lum_lname']; ?></td>
                </tr>
                <tr>
                    <td>Booth Owner Email:</td>
                    <td><?php echo $getUsers['lum_email']; ?></td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td><?php echo ($getUsers['vbt_name']." : ".$getUsers['vst_name_filtered']); ?></td>
                </tr>
                <tr>
                    <td>Tags:</td>
                    <td><?php echo $getUsers['vb_tags']; ?></td>
                </tr>
                <tr>
                    <td>Tagline:</td>
                    <td><?php echo $getUsers['vb_tagline']; ?></td>
                </tr>
                <tr>
                    <td>Plan 1:</td>
                    <td><?php echo $getUsers['vb_plan_1']; ?></td>
                </tr>
                <tr>
                    <td>Plan 2:</td>
                    <td><?php echo $getUsers['vb_plan_2']; ?></td>
                </tr>
                <tr>
                    <td>Plan 3:</td>
                    <td><?php echo $getUsers['vb_plan_3']; ?></td>
                </tr>
                <tr>
                    <td>Plan 4:</td>
                    <td><?php echo $getUsers['vb_plan_4']; ?></td>
                </tr>
                <tr>
                    <td>Facebook:</td>
                    <td><?php echo $getUsers['vb_facebook']; ?></td>
                </tr>
                <tr>
                    <td>Instagram:</td>
                    <td><?php echo $getUsers['vb_instagram']; ?></td>
                </tr>
    
                <tr>
                    <td>Twitter:</td>
                    <td><?php echo $getUsers['vb_twitter']; ?></td>
                </tr>
                <tr>
                    <td>Website:</td>
                    <td><?php echo $getUsers['vb_url']; ?></td>
                </tr>
                <tr>
                    <td>Youtube:</td>
                    <td><?php echo $getUsers['vb_youtube_live']; ?></td>
                </tr>
                <tr>
                    <td>Zoom:</td>
                    <td><?php echo $getUsers['vb_zoom_link']; ?></td>
                </tr>
                <tr>
                    <td>Status:</td>
                    <td><?php echo $getUsers['ss_name']; ?></td>
                </tr>
    
            </tbody>
        </table>
    </div>
</div>


<div class="row">
<h3 class="mb-3 mt-3">Mailing List </h3>
    <div class="col-12 scrollable-content ">
<table class="datatable table table-bordered table-hover">
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
	where bml_vb_id = ".$getUsers['vb_id']." 
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


<div class="row">
<h3 class="mb-3 mt-3">Signup List </h3>
    <div class="col-12 scrollable-content ">
<table class="datatable table table-bordered table-hover">
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
	where vbsup_vb_id = ".$getUsers['vb_id']." 
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



<?php

$getRooms = mysqlSelect("select * from virtual_rooms
		left join sm_status on vr_active= ss_id
		 where vr_vb_id =".$getUsers['vb_id']);
		 
		 if(is_array($getRooms)){
			 ?>

             <?php
			 foreach($getRooms as $room){
				 ?>
<div style="border-top:3px sold black" class="row">
<h3 class="mb-3 mt-3">Room - <?php echo $room['vr_title']; ?></h3>
    <table class="table table-hover table-striped">
        <tbody>
            <tr>
                <td>Room Name:</td>
                <td><?php echo $room['vr_title']; ?></td>
            </tr>
            <tr>
                <td>Room Tagline:</td>
                <td><?php echo $room['vr_tagline']; ?></td>
            </tr>
            <tr>
                <td>Room Description:</td>
                <td><?php echo $room['vr_desc2']; ?></td>
            </tr>
            

        </tbody>
    </table>
    <h6 style="margin-left:20px;" align="center">Chats:</h6>
    <div class="col-12 scrollable-content ">
    <table class="table table-bordered table-hover table-striped">
    <thead>
    	<tr>
        	<th>User</th>
            <th>Text</th>
            <th>Status</th>
            <th>Time</th>
        </tr>
    </thead>
        <tbody>
            <?php
			
			$getChats = mysqlSelect("select * from c_chat_rooms c
left join sm_logins l on c.ccr_lum_id = l.lum_id
left join sm_status on ccr_approved = ss_id
where c.ccr_vr_id = ".$room['vr_id']."
order by ccr_dnt, ccr_id asc");
if(is_array($getChats)){
	foreach($getChats as $chat){
		?>
        <tr>
                <td><?php echo $chat['lum_fname']." ".$chat['lum_lname']; ?></td>
                <td><?php echo $chat['ccr_text']; ?></td>
                <td><?php echo $chat['ss_name']; ?></td>
                <td><?php echo date("d-M-Y @ H:i:s A", $chat['ccr_dnt']); ?></td>
            </tr>

        <?php
	}
}
			?>
        </tbody>
    </table>	</div>
</div>

                 <?php
			 }
			 ?>
             <?php
		 }
	
}

?>