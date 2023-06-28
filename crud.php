<?php
	
	require "include/template2.inc.php";
	
	$main = new Template("dtml/admin-fixed-sidebar.html");
	$body = new Template("dtml/datatable-card.html");
	
	$main->setContent("body",$body->get());
	$main ->close();

?>