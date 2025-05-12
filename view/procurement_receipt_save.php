<?php
require_once '../backend/dbconnect.php';
$db = new db_connect();
$db->connect();
$conn = $db->conn;

if (isset($_GET['r_item_id']) && isset($_GET['r_finance_price'])) {
    $r_item_id = (int)$_GET['r_item_id'];
    $r_finance_price = (float)$_GET['r_finance_price'];

    $query = "UPDATE request_item SET r_finance_price = $r_finance_price WHERE r_item_id = $r_item_id";

    if (mysqli_query($conn, $query)) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "error";
}
