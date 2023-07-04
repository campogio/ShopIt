<?php
	
	require "include/template2.inc.php";
	require "include/dbservice.inc.php";
	require "include/utils.inc.php";
	
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
		
		postOrder($_SESSION['id'],$orderInfo,$products,$_POST['totalPrice']);
		
		unset($_POST);
	
	}
	
	$main = new Template("dtml/frame-public.html");
	
	populatePublicFrame($main);
	
	$orders=getUserOrders($_SESSION['id']);
	
	$body = new Template("dtml/user-orders.html");
	
	while ($data = $orders->fetch_assoc()){
		$body->setContent("orderNumber",$data['order_id']);
		$body->setContent("orderId",$data['order_id']);
		$body->setContent("orderDate",$data['date']);
		$body->setContent("orderTotal",$data['total']);
		
		switch ($data['orderState']){
			case 0:
				$body->setContent("orderState",'<span class="badge badge-info">Being prepared</span>');
				break;
			case 1:
				$body->setContent("orderState",'<span class="badge badge-success">Received</span>');
				break;
			case 2:
				$body->setContent("orderState",'<span class="badge badge-danger">Cancelled</span>');
				break;
			case 3:
				$body->setContent("orderState",'<span class="badge badge-warning">On hold</span>');
				break;
			default:
				break;
		
		}
		
	}
	
	
	
	
	
	$main->setContent("body",$body->get());
	
	$main->close();
	
?>