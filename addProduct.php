<?php
header("Access-Control-Allow-Origin:*");
include("connection.php");
// require 'vendor/autoload.php'; 

// use Picqer\Barcode\BarcodeGenerator;
// use Picqer\Barcode\BarcodeGeneratorPNG;

// $generator = new BarcodeGeneratorPNG(); 
require_once 'tokenCheck.php'; 
$decodedToken = authenticateJWT();

if ($decodedToken->user_role !== 'admin') {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized access"]);
    exit();
}

$name=$_POST['product_name'];
$barcode=$_POST['product_barcode'];
// $barcode_img = $generator->getBarcode($barcode, $generator::TYPE_EAN_13);
$price=$_POST['product_price'];

$query=$mysqli->prepare('INSERT INTO products(product_name,product_barcode,product_price) VALUES(?, ?, ?)');
$query->bind_param('sii',$name, $barcode, $price);

$response=[];

if ($query->execute()) {
  $response["success"] = true;
} else {
  $response["success"] = false;
}

echo json_encode($response);

?>