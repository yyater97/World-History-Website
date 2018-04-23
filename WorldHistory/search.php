<?php
include('controller/c_WorldHistory.php');
$c_worldHistory = new c_WorldHistory();

if(isset($_POST['tukhoa'])){
	$key = $_POST['tukhoa'];
	$content = $c_worldHistory->_search($key);
	$types_content = $content['search_content'];
	//$paginationHTML = $content['paginationHTML'];
}

?>
<div class="panel panel-default">
			<div class="panel-heading">
				<h4><b>Tìm thấy <?=count($types_content)?> bài viết với từ "<?=$key?>"</b></h4>
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
			<!--<div class="row text-center">
				<div class="col-lg-12">
					<?=$paginationHTML?>
				</div>
			</div>-->
			<!-- end Pagination -->
		</div>