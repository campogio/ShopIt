<?php
	
	require "include/template2.inc.php";
	require "include/auth.inc.php";
	require "include/dbservice.inc.php";
	require "include/utils.inc.php";
	
	session_start();
	
	if(isset($_POST['remove'])){
		echo "testJS";
		removeFromCart($_SESSION['id'],$_POST['remove']);
		
		unset($_POST['remove']);
	}
	
	$main = new Template("dtml/frame-public.html");
	$body = new Template("dtml/user-cart.html");
	
	$counter = 0;
	
	$prods = getCartForUser($_SESSION['id']);
	$totalAmount = 0;
	
	while($data = $prods->fetch_assoc()){
	
	$body->setContent("itemId",$data['products_id']);
	$body->setContent("itemId2",$data['products_id']);
	$body->setContent("itemId3",$data['products_id']);
	
	
	$body->setContent("prodImage",$data['path']);
	
	$body->setContent("prodImageName",$data['name']);
	$body->setContent("prodName",$data['name']);
	
		if($data['saleprice']){
			$discount = $data['price']-$data['saleprice'];
			$total = $data['saleprice'] * $data['quantity'];
		
			$body->setContent("discountAmount",$discount);
		
		}else{
			$total = $data['price'] * $data['quantity'];
		
			$body->setContent("discountAmount","");
	
		}
	
	$body->setContent("price",$data['price']);
	$body->setContent("totalItem",$total);
	
	$totalAmount+= $total;
	$counter += $data['quantity'];
	
	echo json_encode($data);
	
	}
	
	$body->setContent("countItems",$counter);
	$body->setContent("totalAmount",$totalAmount);
	
	$main->setContent("body", $body->get());
	
	$main->close();
	
?>