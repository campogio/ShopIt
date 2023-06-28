<?php
	
	require "include/template2.inc.php";
	
	$main = new Template("dtml/admin-fixed-sidebar.html");
	$body = new Template("dtml/datatable-card.html");
	
	$body->setContent("column","id");
	$body->setContent("column","Bib");
	
	
	$body->setContent("id","0");
	$body->setContent("row","Test");
	
	$body->setContent("id","1");
	$body->setContent("row","Test2");
	
	$body->setContent("id","2");
	$body->setContent("row","Test3");
	
	
	
	
	$main->setContent("body",$body->get());
	$main ->close();

?>