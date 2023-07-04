<?php
	
	include "include/template2.inc.php";
	include "include/dbservice.inc.php";
	include "include/utils.inc.php";
	
	session_start();
	
	$main = new Template("dtml/frame-public.html");
	$body = new Template("dtml/shop-item.html");
	
	populatePublicFrame($main);
	
	$product = getProductById($_GET['itemid']);
	$images = getImagesForProduct($_GET['itemid']);
	
	$body->setContent("itemId1",$_GET['itemid']);
	$body->setContent("itemId2",$_GET['itemid']);
	
	$categories = getTableData("category");
	
	while ($data = $categories->fetch_assoc()){
		
		$body->setContent("categoryHref", $data['name']);
		$body->setContent("sidebarCategory", $data['name']);
		
	}
	
	while ($data = $product->fetch_assoc()){
		
		$body->setContent("itemName", $data['name']);
		$body->setContent("itemNameBreadcrumb", $data['name']);
		
		$body->setContent("categoryName", $data['categoryname']);
		$body->setContent("categoryBreadcrumb", $data['categoryname']);
		
		if($data['saleprice']==null){
			$body->setContent("itemPrice", $data['price']);
		}else{
			$body->setContent("itemPrice", $data['saleprice']);
		}
		
		$body->setContent("itemDetails", "lorem ipsum");
		
	}
	
	while ($data = $images->fetch_assoc()){
		
		$body->setContent("imagePath", $data['path']);
		
	}
	
	$main->setContent("body",$body->get());
	
	$main->close();
	
?>