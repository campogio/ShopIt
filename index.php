<?php

	require "include/template2.inc.php";
	require "include/auth.inc.php";
	require "include/dbservice.inc.php";
	require "include/utils.inc.php";


	session_start();
	
	//echo json_encode($_SESSION);
	
	ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

    $main = new Template("dtml/frame-public.html");
    $body = new Template("dtml/shop-home.html");
	
	$categories = getTableData("category")->fetch_all();
	
	for($k=0;$k<3;$k++){
		
		$body->setContent("category_href", $categories[$k][1]);
		$body->setContent("category", $categories[$k][1]);
		$body->setContent("categoryHref", $categories[$k][1]);
		$body->setContent("sidebarCategory", $categories[$k][1]);
		
		$products= getProductsByCategory($categories[$k][1],3,0);
		
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
		
	}
	
	populatePublicFrame($main);
	
	
    $main->setContent("body", $body->get());
    $main->close();


?>