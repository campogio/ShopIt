<?php
	
	require "include/template2.inc.php";
	require "include/auth.inc.php";
	require "include/dbms.inc.php";
	
	$main = new Template("dtml/admin-fixed-sidebar.html");
	
	
	
	$main ->close();
	
?>