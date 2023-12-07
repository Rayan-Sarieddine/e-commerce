<?php
header("Access-Control-Allow-origin:*");
include ("connection.php");
$email=$_POST['user_email'];
$password=$_POST['user_password'];
$query=$mysqli->prepare('SELECT user_id,user_name,user_password FROM users WHERE user_email=?');
$query->bind_param('s',$email);
$query->execute();
$query->store_result();
$num_rows=$query->num_rows;
$query->bind_result($id,$name,$hashed_password);
$query->fetch();

$response=[];

if($num_rows> 0){ 
  if(password_verify($password,$hashed_password)){
    $response['success']=true;
    $response['message']= 'Logged in';
    $response['user_id']= $id;
    $response['user_name']=$name;
   }
    else{
      $response['success']=false;
      $response['message']= 'wrong credentials';
    }
  }
  else{
    $response['success']=false;
    $response['message']= 'wrong email';
  }
  echo json_encode($response);
?>