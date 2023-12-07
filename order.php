<?php
header("Access-Control-Allow-Origin:*");
include("connection.php");

require_once 'tokenCheck.php'; 
$decodedToken = authenticateJWT();

if ($decodedToken->user_role !== 'customer') {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized access"]);
    exit();
}




$id=$_POST["user_id"];
$product=$_POST["product_id"];
$product_amount=$_POST['product_amount']; //how many of the product user got


//check if product exist
$check_query1 = $mysqli->prepare('SELECT * FROM products WHERE product_id = ?');
$check_query1->bind_param('i', $product);
$check_query1->execute();
$check_result1 = $check_query1->get_result();
$num_rows1 = $check_result1->num_rows;
//check if user exist
$check_query2 = $mysqli->prepare('SELECT * FROM users WHERE user_id = ?');
$check_query2->bind_param('i', $id);
$check_query2->execute();
$check_result2 = $check_query2->get_result();
$num_rows2 = $check_result2->num_rows;

$response=[];


if($num_rows1> 0 and $num_rows2> 0){
  //insert order to order table
  $query1=$mysqli->prepare('INSERT INTO orders (user_id,product_id,product_amount) VALUES(?,?,?)');
  $query1->bind_param('iii', $id,$product,$product_amount);
  $query1->execute();

  //select the order id
  $query2=$mysqli->prepare('SELECT order_id FROM orders WHERE user_id=? AND product_id=? AND product_amount=?');
  $query2->bind_param('iii', $id,$product,$product_amount);
  $query2->execute();
  $result=$query2->get_result();
  if($result->num_rows > 0){
    $orderArray=[];
    while($row=$result->fetch_assoc()){
     
      $orderArray[]=$row['order_id'];
    }
  }
  foreach ($orderArray as $order_id) {
    $query = $mysqli->prepare('INSERT INTO cart (user_id, order_id) VALUES (?, ?)');
    $query->bind_param('ii', $id, $order_id);
    $query->execute();
}
  $response['success']=true;
  $response['message']= 'Order Added';
}
else{
  $response['success']=false;
  $response['message']= 'wrong id';
}
echo json_encode($response);
?>