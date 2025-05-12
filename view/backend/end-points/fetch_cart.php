<?php 
include('../class.php');

$db = new global_class();

session_start();
$id = intval($_SESSION['id']);

$fetch_all_cart = $db->fetch_all_cart($id);

echo json_encode($fetch_all_cart);
?>