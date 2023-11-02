<?php 

require_once "functions/sessions.php";
require_once "functions/date.php";
require_once "functions/security.php";
require_once "functions/routing.php";

if(!isset($_SESSION['VWAIadmin'])){
	header("Location:login");
	exit;
}

require_once "classes/allClasses.php";

$token = md5(uniqid(mt_rand(), true));
setSession("token",$token);

$admin = new \votewhoami\admin\admin();
$admin = $admin->getRow("SELECT * from admin WHERE id = 1");

$viewers = new \votewhoami\admin\visitors();
$allVisitors = $viewers->getRows("SELECT * FROM visitors");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin | Vote Who Am I</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css">
	<script src="https://kit.fontawesome.com/9907df2918.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<style type="text/css">
		h3{
			text-align: center;
		}table tr td:last-child{
			text-align: center
		}
	</style>
</head>
<body>

	<div id="top-color"></div>
	<header class="container-fluid header">
		<i id="opCl" class="fas fa-list-ul"></i> &nbsp; &nbsp; &nbsp; &nbsp; <span id="page-name">DASHBOARD</span> 
		<div class="dropdown">
  			<span class="dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="img/<?=$admin->img?>"></span>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
			  	<a class="dropdown-item" href="process.php?statu=exit">Çıkış</a>
			</div>
		</div>
	</header> 
	<div class="container-fluid">
		<nav class="navbar navbar-expand d-flex flex-column align-item-start" id="sidebar">
		
		<ul class="navbar-nav d-flex flex-column mt-5 w-100">
			<a class="navbar-brand" href="#">Vote Who Am I</a>
			<hr>
			<li class="nav-item w-100">
				<a href="index.php" class="nav-link text-light pl-4"><i class="fas fa-chart-pie"></i>&nbsp; Home</a>
			</li>
			<li class="nav-item w-100">
				<a href="groups.php" class="nav-link text-light pl-4"><i class="fas fa-users"></i>&nbsp; Groups</a>
			</li>
			<li class="nav-item w-100">
				<a href="visitors.php" class="nav-link text-light pl-4"><i class="fas fa-info"></i>&nbsp; Visitors</a>
			</li>
			<li class="nav-item w-100">
				<a href="contact.php" class="nav-link text-light pl-4"><i class="far fa-paper-plane"></i>&nbsp; Contact</a>
			</li>
			<li class="nav-item dropdown w-100">
				<a href="settings.php" class="nav-link text-light pl-4" ><i class="fas fa-cogs"></i>&nbsp; Settings</a>
			</li>
		</ul>

	</nav>
	<!-- DARK MODE START -->
	<div class="color-setting">
		<i class="fas fa-cog"></i>
	</div>
	<div class="color-setting-area">
		<h6>SIDEBAR BACKGROUND</h6>
		<div class="sidebar-item" id="sidebar-blue" onclick="sidebarColor('blue')"></div>
		<div class="sidebar-item" id="sidebar-purple" onclick="sidebarColor('purple')"></div>
		<div class="sidebar-item" id="sidebar-orange" onclick="sidebarColor('orange')"></div>
		<div class="form-check form-switch" >
  			<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked> &nbsp;
  			<label class="form-check-label" for="flexSwitchCheckChecked">Dark Mode</label>
		</div>
	</div>
	<!-- DARK MODE END -->
	<main class="p-4 my-container" >
		<div class="row gx-1">
			<div class="col-md-12">
				<div class="col-md-12">
					<table id="example" class="table table-striped table-dark table-bordered dt-responsive nowrap" style="width:100%; ">
						<thead>
					        <tr>
					            <th>İp</th>
					            <th>Platform</th>
					            <th>Agent</th>
					            <th>Language</th>
					            <th>Click</th>
					            <th>Date</th>
					            <th>View</th>
					        </tr>
					    </thead>
					    <tbody>
					    	<?php foreach ($allVisitors as $key) { $id = $key->id; ?>
					       <tr>
					           <td><?=$key->visitorsIp?></td>
					           <td><?=$key->visitorsPlatform?></td>
					           <td><?=$key->visitorsAgent?></td>
					           <td><?=$key->visitorsLanguage?></td>
					           <td><?=$key->visitorsClick?></td>
					           <td><?=$key->visitorsDate?></td>
					           <td>
					           		<a href="visitor.php?id=<?=$id?>" class="btn btn-primary">Görüntüle</a>
					           </td>
					       </tr>
					   		<?php } ?>
					    </tbody>
					</table> <br> <hr> <br>
				</div>
			</div>
		</div>
	</main>

	

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
  	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script type="text/javascript" src="js/functions.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<!-- DATATABLE START -->
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
    $('#example').DataTable();
    } );
	</script>
    <!-- DATATABLE END -->
    <?php if(isset($_GET['statu']) and isset($_GET['type']) and ($_GET['statu'] == 1) and ($_GET['type'] == "warning")){ ?>
		<script type="text/javascript">
			toastr["warning"]("Bir sorun oluştu! Lütfen tekrar deneyin."); 
		</script>
	<?php }elseif(isset($_GET['statu']) and isset($_GET['type']) and $_GET['statu'] == 1 and ($_GET['type'] == "success")){  ?>
    <script type="text/javascript">
      toastr["success"]("İşlem başarıyla gerçekleşti."); 
    </script>
  	<?php } ?>
	
</body>
</html>