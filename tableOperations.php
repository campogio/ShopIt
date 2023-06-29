<?php

	require "include/dbservice.inc.php";
	
	echo json_encode($_POST);
	
	
	
	if(isset($_POST['tableName'])){
		
		$table = $_POST['tableName'];
		unset($_POST['tableName']);
		
		if(isset($_POST['create'])){
			
			unset($_POST['create']);
			
			$columns = array();
			$params = array();
			
			foreach($_POST as $key=>$value)
			{
				array_push($columns,$key);
				array_push($params, $value);
			}
			
			insertTableData($table,$columns,$params);
		}elseif (isset($_POST['delete'])){
			
			unset($_POST['delete']);
			
			$columns = array();
			$params = array();
			
			foreach($_POST as $key=>$value)
			{
				array_push($columns,$key);
				array_push($params, $value);
			}
			
			removeTableData($table,$columns,$params);
		}
		
	}
	
	unset($_POST);
	
	header('location: admin.php?state=1&table='.$table);

?>