<?php
	
	function populatePublicFrame($template){
		
		//echo json_encode($_SESSION);
		ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
		
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
		
	}
	
?>