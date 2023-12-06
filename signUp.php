<?php
header("Access-Control-Allow-origin:*");
include ("connection.php");
$email=$_POST['user_email'];
$password=$_POST['user_password'];
$hashed_password=password_hash($password,PASSWORD_DEFAULT);
$name=$_POST['user_name'];
$role=$_POST['user_role'];

$quer

?>