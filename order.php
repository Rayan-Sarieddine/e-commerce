<?php
header("Access-Control-Allow-Origin:*");
include("connection.php");

$id=$_POST["user_id"];
$product=$_POST["product_id"];

$check_query1 = $mysqli->prepare('SELECT * FROM products WHERE product_id = ?');
$check_query1->bind_param('i', $product);
$check_query1->execute();
$check_result1 = $check_query1->get_result();
$num_rows1 = $check_result1->num_rows;
$check_query2 = $mysqli->prepare('SELECT * FROM users WHERE user_id = ?');
$check_query2->bind_param('i', $id);
$check_query2->execute();
$check_result2 = $check_query2->get_result();
$num_rows2 = $check_result2->num_rows;
$response=[];
if($num_rows1> 0 and $num_rows2> 0){
  $query=$mysqli->prepare('INSERT INTO orders (user_id,product_id) VALUES(?,?)');
  $query->bind_param('ii', $id,$product);
  $query->execute();
  $response['success']=true;
  $response['message']= 'Order Added';
}
else{
  $response['success']=false;
  $response['message']= 'wrong id';
}
echo json_encode($response);
?>