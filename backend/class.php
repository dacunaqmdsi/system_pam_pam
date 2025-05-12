<?php


include('dbconnect.php');

date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }


    public function fetch_maintenance()
    {
        $query = $this->conn->prepare("SELECT * FROM `system_maintenance` LIMIT 1");

        if ($query->execute()) {
            $result = $query->get_result();
            // Fetch a single row as an associative array
            $data = $result->fetch_assoc();

            // Return the single record
            return $data;
        } else {
            return false;
        }
    }


    public function Login($email, $password)
    {
        $query = $this->conn->prepare("SELECT * FROM `users` WHERE `email` = ?");
        $query->bind_param("s", $email);

        // Execute the query
        if ($query->execute()) {
            $result = $query->get_result();
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                // Check if the account is active
                if ($user['status'] != 1) {
                    $query->close();
                    return [
                        'status' => 'error',
                        'message' => 'Your account is disabled. Please contact support.'
                    ];
                }

                // Verify password
                if ($password == $user['password']) {
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }

                    session_regenerate_id(true);
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];

                    $query->close();

                    return [
                        'status' => 'success',
                        'user' => $user
                    ];
                } else {
                    $query->close();
                    return [
                        'status' => 'error',
                        'message' => 'Invalid password.'
                    ];
                }
            }
        }

        $query->close();
        return [
            'status' => 'error',
            'message' => 'User not found.'
        ];
    }








    public function GenerateNewPassword($userId)
    {
        // Validate and sanitize the user ID
        $userId = intval($userId); // Ensure user ID is an integer

        // Generate a random password (or token)
        $randomVerification = bin2hex(random_bytes(15)); // Adjust the length as needed

        // Hash the random password using SHA-256
        $hashed_password = password_hash($randomVerification, PASSWORD_DEFAULT);

        // Escape the hashed password string to prevent injection (not strictly necessary here since it's hashed)
        $escapedPassword = $this->conn->real_escape_string($hashed_password);

        // Create the SQL query with sanitized inputs
        $query = "UPDATE `users` SET `password` = '$escapedPassword' WHERE `id` = $userId";

        // Execute the query
        if ($this->conn->query($query)) {
            return $randomVerification; // Return the generated verification key (plain text for the user)
        } else {
            return false; // Return false if the query fails
        }
    }









    public function CheckEmail($email)
    {


        // Check if the email already exists
        $stmt = $this->conn->prepare("SELECT `id`, `fullname`, `email_official` FROM `users` WHERE `email_official` = ? and `status`='1'");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Email already exists, fetch the user data
            $userData = $result->fetch_assoc();

            $response = array(
                'status' => 'EmailExist',
                'message' => 'Email already exists',
                'data' => array(
                    'id' => $userData['id'],
                    'fullname' => $userData['fullname'],
                    'email' => $userData['email']
                )
            );

            echo json_encode($response);
            return;
        } else {
            // Email does not exist
            echo json_encode(array(
                'status' => 'EmailNotExists',
                'message' => 'The Email you entered is not connected to our system'
            ));
            return;
        }
    }
}
