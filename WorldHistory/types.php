<?php
session_start();
include('controller/c_WorldHistory.php');
$c_worldHistory = new c_WorldHistory();
$content = $c_worldHistory->types();
$menu = $content['menu'];
$first_new = $content['first_new'];
$types_menu = $content['types_menu'];
$types_content = $content['types_content'];
$paginationHTML = $content['paginationHTML'];

if(isset($_POST['Login'])){

	$login_email = $_POST['login_email'];
	$login_password = $_POST['login_password'];
	$user = $c_worldHistory->login_account($login_email, md5($login_password));
}
?>

<!DOCTYPE html>
<html lang="en">
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
	<link rel="stylesheet" href="public/css/types-custom.css">
</head>
<body>
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
				<li>
					<div id="stay"></div>
					<input type="text" name="search-bar" id="txtSearch" placeholder="Nhập thông tin cần tìm kiếm"/>
					<a href="#stay" id="btnSearch" class="glyphicon glyphicon-search"></a>
				</li>
				<?php
				if(isset($_SESSION['user_name'])){
					?>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?=$_SESSION['user_name']?><span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<?php
                    			if($_SESSION['user_name']=="admin"){
                    			?>
                      				<li><a href="post.php">Đăng bài</a></li>
                    			<?php  
                  			}
                  			?>
							<li><a href="logout.php">Đăng xuất</a></li>
						</ul>
					</li>
					<?php
				}else{
					?>
					<li class="dropdown">
                		<a class="dropdown-toggle glyphicon glyphicon-user" data-toggle="dropdown" href="#"><span class="caret"></a>
                  		<ul class="dropdown-menu" role="menu">
                    		<li><a href="#" id="btnLogin-Account">Đăng nhập</a></li>
                    		<li><a href="signup.php">Đăng ký</a></li>
                  		</ul>
              		</li>
					<?php
				}
				?>     
			</ul>
		</div><!-- /.navbar-collapse -->
	</div>
</nav>

<!-- Page Content -->
<div class="container-fuild">
	<div class="row">
		<div class="col-md-3 ">
			<ul class="list-group" id="menu">
				<li href="#" class="list-group-item menu1 active">
					Danh sách
				</li>

				<?php
				$tenGD='';
				for($i=0; $i<count($types_menu); $i++){
					if($tenGD!=$types_menu[$i]->TenGD){
						if($i>0){
							?>
						</ul>
						<?php
					}
					$tenGD = $types_menu[$i]->TenGD;
					?>
					<li href="#" class="list-group-item menu1">
						<?=$types_menu[$i]->TenGD?>
					</li>
					<ul>
						<?php
					}
					?>
					<li class="list-group-item">
						<a href="types.php?MaCTGD=<?=$types_menu[$i]->MaCTGD?>"><?=$types_menu[$i]->TenCTGD?></a>
					</li>
					<?php
				}
				?>
			</ul>
		</ul>
	</div>


	<div class="col-md-9" id="datasearch">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4><b><?=$types_content[0]->TenCTGD?></b></h4>
			</div>
			
			<?php
			for($i=0; $i<count($types_content); $i++){
				?>
				<div class="row-item row new-item">
					<div class="col-md-3">
						<a href="detail.php?MaSK=<?=$types_content[$i]->MaSK?>">
							<br>
							<img width="200px" height="200px" class="img-responsive" src="<?=$types_content[$i]->HinhSK?>" alt="">
						</a>
					</div>

					<div class="col-md-9">
						<h3><?=$types_content[$i]->TieuDe?></h3>
						<p><?=$types_content[$i]->TomtatSK?></p>
						<a class="btn btn-primary" href="detail.php?MaSK=<?=$types_content[$i]->MaSK?>">Xem chi tiết<span class="glyphicon glyphicon-chevron-right"></span></a>	
					</div>				
					<div class="break"></div>
				</div>
				<?php
			}
			?>

			<!-- Pagination -->
			<div class="row text-center">
				<div class="col-lg-12">
					<?=$paginationHTML?>
				</div>
			</div>
			<!-- end Pagination -->
		</div>
	</div> 

</div>

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

<div class="container-fluid">
	<div id="modal-dialog">
		<div class="modal-content col-md-6">
			<div class="row">
				<div class="close-modal glyphicon glyphicon-remove"></div>
				<h3 class="modal-title">Đăng nhập</h3>
				<a href="#row" class="thumbnail modal-image">
					<img src="public/images/login.png"/>
				</a>
				<p class="item-info">Đọc giải vui lòng điền đầu đủ thông tin để đăng nhập tài khoản!</p>
				<form method="POST" action="#">
					<div class="form-col">
						<label class="form-row">Tài khoản: </label>
						<input class="form-row" type="text" name="login_email" placeholder="Nhập tên tài khoản">
					</div>
					<div class="form-col">
						<label class="form-row">Mật khẩu: </label> 
						<input class="form-row" type="password" name="login_password" placeholder="Nhập mật khẩu">
					</div>
					<?php
					if(isset($_SESSION['user_error'])){
						?>
              				<script language="javascript">
                				alert("Sai thông tin đăng nhập");
              				</script>
              			<?php
              			unset($_SESSION['user_error']);
					}
					?>
					<div class="form-row" id="sign-up">
						<a herf="signup.php">Quên mật khẩu</a>
					</div>
					<table id="login-button-component">
						<tr>
							<td><input type="submit" name="Login" value="Đăng nhập"></td>
							<td><input id="btnCancel-Login" type="button" name="Cancel" value="Hủy"></td>
						</tr>
					</table>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="public/js/bootstrap.min.js"></script>
<script language="javascript" src="public/js/custom.js"></script>
<script language="javascript" src="public/js/types-custom.js"></script>
</body>
</html>