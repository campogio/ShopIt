<?php
	
	require "include/template2.inc.php";
	require "include/auth.inc.php";
	require "include/dbservice.inc.php";
	
	$main = new Template("dtml/admin-fixed-sidebar.html");
	
	$tables = getTables();
	
	while ($data = $tables->fetch_assoc()){
		$main->setContent("table_name","admin.php?".$data['Tables_in_mydb']);
		$main->setContent("table",$data['Tables_in_mydb']);
	}
	
	
	$main ->close();
	
?>