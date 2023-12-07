<?php
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Methods: GET ,POST");
header("Access-Control-Allow-Headers:*");
$host='localhost';
$db_user='root';
$db_pass='';
$dbname='e-commerce';
$mysqli = new mysqli($host, $db_user, $db_pass, $dbname);


if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
  }
    
?>