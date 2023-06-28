<?php

    require "dbms.inc.php";
    
    function getTables(){
        
        global $mysqli;
        $result= $mysqli->query("SHOW TABLES");
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
