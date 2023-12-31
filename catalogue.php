<?php
	
	require "include/template2.inc.php";
	require "include/dbservice.inc.php";
	require "include/utils.inc.php";
	
	session_start();
	
	$main = new Template("dtml/frame-public.html");
	
	$body = new Template("dtml/shop-catalogue.html");
	
	populatePublicFrame($main);
	
	$filters = array();
	$page = 1;
	
	if(isset($_GET['page'])){
		$page = $_GET['page'];
	}
	
	if(isset($_GET['category'])){
		//echo $_GET['category'];
		$filters['category']= $_GET['category'];
	}
	
	if(isset($_GET['brand'])){
		//echo $_GET['category'];
		$filters['brand']= $_GET['brand'];
	}
	
	if(isset($_GET['tag'])){
		
		$filters['tags'] = array();
		
		foreach ($_GET['tag'] as $tag){
			array_push($filters['tags'],$tag);
		}
		
	}
	
	//////// CATEGORY POPULATION START /////////////
	
	$categories = getTableData("category");
	
	while ($data= $categories->fetch_assoc()){
		//echo json_encode($data);
		$body->setContent("categoryHref", $data['name']);
		$body->setContent("sidebarCategory", $data['name']);
		$body->setContent("filterCategory", $data['name']);
		$body->setContent("categoryValue", $data['name']);
		$body->setContent("categoryJs", $data['id']);
		
	}
	
	/////////// BRAND POPULATION START ////////////////
	
	$brands = getTableData("brand");
	
	while ($data= $brands->fetch_assoc()){
		//echo json_encode($data);
		$body->setContent("brandValue", $data['id']);
		$body->setContent("filterBrand", $data['name']);
	}
	
	/////////////////////////////////////////////
	
	if(isset($_GET['search'])){
		$products = getProductsByFilters($filters,12,($page-1)*12,$_GET['search']);
	}else{
		$products = getProductsByFilters($filters,12,($page-1)*12,'');
	}
	
	while ($data= $products->fetch_assoc()){
		
		$body->setContent("productName",$data['name']);
		$body->setContent("itemImagePath",$data['path']);
		$body->setContent("itemId1",$data['id']);
		$body->setContent("itemId2",$data['id']);
		
		
		if($data['saleprice']==null){
			$body->setContent("productPrice", $data['price']);
			$body->setContent("productSalePrice", '');
			$body->setContent("saleRibbon",'');
		}else{
			
			$body->setContent("productPrice", '<del>'.$data["price"].'</del>');
			$body->setContent("productSalePrice", $data['saleprice']);
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
		
		$body->setContent("page",'<li class="page-item active"><a href="catalogue.php?page=1" class="page-link">1</a></li>');
		$body->setContent("page",'<li class="page-item"><a href="catalogue.php?page=2" class="page-link">2</a></li>');
		$body->setContent("page",'<li class="page-item"><a href="catalogue.php?page=3" class="page-link">3</a></li>');
		$body->setContent("page",'<li class="page-item"><a href="catalogue.php?page=4" class="page-link">4</a></li>');
		$body->setContent("page",'<li class="page-item"><a href="catalogue.php?page=5" class="page-link">5</a></li>');
		
	}elseif ($page == 2){
		$body->setContent("page",'<li class="page-item"><a href="catalogue.php?page=1" class="page-link">1</a></li>');
		$body->setContent("page",'<li class="page-item active"><a href="catalogue.php?page=2" class="page-link">2</a></li>');
		$body->setContent("page",'<li class="page-item"><a href="catalogue.php?page=3" class="page-link">3</a></li>');
		$body->setContent("page",'<li class="page-item"><a href="catalogue.php?page=4" class="page-link">4</a></li>');
		$body->setContent("page",'<li class="page-item"><a href="catalogue.php?page=5" class="page-link">5</a></li>');
	}else{
		$body->setContent("page",'<li class="page-item"><a href="catalogue.php?page='.($page-2).'" class="page-link">'.($page-2).'</a></li>');
		$body->setContent("page",'<li class="page-item"><a href="catalogue.php?page='.($page-1).'" class="page-link">'.($page-1).'</a></li>');
		$body->setContent("page",'<li class="page-item active"><a href="catalogue.php?page='.($page).'" class="page-link">'.($page).'</a></li>');
		$body->setContent("page",'<li class="page-item"><a href="catalogue.php?page='.($page+1).'" class="page-link">'.($page+1).'</a></li>');
		$body->setContent("page",'<li class="page-item"><a href="catalogue.php?page='.($page+2).'" class="page-link">'.($page+2).'</a></li>');
	}
	
	$main ->setContent("body", $body->get());
	
	$main ->close();
	
?>

