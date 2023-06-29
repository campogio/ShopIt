<?php

    require "dbms.inc.php";
    
    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    
    
    function exists($table,$columns,$params){
        
        global $mysqli;
        
        $sql = "SELECT * FROM $table WHERE ";
        
        if($columns[0]=="id"){
            $sql = $sql . "id = " . $params[0];
            
            $result = $mysqli ->query($sql);
            
            if($result->num_rows>0){
                return true;
            }else{
                return false;
            }
            
        }else{
            return false;
        }
        
    }
    
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
    
    function removeTableData($table,$columns,$params){
        
        global $mysqli;
        
        $sql = "DELETE FROM $table WHERE ";
        
        for($i=0;$i<count($columns);$i++){
            
            if(($i+1) == count($columns)){
                $sql = $sql . $columns[$i] . " = ?";
            }else{
                $sql = $sql . $columns[$i] . " = ? AND ";
            }
        }
        
        echo $sql;
        
        $mysqli->prepare($sql);
        
        $result = $mysqli->execute_query($sql,$params);
        
        return $result;
        
    }
    
    function insertTableData($table,$columns,$params){
        
        global $mysqli;
        
        if(exists($table,$columns,$params)){
            $sql = "UPDATE $table SET "; // sql
            
            
            //Starting from 1 cause ID can't be changed
            for($i=1;$i<count($columns);$i++){
                $sql = $sql . $columns[$i] . " = '" . $params[$i] . "',";
            }
            
            $sql= rtrim($sql,",");
            
            $sql = $sql . " WHERE id = " . $params[0];
            
            $result = $mysqli->execute_query($sql);
            
        }else{
            $parameters = str_repeat('?,', count($params) - 1) . '?';
            $sql = "INSERT INTO $table("; // sql
            
            foreach ($columns as $col){
                $sql= $sql . $col . ",";
            }
            
            $sql= rtrim($sql,",");
            
            $sql= $sql . " ) VALUES($parameters)";
            
            $result = $mysqli->execute_query($sql,$params);
        }
        
        echo $sql;
        
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
