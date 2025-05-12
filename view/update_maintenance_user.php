<?php
// $conn = mysqli_connect("localhost", "u680385054_procurement", "@Mk5^vnVJ", "u680385054_pro");
$conn = mysqli_connect("localhost", "root", "", "pam");

// include('../connection_short.php');


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['status']) && isset($_POST['user_id'])) {
    $user_id = (int)$_POST['user_id'];

    foreach ($_POST['status'] as $user_module_id => $is_closed) {
        $user_module_id = (int)$user_module_id;
        $is_closed = (int)$is_closed;

        // Update directly based on maintenance_table_user.id
        $update = "UPDATE maintenance_table_user 
                   SET is_closed = $is_closed 
                   WHERE id = $user_module_id 
                   AND user_id = $user_id";
        mysqli_query($conn, $update);
    }
}

header("Location: maintinance.php");
exit;
