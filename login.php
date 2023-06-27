<?php

    require "include/template2.inc.php";
    require "include/dbms.inc.php"; //Fix

    $main = new Template("dtml/frame-public.html");


    echo $_POST['email'];

    $main->close();

?>