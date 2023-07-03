<?php
	
	require "include/template2.inc.php";
	require "include/auth.inc.php";
	require "include/dbservice.inc.php";
	require "include/utils.inc.php";
	
	session_start();
	
	//echo "Hello";
	ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
	
	$main = new Template("dtml/frame-public.html");
	
	$body = new Template("dtml/sell-item.html");
	
	$sellerId=1;
	
	$uploadDir="dtml"."/"."img"."/".$sellerId;
	$files = array();
	
	
	if(!file_exists($uploadDir)){
		mkdir($uploadDir,0777,true);
	}
	
	
	function isFormValid(){
		
		global $uploadDir;
		global $sellerId;
		global $files;
		
		if(!preg_match('#^[a-z0-9\s]+$#i',$_POST['name'])){
			echo "wrong name";
			return false;
			
		}
		
		if(!is_numeric($_POST['price'])){
			echo "wrong price";
			return false;
			
		}
		
		if(isset($_POST['salePrice'])){
			if(!is_numeric($_POST['salePrice']) OR $_POST['salePrice']==''){
				echo "wrong sale";
				return false;
				
			}
		}
		
		if(!is_numeric($_POST['category'])){
			echo "wrong cat";
			return false;
			
		}
		
		if(!is_numeric($_POST['brand'])){
			echo "wrong brand";
			return false;
			
		}
		
		$index = 0;
		for($i =0;$_FILES['images']['name'][$i] != NULL;$i++){
			$files[] = array($_FILES['images']['name'][$i], $_FILES['images']['type'][$i],
				$_FILES['images']['tmp_name'][$i], $_FILES['images']['size'][$i],$_FILES['images']['error'][$i]);
		}
		
		if(UPLOAD_ERR_OK === $_FILES['showcase']['error']){
			if(getimagesize($_FILES['showcase']['tmp_name'])){
				echo "IS FILE";
			}else{
				return false;
			}
		}
		
		
		foreach ($files as $file) {
			
			if (UPLOAD_ERR_OK === $file[4]) {
				if(getimagesize($file[2])){
					echo "IS FILE";
				}else{
					return false;
				}
			}
		}
		
		/*foreach ($files as $file) {
			if (UPLOAD_ERR_OK === $file[4]) {
				if(getimagesize($file['tmp_name'])){
					echo "IS FILE";
					echo json_encode($file);
				}
			}
		}*/
		
		return true;
		
	}
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if(isFormValid()) {
			//TODO ADD RICH TEXT FOR DESC
			
			$fileName = basename($_FILES['showcase']['name']);
			$fileParts = pathinfo($_FILES['showcase']['name']);
			
			$newName=uniqid($sellerId."-Image");
			move_uploaded_file($_FILES['showcase']['tmp_name'], __DIR__."/".$uploadDir."/".$newName.".".$fileParts['extension']);
			
			$showcaseId= insertImage($uploadDir."/".$newName.".".$fileParts['extension']);
			
			$imageIds = array();
			
			foreach ($files as $file) {
				if (UPLOAD_ERR_OK === $file[4]) {
					$fileName = basename($file[0]);
					$fileParts = pathinfo($file[0]);
					
					$newName=uniqid($sellerId."-Image");
					
					if(getimagesize($file[2])){
						echo "IS FILE";
						echo json_encode($file);
						move_uploaded_file($file[2], $uploadDir.DIRECTORY_SEPARATOR.$newName.".".$fileParts['extension']);
						
						array_push($imageIds,insertImage($uploadDir."/".$newName.".".$fileParts['extension']));
						
					}
				}
			}
			
			insertProduct($_SESSION['id'],$_POST['name'],$_POST['price'],$_POST['saleprice'],$_POST['brand'],$_POST['category'],$showcaseId,$imageIds);
			
			$body->setContent("alertBox","Added");
		}else{
			$body->setContent("alertBox",'<div role="alert" class="alert alert-danger alert-dismissible">
        <button type="button" data-dismiss="alert" class="close"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>Some fields were not filled correctly.
    	</div>');
		}
		
	}
	
	$categories = getTableData("category");
	
	while ($data = $categories->fetch_assoc()){
		
		$body->setContent("categoryValue",$data['id']);
		$body->setContent("category",$data['name']);
		
	}
	
	$brands = getTableData("brand");
	
	while ($data = $brands->fetch_assoc()){
		
		$body->setContent("brandValue",$data['id']);
		$body->setContent("brand",$data['name']);
		
	}
	
	$main->setContent("body", $body->get());
	
	populatePublicFrame($main);
	
	$main->close();
	
?>