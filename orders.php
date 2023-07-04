<?php
	
	require "include/template2.inc.php";
	require "include/dbservice.inc.php";
	
	session_start();
	
	if(isset($_POST['postOrder'])){
		
		$orderInfo = array();
		
		$orderInfo['firstname']=$_SESSION['firstname'];
		$orderInfo['lastname']=$_SESSION['lastname'];
		$orderInfo['street']=$_SESSION['street'];
		$orderInfo['city']=$_SESSION['city'];
		$orderInfo['zip']=$_SESSION['zip'];
		$orderInfo['state']=$_SESSION['state'];
		$orderInfo['phone']=$_SESSION['phone'];
		$orderInfo['email']=$_SESSION['email'];
		
		$products = getCartForUser($_SESSION['id']);
		
		postOrder($_SESSION['id'],$orderInfo,$products);
	
	}
	
	$main = new Template("dtml/frame-public.html");
	
	$body = new Template("dtml/user-orders.html");
	
	
	
	
	
	$main->setContent("body",$body->get());
	
	$main->close();
	
?>