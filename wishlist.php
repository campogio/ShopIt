<?php
	
	require "include/utils.inc.php";
	require "include/template2.inc.php";
	require "include/dbservice.inc.php";
	
	session_start();
	
	$main = new Template("dtml/frame-public.html");
	
	$body = new Template("dtml/user-wishlist.html");
	
	populatePublicFrame($main);
	
	$products = getUserWishlist($_SESSION['id']);
	
	while ($data = $products->fetch_assoc()){
		echo json_encode($data);
		
		$body->setContent("itemName",$data['name']);
		$body->setContent("itemImage",$data['path']);
		
		$body->setContent("itemId",$data['products_id']);
		$body->setContent("itemId2",$data['products_id']);
		
		
		if($data['saleprice']==null){
			$body->setContent("itemPrice",$data['price']);
			$body->setContent("itemSalePrice",'');
			$body->setContent("saleRibbon",'');
			
		}else{
			
			$body->setContent("itemPrice",'<del>'.$data["price"].'</del>');
			$body->setContent("itemSalePrice",$data["saleprice"]);
			$body->setContent("saleRibbon",'<div class="ribbon sale">SALE</div>');
			
		}
		
		//Check if new Ribbon needs to be added to product
		if(strtotime($data['added'])>strtotime('-7 day')){
			$body->setContent("newRibbon",'<div class="ribbon new">NEW</div>');
			echo "Earlier than 7 days <br>";
		}else{
			$body->setContent("newRibbon",'');
			echo "Later <br>";
		}
		
		
	}
	
	$main->setContent("body",$body->get());
	
	
	$main->close();
	
?>