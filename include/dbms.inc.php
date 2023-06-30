<?php

	
	
    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

	$mysqli = new mysqli("localhost", "root",password: "password", database:"mydb");

    if ($mysqli->connect_error) {
        echo "Not connected to DB, error: " . $mysqli->connect_error;
    }
    //else {
    //    echo "Connected.";
    //

?>