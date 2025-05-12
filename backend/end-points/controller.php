<?php
include('../class.php');

$db = new global_class();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['requestType'])) {
        if ($_POST['requestType'] == 'Login') {
            // Sanitize input
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

            // Check for empty fields
            if (empty($email) || empty($password)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Please enter both username and password.'
                ]);
                exit;
            }

            $userResult = $db->Login($email, $password);

            if ($userResult['status'] === 'success') {
                $user = $userResult['user'];

                $redirectPath = ($user['role'] === 'Administrator') ? 'view/dashboard' : 'view/home';

                echo json_encode([
                    'status' => 'success',
                    'message' => 'Login successful',
                    'redirect' => $redirectPath
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => $userResult['message']
                ]);
            }
        } else if ($_POST['requestType'] == 'ForgotPassword') {


            $email = $_POST['email'];
            echo $db->CheckEmail($email);
        } else {
            echo 'requestType NOT FOUND';
        }
    } else {
        echo 'Access Denied! No Request Type.';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
}
