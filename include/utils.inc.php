<?php
	
	function populatePublicFrame($template){
		
		//echo json_encode($_SESSION);
		//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
		
		if(isset($_SESSION['auth']['admin.php'])){
			$template->setContent("dashboard", "<a href='admin.php'>Administration Dashboard</a>");
		}else{
			$template->setContent("dashboard", "");
		}
		
		if(isset($_SESSION['auth']['sellItem.php'])){
			$template->setContent("itemSale", '<li class="nav-item dropdown menu-large"><a href="sellItem.php" >Sell an Item<b class="caret"></b></a>');
		}else{
			$template->setContent("itemSale", '');
		}
		
		if(isset($_SESSION['id'])){
			$template->setContent("isLogged",'<a href="logout.php" class="login-btn"><i class="fa fa-sign-in"></i><span class="d-none d-md-inline-block">Log Out</span></a><a href="orders.php" class="signup-btn"><i class="fa fa-user"></i><span class="d-none d-md-inline-block">Profile</span></a>');
		}else{
			$template->setContent("isLogged",'<a href="#" data-toggle="modal" data-target="#login-modal" class="login-btn"><i class="fa fa-sign-in"></i><span class="d-none d-md-inline-block">Sign In</span></a><a href="register.php" class="signup-btn"><i class="fa fa-user"></i><span class="d-none d-md-inline-block">Sign Up</span></a>');
		}
		
	}
	
?>