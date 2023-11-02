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

$visitors = new \votewhoami\graphics\visitors();
$allVisitors = $visitors->getAllVisitors();
$visitors = $visitors->getVisitors();

$views = new \votewhoami\graphics\views();
$allViews = $views->getAllViews();
$views = $views->getViews();

$languages = new \votewhoami\graphics\languages();
$languages = $languages->getLanguages();

$platforms = new \votewhoami\graphics\platforms();
$platforms = $platforms->getPlatforms();

$messages = new \votewhoami\graphics\messages();
$allMessages = $messages->getAllMessages();

$groups = new \votewhoami\graphics\groups();
$allGroups = $groups->getAllGroups();
$groups = $groups->getGroups();

$months = getMonths();

$admin = new \votewhoami\admin\admin();
$admin = $admin->getRow("SELECT * from admin WHERE id = 1");

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> -->
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
					<h3>Total Page Views <span>(last 12 months)</span> </h3>
					<div><canvas id="myChart" style="min-height: 250px"></canvas></div>
				</div>
			</div>
			<div class="col-md-3 showNum">
				<div class="col-md-12">
					<span><i class="fas fa-eye"></i></span>
					<span>Views</span>
					<span><?=$allViews?></span>
				</div>
			</div>
			<div class="col-md-3 showNum">
				<div class="col-md-12">
					<span><i class="fas fa-users"></i></span>
					<span>Visitors</span>
					<span><?=$allVisitors?></span>
				</div>
			</div>
			<div class="col-md-3 showNum">
				<div class="col-md-12">
					<span><i class="far fa-comment"></i></span>
					<span>Massages</span>
					<span><?=$allMessages?></span>
				</div>
			</div>
			<div class="col-md-3 showNum">
				<div class="col-md-12">
					<span><i class="fas fa-project-diagram"></i></span>
					<span>Groups</span>
					<span><?=$allGroups?></span>
				</div>
			</div>
			<div class="col-md-4">
				<div class="col-md-12">
					<h3>Visitors Platforms </h3>
					<div><canvas id="myChart5" style="min-height: 250px"></canvas></div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="col-md-12">
					<h3>Total Groups <span>(last 6 months)</span></h3>
					<div><canvas id="myChart3" style="min-height: 250px"></canvas></div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="col-md-12">
					<h3>Visitors Languages </h3>
					<div><canvas id="myChart4" style="min-height: 250px"></canvas></div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="col-md-12">
					<h3>Total Visitors <span>(last 6 months)</span></h3>
					<div><canvas id="myChart2" style="min-height: 270px"></canvas></div>
				</div>
			</div>
			<!-- EMPLOYEES STATS START -->
			<div class="col-md-6">
				<div class="col-md-12" id="employees-stats">
					<h3>Employees Stats</h3>
					<div class="table-responsive">
						<table class="table">
  						<thead>
    						<tr>
      							<th scope="col">Name</th>
      							<th scope="col">City</th>
      							<th scope="col">Number Of Post</th>
      							<th scope="col">Statu</th>
    						</tr>
  						</thead>
  						<tbody>
    						<tr>
      							<td scope="row">Alper Aktaş</td>
      							<td>Trabzon</td>
      							<td>124</td>
      							<td>CEO</td>
    						</tr>
  						</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- EMPLOYEES STATS END -->
		</div>
		
	</main> 
	</div>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script type="text/javascript" src="js/functions.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript">

		var visitors1 = "<?php echo $visitors[0]; ?>";
		var visitors2 = "<?php echo $visitors[1]; ?>";
		var visitors3 = "<?php echo $visitors[2]; ?>";
		var visitors4 = "<?php echo $visitors[3]; ?>";
		var visitors5 = "<?php echo $visitors[4]; ?>";
		var visitors6 = "<?php echo $visitors[5]; ?>";

		var groups1 = "<?php echo $groups[0]; ?>";
		var groups2 = "<?php echo $groups[1]; ?>";
		var groups3 = "<?php echo $groups[2]; ?>";
		var groups4 = "<?php echo $groups[3]; ?>";
		var groups5 = "<?php echo $groups[4]; ?>";
		var groups6 = "<?php echo $groups[5]; ?>";

		var views1 = "<?php echo $views[0]; ?>";
		var views2 = "<?php echo $views[1]; ?>";
		var views3 = "<?php echo $views[2]; ?>";
		var views4 = "<?php echo $views[3]; ?>";
		var views5 = "<?php echo $views[4]; ?>";
		var views6 = "<?php echo $views[5]; ?>";
		var views7 = "<?php echo $views[6]; ?>";
		var views8 = "<?php echo $views[7]; ?>";
		var views9 = "<?php echo $views[8]; ?>";
		var views10 = "<?php echo $views[9]; ?>";
		var views11 = "<?php echo $views[10]; ?>";
		var views12 = "<?php echo $views[11]; ?>";

		var month1 = "<?php echo $months[0] ?>";
		var month2 = "<?php echo $months[1] ?>";
		var month3 = "<?php echo $months[2] ?>";
		var month4 = "<?php echo $months[3] ?>";
		var month5 = "<?php echo $months[4] ?>";
		var month6 = "<?php echo $months[5] ?>";
		var month7 = "<?php echo $months[6] ?>";
		var month8 = "<?php echo $months[7] ?>";
		var month9 = "<?php echo $months[8] ?>";
		var month10 = "<?php echo $months[9] ?>";
		var month11 = "<?php echo $months[10] ?>";
		var month12 = "<?php echo $months[11] ?>";

		var tr = "<?php echo $languages[0] ?>";
		var en = "<?php echo $languages[1] ?>";
		var other = "<?php echo $languages[2] ?>";

		var linux = "<?php echo $platforms[0]; ?>";
		var windows = "<?php echo $platforms[1]; ?>";
		var mac = "<?php echo $platforms[2]; ?>";
		var other = "<?php echo $platforms[3]; ?>";

		// GRAPHİCS STARTS
	    var ctx = document.getElementById('myChart').getContext('2d');
	    var chart = new Chart(ctx, {
	        // The type of chart we want to create
	        type: 'line',

	        // The data for our dataset
	        data: {
	            labels: [month12,month11,month10,month9,month8,month7,month6,month5,month4,month3,month2,month1],
	            datasets: [{
	                label: 'number of views',
	                borderColor: '#9f1eb4',
	                fill: false,
	                clip:0,
	                data: [views12,views11,views10,views9,views8,views7,views6,views5,views4,views3,views2,views1]
	            }]
	        },

	        // Configuration options go here
	        options: {
	            maintainAspectRatio: false,
	            legend: {
	                display: false
	            }
	        }
	    });

	    var ctx2 = document.getElementById('myChart2').getContext('2d');
	    var chart = new Chart(ctx2, {
	        // The type of chart we want to create
	        type: 'line',

	        // The data for our dataset
	        data: {
	            labels: [month6,month5,month4,month3,month2,month1],
	            datasets: [{
	                label: 'number of visitors',
	                borderColor: '#9f1eb4',
	                fill: false,
	                clip:0,
	                data: [visitors6, visitors5, visitors4, visitors3, visitors2, visitors1]
	            }]
	        },

	        // Configuration options go here
	        options: {
	            maintainAspectRatio: false,
	            legend: {
	                display: false
	            }
	        }
	    });

	    var ctx3 = document.getElementById('myChart3').getContext('2d');
	    var chart = new Chart(ctx3, {
	        // The type of chart we want to create
	        type: 'bar',

	        // The data for our dataset
	        data: {
	            labels: [month6,month5,month4,month3,month2,month1],
	            datasets: [{
	                label: 'number of views',
	                backgroundColor: '#9f1eb4',
	                fill: false,
	                clip:0,
	                data: [groups6, groups5, groups4, groups3, groups2, groups1]
	            }]
	        },

	        // Configuration options go here
	        options: {
	            maintainAspectRatio: false,
	            legend: {
	                display: false
	            }
	        }
	    });

	    var ctx4 = document.getElementById('myChart4').getContext('2d');
	    var chart = new Chart(ctx4, {
	        // The type of chart we want to create
	        type: 'polarArea',

	        // The data for our dataset
	        data: {
	            labels: ['English', 'Turkish', 'Other'],
	            datasets: [{
	                label: 'number of views',
	                backgroundColor: ['#0188ff','#fda105','#9f1eb4'],
	                fill: false,
	                clip:0,
	                data: [en, tr, other]
	            }]
	        },

	        // Configuration options go here
	        options: {
	            maintainAspectRatio: false,
	            legend: {
	                display: false
	            }
	        }
	    });

	    var ctx5 = document.getElementById('myChart5').getContext('2d');
	    var chart = new Chart(ctx5, {
	        // The type of chart we want to create
	        type: 'polarArea',

	        // The data for our dataset
	        data: {
	            labels: ['Linux', 'Windows', 'Mac', 'Other'],
	            datasets: [{
	                label: 'number of views',
	                backgroundColor: ['#0188ff','#fda105','#9f1eb4','#f54f26'],
	                fill: false,
	                clip:0,
	                data: [linux, windows, mac, other]
	            }]
	        },

	        // Configuration options go here
	        options: {
	            maintainAspectRatio: false,
	            legend: {
	                display: false
	            }
	        }
	    });
	    // GRAPHİCS END
	</script>
</body>
</html>