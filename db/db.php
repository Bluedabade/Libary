<?php
$hostname = "localhost";
$username = "root";
$pass = "";
$db_name = "db_libary";

$conn = new mysqli($hostname, $username, $pass, $db_name);
$conn -> set_charset("utf8");
date_default_timezone_set("Asia/Bangkok");
?>