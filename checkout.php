<?php
	
	require "include/template2.inc.php";
	require "include/dbservice.inc.php";
	require "include/utils.inc.php";
	
	ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
	session_start();
	
	if(!isset($_SESSION['id'])){
		header("location: register.php?error=nologin");
	}
	
	echo json_encode($_POST);
	echo json_encode($_SESSION);
	
	$main =new Template("dtml/frame-public.html");
	
	populatePublicFrame($main);
	
	switch ($_POST['step']){
		case 1:
			$body=new Template("dtml/checkout-step1.html");
			break;
		case 2:
			$body=new Template("dtml/checkout-step2.html");
			
			$_SESSION['firstname']=$_POST['firstname'];
			$_SESSION['lastname']=$_POST['lastname'];
			$_SESSION['company']=$_POST['company'];
			$_SESSION['street']=$_POST['street'];
			$_SESSION['city']=$_POST['city'];
			$_SESSION['zip']=$_POST['zip'];
			$_SESSION['state']=$_POST['state'];
			$_SESSION['country']=$_POST['country'];
			$_SESSION['phone']=$_POST['phone'];
			$_SESSION['email']=$_POST['email'];
			
			break;
		case 3:
			$body=new Template("dtml/checkout-step3.html");
			break;
		case 4:
			$body=new Template("dtml/checkout-step4.html");
			
			$prods = getCartForUser($_SESSION['id']);
			
			$totalAmount = 0;
			
			while($data = $prods->fetch_assoc()){
				
				$body->setContent("itemId",$data['products_id']);
				$body->setContent("itemId2",$data['products_id']);
				
				$body->setContent("prodImage",$data['path']);
				
				$body->setContent("prodImageName",$data['name']);
				$body->setContent("prodName",$data['name']);
				
				if($data['saleprice']){
					$discount = $data['price']-$data['saleprice'];
					$total = $data['saleprice'] * $data['quantity'];
					
					$body->setContent("discount",$discount);
					
				}else{
					$total = $data['price'] * $data['quantity'];
					
					$body->setContent("discountAmount","");
					
				}
				$body->setContent("quantity",$data['quantity']);
				
				
				$body->setContent("price",$data['price']);
				$body->setContent("total",$total);
				
				$totalAmount+= $total;
				$counter += $data['quantity'];
				
				echo json_encode($data);
				
			}
			
			$body->setContent("totalPrice",$totalAmount);
			$body->setContent("totalPrice2",$totalAmount);
			
			break;
		default:
			break;
	}
	
	
	$main->setContent("body", $body->get());
	
	$main->close();
	
?>