<?php  
header("Access-Control-Allow-Origin:*");
include("connection.php");


$barcode=$_POST['product_barcode'];
$param=$_POST['param'];
$value=$_POST['value'];

if($param=="product_barcode" or $param=="product_name" or $param=="product_price"){

$check_query = $mysqli->prepare('SELECT * FROM products WHERE product_barcode = ?');
$check_query->bind_param('i', $barcode);
$check_query->execute();
$check_result = $check_query->get_result();
$num_rows = $check_result->num_rows;
$response=[];
if($num_rows> 0){
  $query=$mysqli->prepare("UPDATE products SET $param=? Where product_barcode=?");
  $query->bind_param('si',$value,$barcode);
  
  if($query->execute()){
  $response['success']=true;
  $response['msg']= 'Product updated';
  } else{ 
    $response['success']=false;
    $response['msg']= 'Falied to update product';
  
  }
}
else{

  $response['success']=false;
  $response['msg']= 'product does not exist';
}

}

echo json_encode($response);
?>