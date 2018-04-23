<?php
include('database.php');
class m_WorldHistory extends database{
	function getSlide(){
		$sql = "SELECT * FROM slide";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}

	//Lay gia tri cac the menu
	function getMenu(){
		$sql = "SELECT tl.TenTL, tl.TenKhongDauTL, GROUP_CONCAT(gd.MaGD,':', gd.TenGD,':', gd.TenKhongDauGD) AS GiaiDoan FROM theloai tl INNER JOIN giaidoan gd ON tl.MaTL = gd.MaTL GROUP BY tl.MaTL";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}

	function getFirstNew(){
		$sql = "SELECT gd.MaGD, ctgd.MaCTGD FROM giaidoan gd, chitietgiaidoan ctgd WHERE gd.MaGD = ctgd.MaGD GROUP BY gd.MaGD";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}

	//Lay thong tin tom tat cua tung giai doan
	function getDoc(){
		$sql = "SELECT tl.TenTL, tl.TenKhongDauTL, gd.TenGD, gd.TomtatGD FROM theloai tl INNER JOIN giaidoan gd ON tl.MaTL = gd.MaTL";
		$this->setQuery($sql);
		return $this->loadAllRows(); 
	}

	//Lay menu aside trong trang types
	function getTypesMenu(){
		$sql="SELECT gd.TenGD, ctgd.MaCTGD, ctgd.TenCTGD FROM giaidoan gd, chitietgiaidoan ctgd WHERE gd.MaGD = ctgd.MaGD";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}

	//Lay toan bo cac mau tin trong chi tiet giai doan (CTGD)
	function getTypesContent($_MaCTGD, $position=-1, $limitOfPage=-1){
		$sql="SELECT ctgd.TenCTGD, sk.MaSK, sk.TieuDe, sk.HinhSK, sk.TomtatSK FROM chitietgiaidoan ctgd, sukien sk WHERE  ctgd.MaCTGD = sk.MaCTGD AND ctgd.MaCTGD = $_MaCTGD";
		if($position>-1 && $limitOfPage>1){
			$sql .=" limit $position, $limitOfPage";
		}
		$this->setQuery($sql);
		return $this->loadAllRows(array($_MaCTGD));
	}

	//Lay bai viet chi tiet
	function getDetailContent($_MaSK){
		$sql="SELECT tl.TenTL, gd.TenGD, ctgd.TenCTGD, sk.MaSK, sk.TieuDe, sk.HinhSK, sk.NoiDung, sk.SoLuotXem, sk.Video, sk.created_at FROM theloai tl, giaidoan gd, chitietgiaidoan ctgd, sukien sk WHERE tl.MaTL = gd.MaTL AND gd.MaGD = ctgd.MaGD AND ctgd.MaCTGD = sk.MaCTGD AND sk.MaSK=$_MaSK";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}

	//Lay binh luan cua bai viet
	function getComment($_MaSK){
		$sql="SELECT bl.NoiDungBL, bl.created_at, nd.TenND FROM sukien sk, binhluan bl, nguoidung nd WHERE sk.MaSK = bl.MaSK AND bl.MaND = nd.MaND AND sk.MaSK = $_MaSK";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}

	//Lay tin lien quan
	function getRegarInfo($_MaSK){
		$sql="SELECT sk.MaSK, sk.TieuDe, sk.HinhSK FROM sukien sk WHERE sk.MaCTGD = (SELECT sk1.MaCTGD FROM sukien sk1 WHERE sk1.MaSK = $_MaSK) AND sk.MaSK!=$_MaSK LIMIT 4";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}

	//Lay tin noi bat
	function getHighlightInfo(){
		$sql="SELECT sk.MaSK, sk.TieuDe, sk.HinhSK FROM sukien sk ORDER BY sk.SoLuotXem DESC limit 6";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}

	//Them comment vao bai viet
	function addComment($MaSK,$MaND,$NoiDungBL){
		$sql="INSERT INTO binhluan(MaSK,MaND,NoiDungBL) VALUES(?,?,?)";
		$this->setQuery($sql);
		return $this->execute(array($MaSK,$MaND,$NoiDungBL));
	}


	//Them luot xem
	function increaseView($_MaSK){
		$sql="UPDATE sukien SET SoLuotXem = SoLuotXem+1 WHERE MaSK=?";
		$this->setQuery($sql);
		return $this->execute(array($_MaSK));
	}

	//search
	function search($key){
		$sql = "SELECT ctgd.TenCTGD, sk.MaSK, sk.TieuDe, sk.HinhSK, sk.TomtatSK FROM sukien sk, chitietgiaidoan ctgd WHERE sk.MaCTGD = ctgd.MaCTGD AND (sk.TieuDe like '%$key%' OR sk.TomtatSK like '%$key%')";
		$this->setQuery($sql);
		return $this->loadAllRows(array($key));
	}

	/*function search($key,$position=-1,$limitOfPage=-1){
		$sql = "SELECT ctgd.TenCTGD, sk.MaSK, sk.TieuDe, sk.HinhSK, sk.TomtatSK FROM sukien sk, chitietgiaidoan ctgd WHERE sk.MaCTGD = ctgd.MaCTGD AND (sk.TieuDe like '%$key%' OR sk.TomtatSK like '%$key%')";
		if($position>-1 && $limitOfPage>1){
			$sql .=" limit $position, $limitOfPage";
		}
		$this->setQuery($sql);
		return $this->loadAllRows(array($key));
	}*/

	function signup($TenND, $Email, $Password){
		if($TenND==""||$Email==""||$Password=="")
			return 0;
		$sql = "INSERT INTO nguoidung(TenND,Email,Password) VALUES(?,?,?)";
		$this->setQuery($sql);
		$result = $this->execute(array($TenND, $Email, md5($Password)));
		if($result){
			return $this->getLastId();
		}else{
			return 0;
		}
	}

	function login($Email, $md5_Password){
		$sql = "SELECT * FROM nguoidung WHERE Email = '$Email' and Password = '$md5_Password'";
		$this->setQuery($sql);
		return $this->loadRow(array($Email,$md5_Password));
	}

	function getCTGD(){
		$sql = "SELECT MaCTGD, TenCTGD FROM chitietgiaidoan";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}

	function addpost($MaCTGD,$TieuDe,$TomtatSK,$NoiDung,$HinhSK,$video){
		$sql = "INSERT INTO sukien(MaCTGD,TieuDe,TomtatSK,NoiDung,HinhSK,video) VALUES(?,?,?,?,?,?)";
		$this->setQuery($sql);
		$result = $this->execute(array($MaCTGD,$TieuDe,$TomtatSK,$NoiDung,$HinhSK,$video));
		if($result){
			return $this->getLastId();
		}else{
			return 0;
		}
	}
}
?>