<?php

    require "dbms.inc.php";
    
    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    
    
    function getTables(){
        
        global $mysqli;
        $result= $mysqli->query("SHOW TABLES");
        return $result;
        
    }
    
    function getTableColumns($table){
        
        global $mysqli;
        $stmt = $mysqli->prepare("SELECT COLUMN_NAME
                                        FROM INFORMATION_SCHEMA.COLUMNS
                                        WHERE TABLE_SCHEMA = 'mydb' AND TABLE_NAME = ?;");
        
        $stmt->bind_param("s",$table);
        
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        return $result;
        
    }
    
    function getTableData($table){
        
        //Needs a whitelist of tables to make sure of no SQL Injections, it's not possible to parametrize a table name
        
        global $mysqli;
        $result = $mysqli->query("SELECT * FROM ".$table);
        return $result;
        
    }

    function getUser($mysqli,$user,$pass){

    $stmt = $mysqli->prepare("SELECT * FROM user WHERE username = ? AND password = ?");

    /* bind parameters for markers */
    $stmt->bind_param("ss",$user, $pass);

    /* execute query */
    $stmt->execute();

    $result = $stmt->get_result();

    return $result;
}


?>
