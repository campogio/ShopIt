<?php

require "include/template2.inc.php";
    


    $main = new Template("dtml/index.html");


    $main->setContent("Placeholder", "Test");

    $main->close();


?>