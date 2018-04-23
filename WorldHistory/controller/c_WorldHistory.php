<?php
	include('model/m_WorldHistory.php');
	include('model/pager.php');

	class c_WorldHistory{
		public function index(){
			$m_worldHistory = new m_WorldHistory();
			$slide = $m_worldHistory->getSlide();
			$menu = $m_worldHistory->getMenu();
			$first_new = $m_worldHistory->getFirstNew();
			$doc = $m_worldHistory->getDoc();
			return array('slide'=>$slide,'menu'=>$menu,'first_new'=>$first_new, 'doc'=>$doc);
		}

		public function types(){
			$_MaCTGD = $_GET['MaCTGD'];
			$m_worldHistory = new m_WorldHistory();
			$menu = $m_worldHistory->getMenu();
			$first_new = $m_worldHistory->getFirstNew();
			$types_menu = $m_worldHistory->getTypesMenu();
			$types_content = $m_worldHistory->getTypesContent($_MaCTGD);
			
			//Phan cac trang con cho tung mau tin
			$current_page = (isset($_GET['page']))?$_GET['page']:1;
			$pagination = new pagination(count($types_content),$current_page, 3, 10);
			$paginationHTML = $pagination->showPagination();

			//Gioi han so trang
			$limitOfPage = $pagination->get_nItemOnPage();
			$position = ($current_page-1)*$limitOfPage;
			$types_content = $m_worldHistory->getTypesContent($_MaCTGD, $position, $limitOfPage);

			return array('menu'=>$menu, 'first_new'=>$first_new, 'types_menu'=>$types_menu, 'types_content'=>$types_content, 'paginationHTML'=>$paginationHTML);

		}

		public function detail(){
			$_MaSK = $_GET['MaSK'];
			$m_worldHistory = new m_WorldHistory();
			$menu = $m_worldHistory->getMenu();
			$first_new = $m_worldHistory->getFirstNew();
			$detail_content = $m_worldHistory->getDetailContent($_MaSK);
			$comment = $m_worldHistory->getComment($_MaSK);
			$regar_info = $m_worldHistory->getRegarInfo($_MaSK);
			$highlight_info = $m_worldHistory->getHighlightInfo();
			$m_worldHistory->increaseView($_MaSK);
			return array('menu'=>$menu, 'first_new'=>$first_new, 'detail_content'=>$detail_content[0], 'comment'=>$comment, 'regar_info'=>$regar_info, 'highlight_info'=>$highlight_info);
		}

		public function comment($MaSK,$MaND,$NoiDungBL){
			$m_worldHistory = new m_WorldHistory();
			$comment = $m_worldHistory->addComment($MaSK,$MaND,$NoiDungBL);
			header('Location:'.$_SERVER['HTTP_REFERER'].'#comment');
		}

		public function _search($key){
			$m_worldHistory = new m_WorldHistory();
			$search_content = $m_worldHistory->search($key);

			//Phan cac trang con cho tung mau tin
			/*$current_page = (isset($_GET['page']))?$_GET['page']:1;
			$pagination = new pagination(count($search_content),$current_page, 3, 10);
			$paginationHTML = $pagination->showPagination();

			//Gioi han so trang
			$limitOfPage = $pagination->get_nItemOnPage();
			$position = ($current_page-1)*$limitOfPage;
			$search_content = $m_worldHistory->search($key, $position, $limitOfPage);*/
			return array('search_content'=>$search_content/*, 'paginationHTML'=>$paginationHTML*/);
		}

		public function signup_account($TenND, $Email, $Password){	
			$m_worldHistory = new m_WorldHistory();
			$MaND = $m_worldHistory->signup($TenND, $Email, $Password);
			if($MaND!=0){
				$_SESSION['success'] = "Đăng kí thành công";
				header('location:index.php');
				if(isset($_SESSION['error'])){
					unset($_SESSION['error']);
				}
			}else{
				$_SESSION['error'] = "Đăng kí thất bại";
				header('location:signup.php');
			}
		}

		public function login_account($Email, $Password){
			$m_worldHistory = new m_WorldHistory();
			$user = $m_worldHistory->login($Email, $Password);
			if($user == true){
				$_SESSION['user_name'] = $user->TenND;
				$_SESSION['user_id'] = $user->MaND;
				header('Location:'.$_SERVER['HTTP_REFERER']);
				if(isset($_SESSION['user_error'])){
					unset($_SESSION['user_error']);
				}
				if(isset($_SESSION['not_login_yet'])){
					unset($_SESSION['not_login_yet']);
				}				
			}else{
				$_SESSION['user_error'] = "Sai thông tin đăng nhập";
				header('Location:'.$_SERVER['HTTP_REFERER']);
			}
			
		}

		public function logout_account(){
			session_destroy();
			header('Location:'.$_SERVER['HTTP_REFERER']);
		}

		public function CTGD_option(){
			$m_worldHistory = new m_WorldHistory();
			$CTGD = $m_worldHistory->getCTGD();
			return array('CTGD'=>$CTGD);
		}

		public function post($MaCTGD,$TieuDe,$TomtatSK,$NoiDung,$HinhSK,$video){
			$m_worldHistory = new m_WorldHistory();
			$MaND = $m_worldHistory->addpost($MaCTGD,$TieuDe,$TomtatSK,$NoiDung,$HinhSK,$video);
			if($MaND!=0){
				$_SESSION['post_success'] = "Thêm bài viết thành công";
				header('location:post.php');
				if(isset($_SESSION['post_error'])){
					unset($_SESSION['post_error']);
				}
			}else{
				$_SESSION['post_error'] = "Thêm bài viết thất bại";
				header('location:post.php');
			}
		}
	}
?>