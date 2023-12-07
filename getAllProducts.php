<?php
header("Access-Control-Allow-origin:*");
include ("connection.php");



$query=$mysqli->prepare('SELECT * FROM products');
$query->execute();
$result=$query->get_result();
$response=[];


if($result->num_rows > 0){

  while($row=$result->fetch_assoc()){
    $products[]=$row;
  }

  $response['Successs']=true;
  $response['message']='Products info received';
  $response['products']=$products;

}
else{
  $response['Successs']=false;
  $response['message']=' no Products not found';
  
}
echo json_encode($response);







?>