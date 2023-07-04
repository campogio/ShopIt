<?php
	
	//include "include/auth.inc.php";
	require "include/dbservice.inc.php";
	
	session_start();
	
	echo json_encode($_POST);
	
	if(isset($_POST['cart'])){
		echo "carting item";
		
		addToCart($_POST['cart'],$_SESSION['id'],$_POST['quantity']);
		
		unset($_POST);
		
		header("Location: cart.php");
		
	}elseif (isset($_POST['wishlist'])){
		echo "wishlisting item";
		
		unset($_POST);
	}
	
?>