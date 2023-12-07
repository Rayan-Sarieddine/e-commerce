<?php
header("Access-Control-Allow-origin:*");
include ("connection.php");

require __DIR__ ."/vendor/autoload.php";

use Firebase\JWT\JWT;

$email=$_POST['user_email'];
$password=$_POST['user_password'];
$query=$mysqli->prepare('SELECT user_id,user_name,user_role,user_password FROM users WHERE user_email=?');
$query->bind_param('s',$email);
$query->execute();
$query->store_result();
$num_rows=$query->num_rows;
$query->bind_result($id,$name,$user_role,$hashed_password);
$query->fetch();

$response=[];

if($num_rows> 0){ 
  if(password_verify($password,$hashed_password)){
    $key = "rayan1234";
    $payload_array = [];
    $payload_array["user_id"] = $id;
    $payload_array["user_name"] = $name;
    $payload_array["user_role"] = $user_role;
    $payload_array["exp"] = time() + 3600;
    $payload = $payload_array;
    $response['status'] = 'logged in';
    $jwt = JWT::encode($payload, $key, 'HS256');
    $response['jwt'] = $jwt;
    echo json_encode($response);
   }
    else{
      $response['success']=false;
      $response['message']= 'wrong credentials';
      echo json_encode($response);
    }
  }
  else{
    $response['success']=false;
    $response['message']= 'wrong email';
    echo json_encode($response);
  }
  
?>