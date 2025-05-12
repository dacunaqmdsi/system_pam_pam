<?php
include('../class.php'); 
$db = new global_class();

if (isset($_POST['query'])) {
    $search = $_POST['query'];
    

    $query = $db->conn->prepare("
        SELECT *
        FROM users 
        WHERE (fullname LIKE ?) AND status = 1
        LIMIT 10
    ");
    
    $likeSearch = "%" . $search . "%";
    $query->bind_param("s", $likeSearch); // Bind both parameters
    $query->execute();
    $result = $query->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "id" => $row['id'],
            "user_id" => $row['user_id'],
            "fullname" => $row['fullname'],
            "designation" => $row['designation'],
        ];
    }

    echo json_encode($data);
}
?>
