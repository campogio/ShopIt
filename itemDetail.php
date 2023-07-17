<?php
	
	include "include/template2.inc.php";
	include "include/dbservice.inc.php";
	include "include/utils.inc.php";
	
	//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
	
	session_start();
	
	$main = new Template("dtml/frame-public.html");
	$body = new Template("dtml/shop-item.html");
	
	populatePublicFrame($main);
	
	$product = getProductById($_GET['itemid']);
	$images = getImagesForProduct($_GET['itemid']);
	
	$body->setContent("itemId1",$_GET['itemid']);
	$body->setContent("itemId2",$_GET['itemid']);
	$body->setContent("itemId3",$_GET['itemid']);
	$body->setContent("itemId4",$_GET['itemid']);
	
	$last_visited = array();
	//----------------- END LAST VISITED SESSION CONTROL ------------//
	if(!$_SESSION['last_visited']!=null){
		$_SESSION['last_visited']= array();
	}
	$last_visited = $_SESSION['last_visited'];
	
	
	if(!in_array($_GET['itemid'],$last_visited)){
		if(count($last_visited)>=3){
			array_shift($last_visited);
		}
		array_push($last_visited,$_GET['itemid']);
	}
	$_SESSION['last_visited'] = $last_visited;
	
	foreach ($_SESSION['last_visited'] as $prodId){
		$prod = getProductById($prodId);
		
		while ($data = $prod->fetch_assoc()){
			
			$body->setContent("recentProductId", $data['id']);
			$body->setContent("recentProductId2", $data['id']);
			
			$body->setContent("recentProductImage", $data['path']);
			
			$body->setContent("recentProductName", $data['name']);
			
			if($data['saleprice']==null){
				$body->setContent("recentProductPrice", $data['price']);
			}else{
				$body->setContent("recentProductPrice", $data['saleprice']);
			}
		}
	}
	
	//----------------- END LAST VISITED SESSION CONTROL ------------//
	
	//echo json_encode($_SESSION);
	
	if(isWishlisted($_GET['itemid'],$_SESSION['id'])){
		$body->setContent("isWishlisted",'fa fa-heart');
		
		
	}else{
		$body->setContent("isWishlisted",'fa-heart-o fa');
	}
	
	
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
		
		$desc = base64_decode($data['description']);
		
		$body->setContent("itemDetails", $desc);
		
	}
	
	while ($data = $images->fetch_assoc()){
		
		$body->setContent("imagePath", $data['path']);
		
	}
	
	
	
	$main->setContent("body",$body->get());
	
	$main->close();
	
?>