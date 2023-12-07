<?php
header("Access-Control-Allow-origin:*");
include ("connection.php");

$barcode=$_POST['product_barcode'];

$query=$mysqli->prepare('SELECT * FROM products WHERE product_barcode=?');
$query->bind_param('i',$barcode);
$query->execute();
$result=$query->get_result();
$response=[];

if($result->num_rows > 0){

  $array=$result->fetch_assoc();

  $response['Successs']=true;
  $response['message']='Product info received';
  $response['product_info']=$array;

}
else{
  $response['Successs']=false;
  $response['message']='Product not found';
  
}
echo json_encode($response);







?>