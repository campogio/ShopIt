<?php
	
	require "include/template2.inc.php";
	require "include/auth.inc.php";
	require "include/dbservice.inc.php";
	require "include/utils.inc.php";
	
	//echo "Hello";
	
	echo json_encode($_POST);
	
	$main = new Template("dtml/frame-public.html");
	
	$body = new Template("dtml/sell-item.html");
	
	$sellerId=1;
	
	$uploadDir=__DIR__.DIRECTORY_SEPARATOR."dtml".DIRECTORY_SEPARATOR."img".DIRECTORY_SEPARATOR.$sellerId;
	
	if(!file_exists($uploadDir)){
		mkdir($uploadDir,0777,true);
	}
	
	
	function isFormValid(){
		
		global $uploadDir;
		global $sellerId;
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
		
		foreach ($_FILES as $file) {
			if (UPLOAD_ERR_OK === $file['error']) {
				$fileName = basename($file['name']);
				$fileParts = pathinfo($file['name']);
				
				$newName=uniqid($sellerId."-Image");
				
				if(getimagesize($file['tmp_name'])){
					echo "IS FILE";
					echo json_encode($file);
					move_uploaded_file($file['tmp_name'], $uploadDir.DIRECTORY_SEPARATOR.$newName.".".$fileParts['extension']);
				}
			}
		}
		
		return true;
		
	}
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if(isFormValid()) {
			$body->setContent("alertBox","");
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