<?php

	require "include/template2.inc.php";
	require "include/auth.inc.php";


	session_start();
	
	echo json_encode($_SESSION);
	
	ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

    $main = new Template("dtml/frame-public.html");
    $body = new Template("dtml/shop-home.html");
	
	
	if(isset($_SESSION['auth']['admin.php'])){
		$main->setContent("dashboard", "<a href='admin.php'>Administration Dashboard</a>");
	}
    $main->setContent("body", $body->get());

    $main->close();


?>