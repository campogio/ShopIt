<?php

require "include/template2.inc.php";
require "include/dbms.inc.php";


    $main = new Template("dtml/login.html");

    $main->setContent("title", "Login");

    if (isset($_REQUEST['error'])) {
    $body->setContent("message", "error");
    }

    $main->close();


?>