<?php
session_start();
include('controller/c_WorldHistory.php');

$c_worldHistory = new c_WorldHistory();
$content = $c_worldHistory->index();
$slide = $content['slide'];
$menu = $content['menu'];
$first_new = $content['first_new'];

if(isset($_POST['signup'])){
	$TenND = $_POST['name'];
	$Email = $_POST['email'];
	$Password = $_POST['password'];
	$Repassword = $_POST['passwordAgain'];
	if($Password == $Repassword){
		$user = $c_worldHistory->signup_account($TenND, $Email, $Password);
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="footer, address, phone, icons" />
	<title>World History - Detail Information</title>

	<!-- CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="public/css/footer-distributed-with-address-and-phones.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link rel="stylesheet" href="public/css/custom.css">
	<link rel="stylesheet" href="public/css/detail-custom.css">
</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-inverse">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed"
				data-toggle="collapse" data-target="#navbar-collapse"
				aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">
				<img id="nav_logo" src="public/images/nav_logo.png" alt="nav_logo">
			</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="navbar-collapse">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="index.php">Trang chủ</a></li>
				<?php
				$i=0;
				foreach($menu as $m){
					?>
					<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><?=$m->TenTL?><span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<?php
							$submenu = explode(',', $m->GiaiDoan);
							foreach($submenu as $isubmenu){
								list($ma,$ten,$tenkhongdau) = explode(':', $isubmenu);
								?>
								<li><a href="types.php?MaCTGD=<?=$first_new[$i]->MaCTGD?>"><?=$ten?></a></li>
								<?php
								$i++;
							}
							?>
						</ul>
						<?php
					}
					?>         
				</li>

				<li><a href="index.php#contact-us">Liên hệ</a></li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div>
</nav>

<!-- Page Content -->
<div class="container">

	<!-- slider -->
	<div class="row carousel-holder">
		<div class="col-md-2">
		</div>
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading" style="font-size: 20px; font-weight: bold;">Đăng ký tài khoản</div>
				<div class="panel-body">
					<form method="POST" action="#">
						<div>
							<label>Họ tên</label>
							<input type="text" class="form-control" placeholder="Nhập tài khoản" name="name" aria-describedby="basic-addon1">
						</div>
						<br>
						<div>
							<label>Email</label>
							<input type="email" class="form-control" placeholder="Nhập Email" name="email" aria-describedby="basic-addon1"
							>
						</div>
						<br>	
						<div>
							<label>Nhập mật khẩu</label>
							<input type="password" class="form-control" placeholder="Nhập mật khẩu" name="password" aria-describedby="basic-addon1">
						</div>
						<br>
						<div>
							<label>Nhập lại mật khẩu</label>
							<input type="password" class="form-control" placeholder="Nhập lại mật khẩu" name="passwordAgain" aria-describedby="basic-addon1">
						</div>
						<br>
						<button type="submit" id="signup-button" name="signup" class="btn btn-success">Đăng ký</button>
					</form>
					<?php
						if(isset($_SESSION['error'])){
							echo "<div class='alert alert-danger'>".($_SESSION['error'])."</div>";
						}
					?>
				</div>
			</div>
		</div>
		<div class="col-md-2">
		</div>
	</div>
	<!-- end slide -->
</div>
<!-- end Page Content -->

<!-- footer -->
<footer class="footer-distributed">
	<div class="footer-left">
		<img src="public/images/footer_logo.png" alt="">
		<p class="footer-links">
			<a href="#">Trang Chủ</a>
			·
			 <?php
        		foreach($menu as $m){
          		?>
            		<a href="#"><?=$m->TenTL?></a>
            		·
          		<?php
        		}
      		?>
			<a href="#">Liên hệ</a>
		</p>
		<p class="footer-company-name">Nhóm 18 &copy; 2018</p>
	</div>
	<div class="footer-center">
		<div>
			<i class="fa fa-map-marker"></i>
			<p><span>Khu phố 6, phường Linh Trung</span>Quận Thủ Đức, Tp.Hồ Chí Minh</p>
		</div>
		<div>
			<i class="fa fa-phone"></i>
			<p>(08) 37251993</p>
		</div>
		<div>
			<i class="fa fa-envelope"></i>
			<p><a href="mailto:DHCNTT_TPHCM@gm.uit.com.vn">DHCNTT_TPHCM@gm.uit.com.vn</a></p>
		</div>
	</div>
	<div class="footer-right">
		<p class="footer-company-about">
			<span>Thông tin về nhóm:</span>
			<p class="group-member">Nhóm bao gồm 5 thành viên:</p>
			<p class="group-member">15520801: Dương Văn Thanh</p>
			<p class="group-member">15520680: Phạm Ngọc Quân</p>
			<p class="group-member">15520679: Nguyễn Trung Quân</p>
			<p class="group-member">15520693: Trần Hưng Quang</p>
			<p class="group-member">14520708: Lê Ngọc Hoàng Phước</p> 
		</p>
		<div class="footer-icons">
			<a href="#"><i class="fa fa-facebook"></i></a>
			<a href="#"><i class="fa fa-twitter"></i></a>
			<a href="#"><i class="fa fa-linkedin"></i></a>
			<a href="#"><i class="fa fa-github"></i></a>
		</div>
	</div>
</footer>
<!-- JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="public/js/bootstrap.min.js"></script>
</body>
</html>
