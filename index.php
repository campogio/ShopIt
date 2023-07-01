<?php

	require "include/template2.inc.php";
	require "include/auth.inc.php";
	require "include/dbservice.inc.php";


	session_start();
	
	//echo json_encode($_SESSION);
	
	//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

    $main = new Template("dtml/frame-public.html");
    $body = new Template("dtml/shop-home.html");
	
	$categories = getTableData("category")->fetch_all();
	
	$products_arr = array();
	
	for($k=0;$k<3;$k++){
		
		$body->setContent("category_href", $categories[$k][1]);
		$body->setContent("category", $categories[$k][1]);
		
		for($i=0;$i<3;$i++){
			
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