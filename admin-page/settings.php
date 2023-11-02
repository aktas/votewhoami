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

?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin | Vote Who Am I</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/9907df2918.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<style type="text/css">
		h3{
			text-align: center;
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
			<div class="col-md-4">
				<div class="col-md-12">
					<h3>Admin Settings</h3>
					<form action="process.php" method="POST" class="form" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-6">
								<span>Mevcut Profil Resmi:</span>
							</div>
							<div class="col-md-6">
								<img src="img/<?=$admin->img?>">
							</div>
						</div>
						<div class="file-upload-wrapper" data-text="Select your file!">
					    	<input type="file" name="file" class="file-upload-field" value="">
					    </div>  
					    <input type="text" class="form-control" required="" placeholder="Name" value="<?=$admin->name?>" name="name">
						<input type="text" class="form-control" required="" placeholder="Username" value="<?=$admin->username?>" name="username">
						<input type="text" class="form-control" required="" placeholder="City" value="<?=$admin->city?>" name="city">
						<input type="text" class="form-control" required="" placeholder="Statu" value="<?=$admin->statu?>" name="statu">
						<input type="hidden" value="<?=$token?>" name="token">
						<button type="submit" name="updateSettings" class="btn btn-success">Güncelle</button> <br> 
					</form>
					

				</div>
			</div>
			<div class="col-md-4">
				<div class="col-md-12">
					<h3>Passwords</h3>
					<form action="process.php" method="POST" class="form">
						<input type="password" class="form-control" name="password" required="" placeholder="Old Password">
						<input type="password" class="form-control" name="newPassword" required="" placeholder="New Password">
						<input type="password" class="form-control" name="newPasswordAgain" required="" placeholder="New Password Again">
						<input type="hidden" value="<?=$token?>" name="token">
						<button type="submit" name="updatePassword" class="btn btn-success">Güncelle</button> <br>
					</form> <br>
					<h3>Social Media</h3>
					<form action="process.php" method="POST" class="form">
						<input type="text" class="form-control" name="instagram_tr" required="" value="<?=$admin->instagramTr?>" placeholder="İnstagram Tr">
						<input type="text" class="form-control" name="instagram_en" required="" value="<?=$admin->instagramEn?>" placeholder="İnstagram En">
						<input type="hidden" value="<?=$token?>" name="token">
						<button type="submit" name="updateSocial" class="btn btn-success">Güncelle</button> <br>
					</form>
				</div>
			</div>
			<div class="col-md-4">
				<div class="col-md-12">
					<h3>Google</h3>
					<form action="process.php" method="POST" class="form">
						<input type="text" class="form-control" required="" name="title_tr" placeholder="Title TR" value="<?=$admin->titleTr?>">
						<input type="text" class="form-control" required="" name="title_en" placeholder="Title EN" value="<?=$admin->titleEn?>">
						<input type="text" class="form-control" required="" name="google" placeholder="Google Site Verification" value="<?=$admin->googleSiteVerification?>">
						<input type="text" class="form-control" required="" placeholder="Description TR" name="description_tr" value="<?=$admin->descriptionTr?>">
						<input type="text" class="form-control" required="" placeholder="Description EN" name="description_en" value="<?=$admin->descriptionEn?>">
						<input type="text" class="form-control" required="" placeholder="Keywords TR" name="keywords_tr" value="<?=$admin->keywordsTr?>">
						<input type="text" class="form-control" required="" placeholder="Keywords EN" name="keywords_en" value="<?=$admin->keywordsEn?>">
						<input type="hidden" value="<?=$token?>" name="token">
						<button type="submit" name="updateMetaTags" class="btn btn-success">Güncelle</button> <br>
					</form> <br>
					<h3>HOST</h3>
					<form action="process.php" method="POST" class="form">
						<input type="email" class="form-control" name="smtpEmail" required="" placeholder="SMTP Email" value="<?=$admin->smtpEmail?>">
						<input type="password" class="form-control" name="smtpPassword" required="" placeholder="SMTP Password" >
						<input type="password" class="form-control" name="smtpPasswordAgain" required="" placeholder="SMTP Password Again" >
						<input type="hidden" value="<?=$token?>" name="token">
						<button type="submit" name="updateSmtp" class="btn btn-success">Güncelle</button> <br>
					</form>
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

	<?php if(isset($_GET['statu']) and isset($_GET['type']) and ($_GET['statu'] == 1) and ($_GET['type'] == "warning")){ ?>
		<script type="text/javascript">
			toastr["warning"]("Bir sorun oluştu! Lütfen tekrar deneyin."); 
		</script>
	<?php }elseif(isset($_GET['statu']) and isset($_GET['type']) and $_GET['statu'] == 3 and ($_GET['type'] == "warning")){  ?>
		<script type="text/javascript">
			toastr["warning"]("Dosya yüklenirken bir sorun oluştu!"); 
		</script>
	<?php }elseif(isset($_GET['statu']) and isset($_GET['type']) and $_GET['statu'] == 4 and ($_GET['type'] == "warning")){  ?>
		<script type="text/javascript">
			toastr["warning"]("Dosya zaten mevcut! Lütfen dosyanın ismini değiştirin."); 
		</script>
	<?php }elseif(isset($_GET['statu']) and isset($_GET['type']) and $_GET['statu'] == 5 and ($_GET['type'] == "warning")){  ?>
		<script type="text/javascript">
			toastr["warning"]("Dosya boyutu 5MB'den büyük olamaz!"); 
		</script>
	<?php }elseif(isset($_GET['statu']) and isset($_GET['type']) and $_GET['statu'] == 6 and ($_GET['type'] == "warning")){  ?>
		<script type="text/javascript">
			toastr["warning"]("Dosya türü jpg veya png formatında olmalıdır!"); 
		</script>
	<?php }elseif(isset($_GET['statu']) and isset($_GET['type']) and $_GET['statu'] == 7 and ($_GET['type'] == "warning")){  ?>
		<script type="text/javascript">
			toastr["warning"]("Lütfen bir resim yükleyiniz!"); 
		</script>
	<?php }elseif(isset($_GET['statu']) and isset($_GET['type']) and $_GET['statu'] == 8 and ($_GET['type'] == "warning")){  ?>
		<script type="text/javascript">
			toastr["warning"]("Eski şifrenizi yanlış girdiniz!"); 
		</script>
	<?php }elseif(isset($_GET['statu']) and isset($_GET['type']) and $_GET['statu'] == 9 and ($_GET['type'] == "warning")){  ?>
		<script type="text/javascript">
			toastr["warning"]("Şifreler birbiri ile uyuşmuyor!"); 
		</script>
	<?php }elseif(isset($_GET['statu']) and isset($_GET['type']) and $_GET['statu'] == 2 and ($_GET['type'] == "success")){  ?>
    <script type="text/javascript">
      toastr["success"]("İşlem başarıyla gerçekleşti."); 
    </script>
  	<?php } ?>
</body>
</html>