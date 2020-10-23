<?php
require_once("SessionHandler.php");
require_once("Settings.php");
require_once("DatabaseConnection.php");
require_once("FunctionsController.php");


#Page load Issets
if(isset($_POST['load_data_user'])){
	$getUsers = mysqlSelect("select * from sm_logins 
	left join sm_user_groups on lum_type = type_id
	left join sm_gender on lum_gender = gn_id
	where lum_type not in  (1) order by lum_id desc");
	
if(!is_array($getUsers)){
	die("No Users Found ");
}

?>
    <table class="table table-striped table-bordered "  id="btnUsersTableInnerBody">
	<thead>
    	<tr>
        	<th >ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Type</th>
            <th>Image</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Interests</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>

<?php
	foreach($getUsers as $user){
	?>
    	<tr>
        	<th><?php echo $user['lum_id'] ?></th>
        	<th><?php echo $user['lum_fname']." - ".$user['lum_lname'] ?></th>
        	<th><?php echo $user['lum_email'] ?></th>
        	<th><?php echo $user['type_name'] ?></th>
        	<th><a target="_blank" href="<?php echo $user['lum_img_src'] ?>"><?php echo $user['lum_img_src'] ?></a></th>
        	<th><?php echo $user['lum_age'] ?></th>
        	<th><?php echo $user['gn_name'] ?></th>
        	<th><?php echo $user['lum_interests'] ?></th>
        	<th><?php echo $user['lum_dnt'] ?></th>
            <th>
            <form id="f<?php echo $user['lum_id'] ?>" action="server_fundamentals/AdminController" method="post">
            	<input type="hidden" name="user_toggle" value="<?php echo md5("IWOJNF2838.IO".$user['lum_id']) ?>" />
            	<?php
				if($user['lum_valid'] == 1){
					echo '<button type="submit" class="mt-2 btn btn-danger">Disable</button><br>';
				}else{
					echo '<button type="submit" class="mt-2 btn btn-success">Approve</button><br>';
				}
				 ?>
                 </form>
<a href="javascript:void(0);" data-href="server_fundamentals/AdminController.php?getUserPasswordPage=<?php echo md5(sha1("/@#*ABCDEF".$user['lum_id'])) ?>" class="openPopup mt-2 btn btn-info">Password</a><br>
<a href="javascript:void(0);" data-href="server_fundamentals/AdminController.php?getUserEditPage=<?php echo md5(sha1("/#@*ABCDEF".$user['lum_id'])) ?>" class="openPopup mt-2 btn btn-warning">Edit User</a><br>			
    <script>
	$(document).ready(function (e) {
    $('#f<?php echo $user['lum_id'] ?>').on('submit',(function(e) {
		me = $(this);
		var ebox = $("#f<?php echo $user['lum_id'] ?>");
		e.preventDefault();
			var formData = new FormData(this);
			$.ajax({
					type:'POST',
					url: $(this).attr('action'),
					data:formData,
					cache:false,
					contentType: false,
					processData: false,//Start
					success:function(data){
							ebox.html(data);
											},//END
					error: function(data){
							ebox.html("Error Acessing the Folder. Contact Admin");
					}
				});
		    }));
		});
	</script>

            </th>
        </tr>
    <?php
	}
?>

</tbody>
    </table>


<?php

}



##Modal Issets
if(isset($_GET['getUserEditPage'])){
	if(!ctype_alnum($_GET['getUserEditPage'])){
		die("User Not Found");
	}
	$getUsers = mysqlSelect("select * from sm_logins 
	left join sm_user_groups on lum_type = type_id
	left join sm_gender on lum_gender = gn_id
	where lum_type not in  (1) 
	and md5(sha1(concat('/#@*ABCDEF',lum_id))) = '".$_GET['getUserEditPage']."'");
	
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
    <form action="server_fundamentals/AdminController" method="post" id="formID">
    <input type="hidden" name="UpdateUserData" value="<?php echo md5(md5(sha1("ANO8TH284TH984H98".$getUsers['lum_id']))) ?>"  />
    	<div class="form-group">
            <label>Email</label>
        	<input class="form-control form-control-sm" value="<?php echo $getUsers['lum_email'] ?>" disabled />
        </div>
        
    	<div class="form-group">
            <label>First Name</label>
        	<input name="user_change_first" class="form-control form-control-sm" value="<?php echo $getUsers['lum_fname'] ?>" />
        </div>
        
    	<div class="form-group">
            <label>Last Name</label>
        	<input name="user_change_last" class="form-control form-control-sm" value="<?php echo $getUsers['lum_lname'] ?>" />
        </div>
        
    	<div class="form-group">
            <label>Img</label>
        	<input name="user_change_img" class="form-control form-control-sm" value="<?php echo $getUsers['lum_img_src'] ?>" />
        </div>
        
    	<div class="form-group">
            <label>Age</label>
        	<input name="user_change_age" class="form-control form-control-sm" value="<?php echo $getUsers['lum_age'] ?>" />
        </div>

    	<div class="form-group">
            <label>Interests</label>
        	<input name="user_change_int" class="form-control form-control-sm" value="<?php echo $getUsers['lum_interests'] ?>" />
        </div>
        
    	<div class="form-group">
            <label>Gender</label>
            <select class="form-control" name="user_change_gender">
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
            <select class="form-control" name="user_change_type">
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
        
        <div class="form-group">
                    <button class="btn btn-primary mr-1" type="submit">Submit</button>
                    <button class="btn btn-secondary" type="reset">Reset</button>
        </div>
        
    </form>
    <script>
	$(document).ready(function (e) {
    $('#formID').on('submit',(function(e) {
		me = $(this);
		var ebox = $(".c_e");
		var sbox = $(".c_s");
		ebox.fadeOut();
		sbox.fadeOut();
		e.preventDefault();
			var formData = new FormData(this);
			$.ajax({
					type:'POST',
					url: $(this).attr('action'),
					data:formData,
					cache:false,
					contentType: false,
					processData: false,//Start
					success:function(data){
						if(data == ""){
							sbox.html("The user was updated successfully.");
							sbox.fadeIn();
						}else{
							ebox.html(data);
							ebox.fadeIn();
						}
											},//END
					error: function(data){
							ebox.html("Error Acessing the Folder. Contact Admin");
							ebox.fadeIn();
					}
				});
		    }));
		});
	</script>
    <?php	
	
}
#
if(isset($_GET['getUserPasswordPage'])){
	if(!ctype_alnum($_GET['getUserPasswordPage'])){
		die("User Not Found");
	}
	$getUsers = mysqlSelect("select * from sm_logins 
	left join sm_user_groups on lum_type = type_id
	left join sm_gender on lum_gender = gn_id
	where lum_type not in  (1) 
	and md5(sha1(concat('/@#*ABCDEF',lum_id))) = '".$_GET['getUserPasswordPage']."'");
	
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
    <form action="server_fundamentals/AdminController" method="post" id="formID">
    <input type="hidden" name="UpdateUserPw" value="<?php echo md5(md5(sha1("IAUFEH284TH984H98".$getUsers['lum_id']))) ?>"  />
    	<div class="form-group">
            <label>Enter New Password</label>
        	<input required name="user_change_pw" class="form-control form-control-sm" type="text"/>
        </div>
        
        <div class="form-group">
                    <button class="btn btn-primary mr-1" type="submit">Submit</button>
                    <button class="btn btn-secondary" type="reset">Reset</button>
        </div>
        
    </form>
    <script>
	$(document).ready(function (e) {
    $('#formID').on('submit',(function(e) {
		me = $(this);
		var ebox = $(".c_e");
		var sbox = $(".c_s");
		ebox.fadeOut();
		sbox.fadeOut();
		e.preventDefault();
			var formData = new FormData(this);
			$.ajax({
					type:'POST',
					url: $(this).attr('action'),
					data:formData,
					cache:false,
					contentType: false,
					processData: false,//Start
					success:function(data){
						if(data == ""){
							sbox.html("The user was updated successfully.");
							sbox.fadeIn();
						}else{
							ebox.html(data);
							ebox.fadeIn();
						}
											},//END
					error: function(data){
							ebox.html("Error Acessing the Folder. Contact Admin");
							ebox.fadeIn();
					}
				});
		    }));
		});
	</script>
    <?php	
	
}


//Updates Backend
if(isset($_POST['UpdateUserData'])){
	
	
	$checkerNames = array("user_change_first","user_change_last","UpdateUserData","user_change_img","user_change_type","user_change_age","user_change_gender","user_change_int");
# 0 = email
# 1 = password
checkPost($checkerNames);
$err= "";

$getUser = mysqlSelect("select * from sm_logins 
	left join sm_user_groups on lum_type = type_id
	left join sm_gender on lum_gender = gn_id
	where lum_type not in  (1) 
	and md5(md5(sha1(concat('ANO8TH284TH984H98',lum_id)))) = '".$_POST[$checkerNames[2]]."'
	order by lum_id desc");
if(!is_array($getUser)){
	$err .= "<br>User Not Found";
}

$getTypes = mysqlSelect("SELECT * FROM sm_user_groups where type_id = ".$_POST[$checkerNames[4]]);
if(!is_array($getTypes)){
	$err .= "<br>User Type Invalid";
}

if(!inRange($_POST[$checkerNames[5]], 10,200,true)){
	$err .= "<br>Age Invalid";
}

if(!inRange($_POST[$checkerNames[6]], 1,3,true)){
	$err .= "<br>Gender Invalid";
}
if(!empty($err)){
	die($err);
}


$updateSql = "UPDATE `sm_logins` SET 
`lum_fname`= '".$_POST[$checkerNames[0]]."',
`lum_lname`= '".$_POST[$checkerNames[1]]."',
`lum_img_src`= '".$_POST[$checkerNames[3]]."',
`lum_type`= '".$_POST[$checkerNames[4]]."',
`lum_age`= '".$_POST[$checkerNames[5]]."',
`lum_gender`= '".$_POST[$checkerNames[6]]."',
`lum_interests`='".$_POST[$checkerNames[7]]."'
 WHERE lum_id = ".$getUser[0]['lum_id'];
$updateData = mysqlUpdateData($updateSql,true);
if(!is_numeric($updateData)){
	die('Could Not Update User data. 503 Server Error');
}








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
		$updateSql = "UPDATE `sm_logins` SET `lum_valid` = 0 where lum_id = ".$getUser[0]['lum_id']."";
		$retdata .= '<button type="submit" class="mt-2 btn btn-success">Approve</button><br>';
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
if(isset($_POST['UpdateUserPw'])){
	if(!ctype_alnum($_POST['UpdateUserPw'])){
		die("Invalid User");
	}
	$checkerNames = array("user_change_pw");

checkPost($checkerNames);

$getUser = mysqlSelect("select * from sm_logins 
	where lum_type not in  (1) 
	and md5(md5(sha1(concat('IAUFEH284TH984H98',lum_id)))) = '".$_POST['UpdateUserPw']."'");
if(!is_array($getUser)){
	die( "<br>User Not Found");
}

if($_POST[$checkerNames[0]] == ""){
	die("Password Must not be blank");
}


$h = genHash($getUser[0]['lum_email'],$_POST[$checkerNames[0]]);
$updateSql = "update sm_logins set lum_hash = '".$h."' 
where lum_id = ".$getUser[0]['lum_id'];
$updateData = mysqlUpdateData($updateSql,true);
if(!is_numeric($updateData)){
	die('Could Not Update User data. 503 Server Error');
}

	
}
?>
