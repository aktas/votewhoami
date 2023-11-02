<?php 
require_once "functions/sessions.php";
require_once "functions/security.php";
require_once "functions/routing.php";
require_once "classes/allClasses.php";

if(!isset($_SESSION['VWAIadmin'])){
	header("Location:login");
	exit;
}

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

	<script src="https://kit.fontawesome.com/9907df2918.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>

	<div id="top-color"></div>
	<header class="container-fluid header">
		<i id="opCl" class="fas fa-list-ul"></i> &nbsp; &nbsp; &nbsp; &nbsp; <span id="page-name">DASHBOARD</span> 
		<div class="dropdown">
  			<span class="dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="img/profile.jpg"></span>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
			  	<a class="dropdown-item" href="#">Çıkış</a>
			</div>
		</div>	
		<div class="dropdown">
  			<span class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bolt"></i><span>0</span></span>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
			  	<a class="dropdown-item" href="#">Action</a>
			    <a class="dropdown-item" href="#">Another action</a>
			    <a class="dropdown-item" href="#">Something else here</a>
			</div>
		</div>	
		
	</header> 
	<div class="container-fluid">
		<nav class="navbar navbar-expand d-flex flex-column align-item-start" id="sidebar">
		
		<ul class="navbar-nav d-flex flex-column mt-5 w-100">
			<a class="navbar-brand" href="#">Control Mechansim</a>
			<hr>
			<li class="nav-item w-100">
				<a href="#" class="nav-link text-light pl-4"><i class="fas fa-chart-pie"></i>&nbsp; Home</a>
			</li>
			<li class="nav-item w-100">
				<a href="#" class="nav-link text-light pl-4"><i class="fas fa-users"></i>&nbsp; Users</a>
			</li>
			<li class="nav-item w-100">
				<a href="#" class="nav-link text-light pl-4"><i class="fas fa-pen-alt"></i>&nbsp; Articles</a>
			</li>
			<li class="nav-item w-100">
				<a href="#" class="nav-link text-light pl-4"><i class="far fa-chart-bar"></i>&nbsp; Grapichs</a>
			</li>
			<li class="nav-item w-100">
				<a href="#" class="nav-link text-light pl-4"><i class="far fa-clock"></i>&nbsp; Calendar</a>
			</li>
			<li class="nav-item w-100">
				<a href="#" class="nav-link text-light pl-4"><i class="far fa-paper-plane"></i>&nbsp; Contact</a>
			</li>
			<li class="nav-item dropdown w-100">
				<a href="javascript:void(0)" class="nav-link dropdown-toggle text-light pl-4" onclick="dropdown('menuDropdown')" ><i class="fas fa-cogs"></i>&nbsp; Settings</a>
				<ul style="display: none" id="menuDropdown" aria-labelledby="navbarDropdown">
					<li><a href="#" class="dropdown-item text-light pl-4 p-2">Service 01</a></li>
					<li><a href="#" class="dropdown-item text-light pl-4 p-2">Service 01</a></li>
					<li><a href="#" class="dropdown-item text-light pl-4 p-2">Service 01</a></li>
					<li><a href="#" class="dropdown-item text-light pl-4 p-2">Service 01</a></li>
				</ul>
			</li>
			<li class="nav-item w-100">
				<span>Disk</span>
				<div class="progress">
  					<div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
				</div>
			</li>

			<li class="nav-item w-100">
				<span>Traffic</span>
				<div class="progress">
  					<div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
				</div>
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
		<main class="p-4 my-container">
			<div class="row gx-1">
				<div class="col-md-12">
					<div class="col-md-12"> Sen kendini ne sanıyorsun? Pisliğin önde gidenisin dostum.
						<input type="text" class="form-control" placeholder="Email Adress" name="">
						<textarea class="form-control" placeholder="aaaa"></textarea>
						
						<p><input class="form-check-input" type="checkbox"> Yeniden Başlatmayı Unutma </p>
						<p>
							<label class="radio">
								<input type="radio" name="gender" value="male" >
								male
								<span></span>
							</label>
							<label class="radio">
								<input type="radio" name="gender" value="male" >
								girl
								<span></span>
							</label>
						</p>
						<select id="inputState" class="form-control">
					       <option selected>Choose...</option>
					       <option>...</option>
					    </select>
					    <form class="form">
					    	<div class="file-upload-wrapper" data-text="Select your file!">
					    		<input type="file" name="file-upload-field" class="file-upload-field" value="">
					    	</div>
					    </form>			    
					    
					</div>
				</div>
			</div>
		</main>
	</div>


	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script type="text/javascript" src="js/functions.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	
</body>
</html>