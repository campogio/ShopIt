<?php
	
	require "include/dbservice.inc.php";
	
	if(isset($_GET['tags'])){
		getCategoryTags();
	}
	
	function getCategoryTags(){
		header('Content-Type: application/json; charset=utf-8');
		$tags = array();
		$tags = [];
		
		$temp= getTagsByCategory($_GET['tags']);
		
		while($data = $temp->fetch_assoc()){
			array_push($tags,['id'=>$data['id'],'name' =>$data['name']]);
		}
		
		echo json_encode($tags);
		exit();
	}

?>