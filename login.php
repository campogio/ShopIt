<?php
	
	require "include/template2.inc.php";
	require "include/dbms.inc.php";
	require "include/dbservice.inc.php";
	require "include/auth.inc.php";
	
	
	Header("Location: index.php");
	
	/*$username = $_POST['email'];

	$password = $_POST['password'];

	$result =getUser($mysqli,$username,$password);

	while ($data = $result->fetch_assoc()){

    echo "iduser:",$data['iduser'];

	} */


?>