<?php  
header("Access-Control-Allow-Origin:*");
include("connection.php");


if ($decodedToken->user_role !== 'admin') {
  http_response_code(403);
  echo json_encode(["error" => "Unauthorized access"]);
  exit();
}

$barcode=$_POST['product_barcode'];

$check_query = $mysqli->prepare('SELECT * FROM products WHERE product_barcode = ?');
$check_query->bind_param('i', $barcode);
$check_query->execute();
$check_result = $check_query->get_result();
$num_rows = $check_result->num_rows;
$response=[];
if($num_rows> 0){
  $query=$mysqli->prepare('Delete FROM products Where product_barcode=?');
  $query->bind_param('i',$barcode);
  
  if($query->execute()){
  $response['success']=true;
  $response['msg']= 'Product deleted';
  } else{ 
    $response['success']=false;
    $response['msg']= 'Falied to delete product';
  
  }
}
else{

  $response['success']=false;
  $response['msg']= 'product does not exist';
}



echo json_encode($response);
?>