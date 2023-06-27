<?php

require "include/template2.inc.php";

    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

    $main = new Template("dtml/index.html");
    $body = new Template("dtml/index2.html");

    $main->setContent("Placeholder", "Test");
    $main->setContent("body", $body->get());

    $main->close();
    //$body->close();


?>