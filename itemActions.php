<?php
	
	require "include/dbservice.inc.php";
	
	session_start();
	
	if(isset($_SESSION['id'])){
		if(isset($_POST['cart'])){
			//echo "carting item";
			
			addToCart($_POST['cart'],$_SESSION['id'],$_POST['quantity']);
			
			unset($_POST);
			
			header("Location: cart.php");
			
		}elseif (isset($_POST['wishlist'])){
			//echo "wishlisting item";
			
			addToWishlist($_POST['wishlist'],$_SESSION['id']);
			
			unset($_POST);
		}elseif (isset($_POST['unwishlist'])){
			
			removeFromWishlist($_POST['unwishlist'],$_SESSION['id']);
			
		}
	}else{
		header("location: register.php");
	}
	
	//echo json_encode($_POST);
	
	
	
?>