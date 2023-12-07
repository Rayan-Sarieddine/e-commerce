<?php
header("Access-Control-Allow-Origin:*");
include("connection.php");

$id=$_POST["user_id"];

//check if user exists
$check_query1 = $mysqli->prepare('SELECT * FROM users WHERE user_id = ?');
$check_query1->bind_param('i', $id);
$check_query1->execute();
$check_result1 = $check_query1->get_result();
$num_rows1 = $check_result1->num_rows;

//resp message
$response=[];
if($num_rows1> 0){
  //get each order in the cart details
  $query = $mysqli->prepare('
        SELECT c.order_id, o.product_id, p.product_name, p.product_price, o.product_amount
        FROM cart c
        INNER JOIN orders o ON c.order_id = o.order_id
        INNER JOIN products p ON o.product_id = p.product_id
        WHERE c.user_id = ? AND c.active_cart="no"
    ');
    $query->bind_param('i', $id);
    $query->execute();
    $result = $query->get_result();

    $totalCartPrice = 0;

    if ($result->num_rows > 0) {
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $totalPrice = $row['product_price'] * $row['product_amount'];
            $totalCartPrice += $totalPrice;

            $productDetails = [
                'product_name' => $row['product_name'],
                'total_amount' => $row['product_amount'],
                'total_price' => $totalPrice
            ];

            $products[] = $productDetails;
        }

        $response['success'] = true;
        $response['message'] = 'order history retrieved';
        $response['products'] = $products;
        $response['orders_total'] = $totalCartPrice;
    } else {
        $response['success'] = false;
        $response['message'] = 'User has no order history';
    }
}
else{
  $response['success']=false;
  $response['message']= 'user not found';
}
echo json_encode($response);
?>