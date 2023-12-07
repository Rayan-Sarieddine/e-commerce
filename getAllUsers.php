<?php
header("Access-Control-Allow-origin:*");
include ("connection.php");



$query=$mysqli->prepare('SELECT user_name, user_role, user_email FROM users WHERE user_role="customer"');
$query->execute();
$result=$query->get_result();
$response=[];


if($result->num_rows > 0){

  while($row=$result->fetch_assoc()){
    $users[]=$row;
  }

  $response['Successs']=true;
  $response['message']='users info received';
  $response['users']=$users;

}
else{
  $response['Successs']=false;
  $response['message']=' no users not found';
  
}
echo json_encode($response);







?>