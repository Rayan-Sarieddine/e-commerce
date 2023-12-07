<?php
header("Access-Control-Allow-origin:*");
include ("connection.php");

$email=$_POST['user_email'];

$query=$mysqli->prepare('SELECT user_name, user_role, user_email FROM users WHERE user_email=?');
$query->bind_param('i',$email);
$query->execute();
$result=$query->get_result();
$response=[];

if($result->num_rows > 0){

  $array=$result->fetch_assoc();

  $response['Successs']=true;
  $response['message']='User info received';
  $response['product_info']=$array;

}
else{
  $response['Successs']=false;
  $response['message']='User not found';
  
}
echo json_encode($response);







?>