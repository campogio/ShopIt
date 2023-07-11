<?php
	
	require "include/template2.inc.php";
	require "include/utils.inc.php";
	require "include/dbservice.inc.php";
	require "include/auth.inc.php";
	
	session_start();
	
	$main = new Template("dtml/frame-public.html");
	
	$body = new Template("dtml/seller-items.html");
	
	$products=getProductsBySeller($_SESSION['id']);
	
	while($data = $products->fetch_assoc()){
		
		$body->setContent("itemId",$data['id']);
		
		
		$body->setContent("prodImage",$data['path']);
		
		$body->setContent("prodImageName",$data['name']);
		$body->setContent("prodName",$data['name']);
		
		if($data['saleprice']){
			$discount = $data['price']-$data['saleprice'];
			
			$body->setContent("discountAmount",$discount);
			$body->setContent("totalItem",$data['saleprice']);
			
		}else{
			$total = $data['price'] * $data['quantity'];
			$body->setContent("discountAmount","");
			$body->setContent("totalItem",$data['price']);
			
		}
		$body->setContent("quantity",$data['quantity']);
		
		$body->setContent("price",$data['price']);
		
		//echo json_encode($data);
		
	}
	
	$main->setContent("body",$body->get());
	
	populatePublicFrame($main);
	
	$main->close();
	
?>