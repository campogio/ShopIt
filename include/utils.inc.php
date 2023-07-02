<?php
	
	function populatePublicFrame($template){
		
		echo json_encode($_SESSION);
		
		if(isset($_SESSION['auth']['admin.php'])){
			$template->setContent("dashboard", "<a href='admin.php'>Administration Dashboard</a>");
		}else{
			$template->setContent("dashboard", "");
		}
		
		if(isset($_SESSION['auth']['sellItem.php'])){
			$template->setContent("itemSale", '<li class="nav-item dropdown menu-large"><a href="sellItem.php" >Test<b class="caret"></b></a>');
		}else{
			$template->setContent("itemSale", '');
		}
		
	}
	
?>