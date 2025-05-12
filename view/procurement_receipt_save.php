<?php
header('Content-Type: application/json');

require_once '../backend/dbconnect.php';
$db = new db_connect();
$db->connect();
$conn = $db->conn;

$response = [];

if (isset($_GET['r_item_id']) && isset($_GET['price'])) {
    $r_item_id = (int)$_GET['r_item_id'];
    $price = (float)$_GET['price'];

    $query = "UPDATE request_item SET r_finance_price = $price WHERE r_item_id = $r_item_id";

    if (mysqli_query($conn, $query)) {
        $response = ['status' => 'success', 'message' => 'Price updated successfully!'];
    } else {
        $response = ['status' => 'error', 'message' => 'Failed to update price.'];
    }
} else {
    $response = ['status' => 'error', 'message' => 'Missing parameters.'];
}

echo json_encode($response);

// require_once '../backend/dbconnect.php';
// $db = new db_connect();
// $db->connect();
// $conn = $db->conn;

// if (isset($_GET['r_item_id']) && isset($_GET['price'])) {
//     $r_item_id = (int)$_GET['r_item_id'];
//     //$r_finance_price = (float)$_GET['r_finance_price'];
//     $price = (float)$_GET['price'];

//     $query = "UPDATE request_item SET r_finance_price = $price WHERE r_item_id = $r_item_id";

//     if (mysqli_query($conn, $query)) {
//         //echo "success";
//         echo '<script>alertify.success("Success")</script>';
//     } else {
//         echo "error";
//     }
// } else {
//     echo "error";
// }
