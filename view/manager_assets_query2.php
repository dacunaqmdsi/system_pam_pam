<?php
include('../connection_short.php');

// Get the current maximum ID from the assets table
$result = mysqli_query($conn, "SELECT MAX(id) AS max_id FROM assets_item");
$row = mysqli_fetch_assoc($result);
$nextId = isset($row['max_id']) ? $row['max_id'] + 1 : 1;

// Return the ID as JSON
echo json_encode(['next_id' => $nextId]);
?>
