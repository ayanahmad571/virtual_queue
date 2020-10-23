<?php
require_once("Settings.php");
$getOutlets = mysqlSelect("SELECT *, 
(SELECT count(*) FROM `virtual_services` where service_branch_id  = b.branch_id and service_status = 1) as servs 
FROM `virtual_branch` b where b.branch_status = 1 and md5(branch_id) = '".$_GET['id']."'");
#(SELECT count(*) FROM `virtual_queue_container` where queue_state in (2,3) and queue_service_id = 1) as qist
if(!is_array($getOutlets)){
	header('Location: shops');
	die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?php echo $getOutlets[0]['branch_name'] ?></title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/shop-homepage.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">Qista</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="shops">Home
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

        <h1 class="my-4">Services at <?php echo $getOutlets[0]['branch_name'] ?></h1>
        <div class="list-group">
          <a href="#" class="list-group-item">Category 1</a>
          <a href="#" class="list-group-item">Category 2</a>
          <a href="#" class="list-group-item">Category 3</a>
        </div>

      </div>
      <!-- /.col-lg-3 -->

      <div class="col-lg-9">


<br><br><br><br><br><br>
        <div class="row">
<?php
$getOutlets = mysqlSelect("SELECT *, 
(SELECT count(*) FROM `virtual_queue_container` where queue_state in (2,3) and queue_service_id = s.service_id) as qist 
FROM `virtual_services` s where s.service_status= 1
and service_branch_id = ".$getOutlets[0]['branch_id']);
#

if(is_array($getOutlets)){
	foreach($getOutlets as $Outlet){
	?>
    	<div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
              <div class="card-body">
                <h4 class="card-title">
                  <a href="q_service?id=<?php echo md5($Outlet['service_id']); ?>"><?php echo $Outlet['service_name']; ?></a>
                </h4>
                <h5><?php echo $Outlet['qist']; ?> People Currently Queued</h5>
                <p class="card-text"><?php echo $Outlet['service_desc']; ?></p>
              </div>
              <div class="card-footer">
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
              </div>
            </div>
          </div>
    <?php
	}
}

?>


        </div>
        <!-- /.row -->

      </div>
      <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->
    <br><br><br><br><br><br><br><br><br><br>      

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

</body>

</html>
