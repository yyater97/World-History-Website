<?php
session_start();
include('controller/c_WorldHistory.php');
$c_worldHistory = new c_WorldHistory();
$content = $c_worldHistory->index();
$slide = $content['slide'];
$menu = $content['menu'];
$first_new = $content['first_new'];
$doc = $content['doc'];

if(isset($_POST['Login'])){

  $login_email = $_POST['login_email'];
  $login_password = $_POST['login_password'];
  $user = $c_worldHistory->login_account($login_email, md5($login_password));
}
?>



<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="footer, address, phone, icons" />
  <title>World History</title>

  <!-- CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="public/css/footer-distributed-with-address-and-phones.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
  <link rel="stylesheet" href="public/css/custom.css">

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
        <li class="active"><a href="#">Trang chủ</a></li>
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
        <li><a href="#contact-us">Liên hệ</a></li>
        <?php
            if(isset($_SESSION['user_name'])){
              ?>
              <li class="dropdown">
                <a  class="down-toggle" data-toggle="dropdown" href="#"><?=$_SESSION['user_name']?><span class="caret"></span></a>
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

<article>
  <!-- carousel -->
  <div id="carousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <?php
      for($i=0; $i<count($slide); $i++){
        if($i==0){
          ?>
          <li data-target="#carousel" data-slide-to="<?=$i?>" class="active"></li>
          <?php
        }else{
          ?>
          <li data-target="#carousel" data-slide-to="<?=$i?>"></li>
          <?php
        }        
      }
      ?>  
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">    
      <?php
      for($i=0; $i<count($slide); $i++){
        if($i==0){
          ?>
          <div class="item active">
            <img src="public/images/slide/<?=$slide[$i]->hinh?>">
          </div>
          <?php
        }
        else{
          ?>
          <div class="item">
            <img src="public/images/slide/<?=$slide[$i]->hinh?>">
          </div>
          <?php
        }
      }
      ?>      
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#carousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#carousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>

  <div id="content">    
    <div class="container-fluid">
      <!-- Grid system -->
      
      <?php
      $tenTL='';
      for($i=0; $i<count($doc); $i++){
        if($tenTL!=$doc[$i]->TenTL){
          if($i>0){
            ?>
          </div>
          <?php
        }
        $tenTL = $doc[$i]->TenTL;
        ?>
        <div class="row">
          <h3 class="item-type-title" id="<?=$doc[$i]->TenKhongDauTL?>"><?=$doc[$i]->TenTL?></h3> 
          <?php
        }
        ?>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <a href="types.php?MaCTGD=<?=$first_new[$i]->MaCTGD?>" class="thumbnail">
            <i class="fa fa-plus"></i>
            <?=$doc[$i]->TomtatGD?>
            <div class="item-title"><?=$doc[$i]->TenGD?></div>
          </a>
        </div>
        <?php
      }
      ?>
      </div>
      <!--Contact us-->
      <div class="row" id="contact-us">
        <p id="contact-us-title">Liên hệ với chúng tôi</p>
        <form action="#">
          <div class="col-md-6">
            <div class="form-col">
              <label class="form-row">Họ và tên:</label>
              <input class="form-row" type="text" name="contact_name">
            </div>          
            <div class="form-col">
              <label class="form-row">Địa chỉ email:</label>
              <input class="form-row" type="text" name="contact_email">
            </div>
            <div class="form-col">
              <label class="form-row">Nội dung:</label>
              <textarea class="form-row" id="contact-us-content"></textarea>
            </div>
            <input class="form-col" type="button" name="submit" value="Gửi lời nhắn">
            <blockquote>Xin chân thành cám ơn bạn đã đóng góp ý kiến!</blockquote>
          </div>
          <div class="col-md-6">
            <blockquote>Chúng tôi cố gắng cung cấp những thông tin chính xác nhất đến với quý độc giả, trong quá trình hoạt động không tránh được sơ xuất, mọi thắc mắc đóng góp vui lòng hay gửi cho chúng tôi theo mẫu. Mọi ý kiến, đóng góp của bạn sẽ giúp cải thiện chất lượng của website. Chúc quý đọc giả có phút giây thư giản và những hiểu biết bổ ích!</br>Xin chân thành cám ơn!</blockquote>
            <a href="#abc" class="thumbnail">
              <img src="public/images/Lich-su-the-gioi-World-History.jpg" alt="">
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</article>

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
            <a href="#<?=$m->TenKhongDauTL?>"><?=$m->TenTL?></a>
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
            <a herf="signup.php" id="signup-link" style="z-index: 10;">Quên mật khẩu</a>
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
  <script language="javascript" src="public/js/bootstrap.min.js"></script>
  <script language="javascript" src="public/js/custom.js"></script>
  <script language="javascript" src="public/js/menu-follow.js"></script>
</body>
</html>

