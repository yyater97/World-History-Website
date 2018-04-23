<?php
session_start();
include('controller/c_WorldHistory.php');
$c_worldHistory = new c_WorldHistory();
$content = $c_worldHistory->detail();
$menu = $content['menu'];
$first_new = $content['first_new'];
$detail_content = $content['detail_content'];
$comment = $content['comment'];
$regar_info = $content['regar_info'];
$highlight_info = $content['highlight_info'];

if(isset($_POST['Login'])){

	$login_email = $_POST['login_email'];
	$login_password = $_POST['login_password'];
	$user = $c_worldHistory->login_account($login_email, md5($login_password));
}

if(isset($_POST['binhluan'])){
	if(isset($_SESSION['user_id'])){
		$MaSK = $_POST['MaSK'];
		$MaND = $_SESSION['user_id'];
		$NoiDungBL = $_POST['NoiDungBL'];
		$addcomment = $c_worldHistory->comment($MaSK,$MaND,$NoiDungBL);
	}else{
		$_SESSION['not_login_yet'] = "Vui lòng đăng nhập để thêm bình luận";
	}
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
	<link rel="stylesheet" href="public/css/detail-custom.css">
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
<div class="container-fluid">
	<div class="row">

		<!-- Blog Post Content Column -->
		<div class="col-md-9 content">
			<div class="main-content">

				<!-- Blog Post -->

				<!-- Title -->
				<h1><?=$detail_content->TieuDe?></h1>

				<!-- Author -->
				<p class="lead">
					by <a href="#">Nhóm 18</a>
				</p>
				
				<ol class="breadcrumb">
					<li><a href="#"><?=$detail_content->TenTL?></a></li>
					<li><a href="#"><?=$detail_content->TenGD?></a></li>
					<li><a href="#"><?=$detail_content->TenCTGD?></a></li>       
				</ol>

				<p class="view">Số lượt xem: <?=$detail_content->SoLuotXem?></p>

				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#content">Nội dung</a></li>
					<li><a data-toggle="tab" href="#video">Video</a></li>
				</ul>

				<div class="tab-content">
					<div id="content" class="tab-pane fade in active">

						<!-- Preview Image -->
						<img class="img-responsive" style="margin: 0 auto" src="<?=$detail_content->HinhSK?>" alt="">

						<!-- Date/Time -->
						<p><span class="glyphicon glyphicon-time"></span> Posted on <?=$detail_content->created_at?></p>

						<!-- Post Content -->
						<p class="lead">
							<?=$detail_content->NoiDung?>
						</p>						
						
					</div>

					<div id="video" class="tab-pane fade">
						<div class="img-responsive">
							<?php
							if($detail_content->Video!=NULL){	
								?>				
								<video src="<?=$detail_content->Video?>" controls="controls" style="width:100%; height: auto"></video>	
								<?php
							}else{
								?>
								<blockquote>Hiện tại chưa cập nhật video ứng với nội dung này</blockquote>						
								<?php
							}	
							?>
						</div>				
					</div>

					<hr>

					<!-- Blog Comments -->

					<!-- Comments Form -->
					<div class="well" id="comment">
						<h4>Viết bình luận ...<span class="glyphicon glyphicon-pencil"></span></h4>
						<form role="form" method="post" action="#">
							<input type="hidden" name="MaSK" value="<?=$detail_content->MaSK?>">
							<div class="form-group">
								<textarea class="form-control" rows="3" name="NoiDungBL"></textarea>
							</div>
							<input id="btnComment" type="submit" name="binhluan" value="Gửi bình luận">
							<div class="clear"></div>
						</form>
					</div>

					<!-- Posted Comments -->
					<?php
						if(isset($_SESSION['not_login_yet'])){
							echo "<div class='alert alert-danger'>".$_SESSION['not_login_yet']."</div>";
						}
					?>
					<!-- Comment -->
					<?php 
					foreach($comment as $cm){
						?>
						<div class="media">
							<a class="pull-left" href="#">
								<img class="media-object" src="public/images/men_user.png" alt="">
							</a>
							<div class="media-body">
								<h4 class="media-heading">
									<span style="font-weight: bold; font-size: 18px"><?=$cm->TenND?></span>
									<span style="font-size: 10px"><?=$cm->created_at?></span>
								</h4>
								<p><?=$cm->NoiDungBL?></p>
							</div>
						</div>
						<?php
					}
					?>

				</div>
			</div>
		</div>
		<!-- Blog Sidebar Widgets Column -->
		<div class="col-md-3 aside-bar">

			<div class="panel panel-default">
				<div class="panel-heading"><b>Tin liên quan</b></div>
				<div class="panel-body">

					<!-- item -->
					<?php 
					foreach($regar_info as $regar){
						?>
						<div class="row" style="margin-top: 10px; padding: 0 15px">
							<div class="col-md-5">
								<a href="detail.php?MaSK=<?=$regar->MaSK?>">
									<img class="img-responsive" src="<?=$regar->HinhSK?>" alt="">
								</a>
							</div>
							<div class="col-md-7">
								<a href="detail.php?MaSK=<?=$regar->MaSK?>"><b><?=$regar->TieuDe?></b></a>
							</div>
							<!--<p><?=$hi->TomTatSK?></p>-->
							<div class="break"></div>
						</div>
						<!-- end item -->
						<?php
					}
					?>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading"><b>Tin nổi bật</b></div>
				<div class="panel-body">

					<!-- item -->
					<?php 
					foreach($highlight_info as $hi){
						?>
						<div class="row" style="margin-top: 10px; padding: 0 15px">
							<div class="col-md-5">
								<a href="detail.php?MaSK=<?=$hi->MaSK?>">
									<img class="img-responsive" src="<?=$hi->HinhSK?>" alt="">
								</a>
							</div>
							<div class="col-md-7">
								<a href="detail.php?MaSK=<?=$hi->MaSK?>"><b><?=$hi->TieuDe?></b></a>
							</div>
							<!--<p><?=$hi->TomTatSK?></p>-->
							<div class="break"></div>
						</div>
						<!-- end item -->
						<?php
					}
					?>
				</div>
			</div>

		</div>

	</div>
	<!-- /.row -->
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
</body>
</html>