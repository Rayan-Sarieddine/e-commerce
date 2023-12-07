<?php
header("Access-Control-Allow-origin:*");
include ("connection.php");
$email=$_POST['user_email'];
$password=$_POST['user_password'];
$hashed_password=password_hash($password,PASSWORD_DEFAULT);
$name=$_POST['user_name'];
$role=$_POST['user_role'];

$query = $mysqli->prepare('INSERT INTO users (user_name, user_email, user_password, user_role) VALUES (?, ?, ?, ?)');
$query->bind_param("ssss",$name,$email,$hashed_password,$role);
$query->execute();

$response=[];

if ($query->execute()) {
  $response["success"] = true;
} else {
  $response["success"] = false;
}

echo json_encode($response);
?>