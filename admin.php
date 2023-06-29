<?php
	
	require "include/template2.inc.php";
	require "include/auth.inc.php";
	require "include/dbservice.inc.php";
	
	$main = new Template("dtml/admin-fixed-sidebar.html");
	
	$tables = getTables();
	
	while ($data = $tables->fetch_assoc()){
		$main->setContent("table_link","admin.php?state=1&table=".$data['Tables_in_mydb']);
		$main->setContent("table",$data['Tables_in_mydb']);
	}
	
	switch ($_GET['state']){
		case 1:
			//handle CRUD body
			$body = new Template("dtml/datatable-card.html");
			
			$columns = getTableColumns($_GET['table']);
			
			$columns_arr = array();
			
			$i=0;
			
			while ($data = $columns->fetch_assoc()){
				$body->setContent("column",$data['COLUMN_NAME']);
				$columns_arr[$i]=$data['COLUMN_NAME'];
				$i++;
			}
			
			$rows = getTableData($_GET['table']);
			
			while ($data = $rows->fetch_assoc()){
				for($i=0;$i<count($columns_arr);$i++){
					if($i==0){
						$body->setContent("id",$data[$columns_arr[$i]]);
					}else{
						$body->setContent("row",$data[$columns_arr[$i]]);
					}
				}
			}
			
			
			
			
			$main->setContent("body",$body->get());
		break;
		
		default:
			break;
	}
	
	
	$main ->close();
	
?>