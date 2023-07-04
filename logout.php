<?php

session_start();

$_SESSION = [];

unset($_SESSION);

Header("Location: index.php");

?>