<?php
require_once("Settings.php");
$getService = mysqlSelect("SELECT * ,
(SELECT count(*) FROM `virtual_queue_container` where queue_state in (2,3) and queue_service_id = s.service_id) as qist 
FROM `virtual_services` s 
left join virtual_branch on service_branch_id = branch_id 
where s.service_status= 1 and md5(s.service_id) ='".$_GET['id']."'");

if(!is_array($getService)){
	#header('Location: shops');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?php echo $getService[0]['service_name'] ?></title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/shop-item.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">Start Bootstrap</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="shop">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <div class="col-lg-3">
        <h1 class="my-4"><?php echo $getService[0]['branch_name'] ?></h1>
        <div class="list-group">
          <a href="#" class="list-group-item active">Category 1</a>
          <a href="#" class="list-group-item">Category 2</a>
          <a href="#" class="list-group-item">Category 3</a>
        </div>
      </div>
      <!-- /.col-lg-3 -->

      <div class="col-lg-9">

        <div class="card mt-4">
          <img class="card-img-top img-fluid" src="../<?php echo $getService[0]['branch_logo'] ?>" alt="">
          <div class="card-body">
            <h3 class="card-title"><?php echo $getService[0]['service_name'] ?></h3>
            <h4><?php echo $getService[0]['qist'] ?> people in Queue.</h4>
            <p class="card-text"><?php echo $getService[0]['service_desc'] ?></p>
            <span class="text-warning">&#9733; &#9733; &#9733; &#9733; &#9734;</span>
            4.0 stars
          </div>
        </div>
        <!-- /.card -->
        <?php
						$checkQueue = "";

		if(isset($_SESSION['QISTA_SESSION_ID'])){
			if(is_numeric($_SESSION['QISTA_SESSION_ID'])){
				$checkQueue = mysqlSelect("SELECT * FROM `virtual_queue_container` where queue_lum_id = ".$_SESSION['QISTA_SESSION_ID']." 
				and queue_service_id = ".$getService[0]["service_id"]." and queue_state in (2,3,4)");
			}
		}
			
if(is_array($checkQueue)){
	?>
        <div class="card card-outline-secondary my-4">
          <div class="card-header">
            <?php 
			#$getNumberInqueue = mysqlSelect("select * from ");
			?>Already in QUEUe 
          </div>
        </div>

    <?php
}else{

		?>
		<form action="MasterController.php" method="post">
        <div class="card card-outline-secondary my-4">
          <div class="card-header">
            Join Queue
          </div>
          <div class="card-body">
          <input type="hidden" name="serv_id" value="<?php echo $getService[0]["service_id"] ?>" />
            <p>Country Code: <input name="mob_code" type="number" class="form-control" placeholder="44"  /></p>
            <p>Mobile Number: <input name="mob_number" type="number" class="form-control" placeholder="7333333333"  /></p>
            <p>Party Size : <input name="size" type="number" class="form-control" placeholder="2"  /></p>
            <p>First Name: <input name="u_fname" type="text" class="form-control" placeholder="John"  /></p>
            <p>Last Name: <input name="u_lname" type="text" class="form-control" placeholder="Doe"  /></p>
            <button type="submit" class="btn btn-success">Join Queue</button>
          </div>
        </div>
        </form>
        <?php
}
		?>
        <!-- /.card -->

      </div>
      <!-- /.col-lg-9 -->

    </div>

  </div>
  <!-- /.container -->
<br><br><br><br>
  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; Your Website 2020</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function (e) {
	$("#loginFail").hide();

    $('#loginForm').on('submit',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
				if(data.trim() == "-"){
					$("#loginFail").fadeIn();
					
				}else{
					window.location = data;
				}
            },
            error: function(data){
                alert("Contact Admin.");
            }
        });
    }));

});
    </script> 

</body>

</html>
