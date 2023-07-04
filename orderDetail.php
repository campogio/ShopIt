<?php
	
	require "include/template2.inc.php";
	require "include/dbservice.inc.php";
	require "include/utils.inc.php";
	
	session_start();
	
	ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
	
	$main = new Template("dtml/frame-public.html");
	
	$body = new Template("dtml/user-order-detail.html");
	
	populatePublicFrame($main);
	
	$prods = getOrderProducts($_GET["id"]);
	
	$db_userId=0;
	
	while($data = $prods->fetch_assoc()){
		
		$db_userId = $data['user_id'];
		
		$body->setContent("productId",$data['products_id']);
		$body->setContent("productId2",$data['products_id']);
		
		$body->setContent("productImage",$data['path']);
		
		$body->setContent("productName",$data['name']);
		$body->setContent("productName2",$data['name']);
		
		if($data['saleprice']){
			$discount = $data['price']-$data['saleprice'];
			$total = $data['saleprice'] * $data['quantity'];
			
			$body->setContent("discount",$discount);
			
		}else{
			$total = $data['price'] * $data['quantity'];
			
			$body->setContent("discount","");
			
		}
		$body->setContent("quantity",$data['quantity']);
		
		
		$body->setContent("price",$data['price']);
		$body->setContent("productTotal",$total);
		
		$totalAmount+= $total;
		$counter += $data['quantity'];
		
		echo json_encode($data);
		
	}
	
	//TODO Manage if it's user's order or not
	if($_SESSION['id']== $db_userId){
		echo "Authorized";
	}else{
		echo "NOT Authorized";
	}
	
	$main->setContent("body",$body->get());
	
	$main->close();
	
?>