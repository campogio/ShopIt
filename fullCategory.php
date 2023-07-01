<?php
	
	require "include/template2.inc.php";
	
	ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
	
	
	session_start();
	
	$main = new Template("dtml/frame-public.html");
	$body = new Template("dtml/shop-category.html");
	
	
	$body->setContent("categoryHeader",$_GET['category']);
	$body->setContent("categoryBreadcrumb",$_GET['category']);
	
	$body->setContent("productName","Hello First");
	$body->setContent("productName","Hello Second");
	
	
	
	if(isset($_SESSION['auth']['admin.php'])){
		$main->setContent("dashboard", "<a href='admin.php'>Administration Dashboard</a>");
	}
	
	$main->setContent("body",$body->get());
	
	$main->close();
	
?>