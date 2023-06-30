<?php

	require "include/template2.inc.php";
	require "include/auth.inc.php";


	session_start();
	
	echo json_encode($_SESSION);
	
	ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

    $main = new Template("dtml/frame-public.html");
    $body = new Template("dtml/shop-home.html");
	$product = new Template("dtml/product.html");
	
	
	for($k=0;$k<3;$k++){
		
		$body->setContent("category", "Category ".$k);
		
		for($i=0;$i<3;$i++){
			
			echo $i;
			
			$body->setContent("productName","Product ".$i);
			$body->setContent("productPrice", $i);
			
			//Item is on sale?
			if(true){
				$body->setContent("saleRibbon",'<div class="ribbon sale">SALE</div>');
			}
			//Item is new?
			if(true){
				$body->setContent("newRibbon",'<div class="ribbon new">NEW</div>');
			}
			
		}
		
	}
	
	
	
	
	
	if(isset($_SESSION['auth']['admin.php'])){
		$main->setContent("dashboard", "<a href='admin.php'>Administration Dashboard</a>");
	}
    $main->setContent("body", $body->get());
    $main->close();


?>