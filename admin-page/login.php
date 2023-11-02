<?php 
require_once "functions/sessions.php";
require_once "functions/date.php";
require_once "functions/security.php";
require_once "functions/routing.php";

$token = md5(uniqid(mt_rand(), true));
setSession("token",$token);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login | Vote Who Am I</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/9907df2918.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="shortcut icon" type="image/png" href="img/favicon.ico"/>
</head>
<body>

	<div class="login">
		<form action="loginControl.php" method="POST">
			<h3>Login</h3> <br>
			<input type="text" class="form-control" name="username" required="" minlength="8" maxlength="34" placeholder="User Name">
			<input type="password" class="form-control" name="password" required="" minlength="8" maxlength="34" placeholder="Password">
			<input type="hidden" name="token" value="<?=trim($token)?>">
			<div class="login-button">
				<button type="submit" class="btn btn-success" name="adminLogin">Giriş</button>
			</div>
		</form>
		
	</div>




	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
  	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<?php if(isset($_GET['statu']) and isset($_GET['type']) and ($_GET['statu'] == 1) and ($_GET['type'] == "warning")){ ?>
		<script type="text/javascript">
			toastr["warning"]("Bir sorun oluştu! Lütfen tekrar deneyin."); 
		</script>
	<?php }elseif(isset($_GET['statu']) and isset($_GET['type']) and $_GET['statu'] == 2 and ($_GET['type'] == "warning")){  ?>
		<script type="text/javascript">
			toastr["warning"]("Kullanıcı adı veya şifre hatalı! Lütfen tekrar deneyin."); 
		</script>
	<?php }elseif(isset($_GET['statu']) and isset($_GET['type']) and $_GET['statu'] == 1 and ($_GET['type'] == "success")){  ?>
    <script type="text/javascript">
      toastr["success"]("Başarıyla çıkış yapıldı."); 
    </script>
  <?php } ?>
</body>
</html>