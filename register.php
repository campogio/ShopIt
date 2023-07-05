<?php
	
	require "include/template2.inc.php";
	require "include/utils.inc.php";
	require "include/dbservice.inc.php";
	
	session_start();
	
	$main = new Template("dtml/frame-public.html");
	
	$body = new Template("dtml/user-register.html");
	
	
	
	
	$main->setContent("body",$body->get());
	
	populatePublicFrame($main);
	
	$main->close();
	
?>