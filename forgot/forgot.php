<?php
$err = '';
$success = '';
// include('../connection_short.php');
// // $db_connection = mysqli_connect("localhost", "u680385054_procurement", "@Mk5^vnVJ", "u680385054_pro");
$db_connection = mysqli_connect("localhost", "root", "", "pam");

if (!$db_connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if token and email are set
if (!isset($_GET['token']) || !isset($_GET['email'])) {
    die("Invalid password reset link.");
}

$email = trim($_GET['email']);
$token = trim($_GET['token']);

// Validate token
$stmt = mysqli_prepare($db_connection, "SELECT accountid, expiry FROM tblforgot_otp WHERE email = ? AND token = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "ss", $email, $token);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) === 1) {
    mysqli_stmt_bind_result($stmt, $accountid, $expiry);
    mysqli_stmt_fetch($stmt);

    if (strtotime($expiry) < time()) {
        die("This password reset link has expired.");
    }
} else {
    die("Invalid or expired password reset link.");
}
mysqli_stmt_close($stmt);

// Handle password reset
if (isset($_POST['forgot'])) {
    if (empty(trim($_POST['password'])) || empty(trim($_POST['confirm_password']))) {
        $err = "All fields are required.";
    } elseif ($_POST['password'] !== $_POST['confirm_password']) {
        $err = "Passwords do not match.";
    } else {
        $password = trim($_POST['password']);
        $hashed_password = $password; // You can hash if needed

        $stmt = mysqli_prepare($db_connection, "UPDATE users SET password=? WHERE email_official=?");
        mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $email);

        if (mysqli_stmt_execute($stmt)) {
            $stmt = mysqli_prepare($db_connection, "DELETE FROM tblforgot_otp WHERE email = ?");
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);

            echo "<script>
                alert('Password changed successfully! Redirecting...');
                setTimeout(function() {
                    window.location.href = '../';
                }, 2000);
            </script>";
        } else {
            $err = "Error updating password: " . mysqli_error($db_connection);
        }
        mysqli_stmt_close($stmt);
    }
}
mysqli_close($db_connection);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - PAM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="min-h-screen bg-cover bg-center flex items-center justify-center px-4 py-10" style="background-color: #991b1c;">

    <div class="bg-white bg-opacity-80 p-8 rounded shadow-lg w-full max-w-2xl backdrop-blur-sm">

        <div class="bg-white bg-opacity-90 rounded-xl shadow-lg w-full p-8">

            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-800 mb-6 text-center">Reset Your Password</h2>

            <?php if (!empty($err)): ?>
                <script>
                    alert("<?php echo $err; ?>");
                </script>
            <?php endif; ?>

            <form method="POST" class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Email</label>
                    <input type="text" name="email_add" value="<?php echo htmlspecialchars($email); ?>" readonly
                        class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm bg-gray-100 focus:outline-none">
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700">New Password</label>
                    <input type="password" id="password" name="password"
                        class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div>
                    <label for="confirm_password" class="block text-sm font-semibold text-gray-700">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password"
                        class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div>
                    <button type="submit" name="forgot"
                        class="w-full py-3 px-4 rounded-lg shadow-md text-sm font-semibold text-white bg-red-800 hover:bg-red-900 transition duration-200">
                        Submit
                    </button>
                </div>
            </form>

        </div>

    </div>

</body>

</html>