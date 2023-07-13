<?php
	
	require "include/template2.inc.php";
	require "include/dbservice.inc.php";
	require "include/utils.inc.php";
	
	//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
	
	
	session_start();
	
	$main = new Template("dtml/frame-public.html");
	$body = new Template("dtml/shop-category.html");
	
	$page=$_GET['page'];
	
	populatePublicFrame($main);
	
	$body->setContent("categoryHeader",$_GET['category']);
	$body->setContent("categoryBreadcrumb",$_GET['category']);
	
	$products = getProductsByCategory($_GET['category'],12,($_GET['page']-1)*12);
	
	
	$categories = getTableData("category");
	
	while ($data = $categories->fetch_assoc()){
		
		$body->setContent("categoryHref", $data['name']);
		$body->setContent("sidebarCategory", $data['name']);
		
	}
	
	while ($data = $products->fetch_assoc()){
		//echo json_encode($data);
		
		$body->setContent("productName",$data['name']);
		$body->setContent("productImagePath",$data['path']);
		
		$body->setContent("prodId1",$data['id']);
		$body->setContent("prodId2",$data['id']);
		
		
		if($data['saleprice']==null){
			$body->setContent("productPrice",$data['price']);
			$body->setContent("productSalePrice",'');
			$body->setContent("saleRibbon",'');
			
		}else{
			
			$body->setContent("productPrice",'<del>'.$data["price"].'</del>');
			$body->setContent("productSalePrice",$data["saleprice"]);
			$body->setContent("saleRibbon",'<div class="ribbon sale">SALE</div>');
			
		}
		
		//Check if new Ribbon needs to be added to product
		if(strtotime($data['added'])>strtotime('-7 day')){
			$body->setContent("newRibbon",'<div class="ribbon new">NEW</div>');
			//echo "Earlier than 7 days <br>";
		}else{
			$body->setContent("newRibbon",'');
			//echo "Later <br>";
		}
		
		
	}
	
	/// -------- PAGING ----------- /////
	
	if($page == 1){
		
		$body->setContent("page",'<li class="page-item active"><a href="fullCategory.php?category='.$_GET['category'].'&page=1" class="page-link">1</a></li>');
		$body->setContent("page",'<li class="page-item"><a href="fullCategory.php?category='.$_GET['category'].'&page=2" class="page-link">2</a></li>');
		$body->setContent("page",'<li class="page-item"><a href="fullCategory.php?category='.$_GET['category'].'&page=3" class="page-link">3</a></li>');
		$body->setContent("page",'<li class="page-item"><a href="fullCategory.php?category='.$_GET['category'].'&page=4" class="page-link">4</a></li>');
		$body->setContent("page",'<li class="page-item"><a href="fullCategory.php?category='.$_GET['category'].'&page=5" class="page-link">5</a></li>');
		
	}elseif ($page == 2){
		$body->setContent("page",'<li class="page-item"><a href="fullCategory.php?category='.$_GET['category'].'&page=1" class="page-link">1</a></li>');
		$body->setContent("page",'<li class="page-item active"><a href="fullCategory.php?category='.$_GET['category'].'&page=2" class="page-link">2</a></li>');
		$body->setContent("page",'<li class="page-item"><a href="fullCategory.php?category='.$_GET['category'].'&page=3" class="page-link">3</a></li>');
		$body->setContent("page",'<li class="page-item"><a href="fullCategory.php?category='.$_GET['category'].'&page=4" class="page-link">4</a></li>');
		$body->setContent("page",'<li class="page-item"><a href="fullCategory.php?category='.$_GET['category'].'&page=5" class="page-link">5</a></li>');
	}else{
		$body->setContent("page",'<li class="page-item"><a href="fullCategory.php?category='.$_GET['category'].'&page='.($page-2).'" class="page-link">'.($page-2).'</a></li>');
		$body->setContent("page",'<li class="page-item"><a href="fullCategory.php?category='.$_GET['category'].'&page='.($page-1).'" class="page-link">'.($page-1).'</a></li>');
		$body->setContent("page",'<li class="page-item active"><a href="fullCategory.php?category='.$_GET['category'].'&page='.($page).'" class="page-link">'.($page).'</a></li>');
		$body->setContent("page",'<li class="page-item"><a href="fullCategory.php?category='.$_GET['category'].'&page='.($page+1).'" class="page-link">'.($page+1).'</a></li>');
		$body->setContent("page",'<li class="page-item"><a href="fullCategory.php?category='.$_GET['category'].'&page='.($page+2).'" class="page-link">'.($page+2).'</a></li>');
	}
	
	
	$main->setContent("body",$body->get());
	
	$main->close();
	
?>