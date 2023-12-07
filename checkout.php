<?php
header("Access-Control-Allow-Origin:*");
include("connection.php");

$id=$_POST["user_id"];


$check_query1 = $mysqli->prepare('SELECT * FROM users WHERE user_id = ?');
$check_query1->bind_param('i', $id);
$check_query1->execute();
$check_result1 = $check_query1->get_result();
$num_rows1 = $check_result1->num_rows;
$response=[];
if($num_rows1> 0){
  $query=$mysqli->prepare('SELECT * from orders WHERE user_id=?');
  $query->bind_param('i', $id);
  $query->execute();
  $result=$query->get_result();
  if($result->num_rows > 0){

    while($row=$result->fetch_assoc()){
      $orders[]=$row;
    }
  }else{
    $response['success']=false;
    $response['message']= 'user has no orders';
  }
}
else{
  $response['success']=false;
  $response['message']= 'user not found';
}
echo json_encode($response);
?>