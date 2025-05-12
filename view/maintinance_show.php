<?php
// include('../connection_short.php');
// // $conn = mysqli_connect("localhost", "u680385054_procurement", "@Mk5^vnVJ", "u680385054_pro");
$conn = mysqli_connect("localhost", "root", "", "pam");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = (int)$_GET['id']; // user id

// Fetch all modules
$modules = mysqli_query($conn, "SELECT * FROM maintenance_table");

// Ensure every module has an entry for this user
while ($module = mysqli_fetch_assoc($modules)) {
    $module_id = $module['id'];

    // Check if user already has this module in maintenance_table_user
    $check = mysqli_query($conn, "SELECT id FROM maintenance_table_user WHERE user_id = $id AND name = '".mysqli_real_escape_string($conn, $module['name'])."' LIMIT 1");
    
    if (mysqli_num_rows($check) == 0) {
        // If not, insert
        mysqli_query($conn, "INSERT INTO maintenance_table_user (user_id, name, is_closed) VALUES ($id, '".mysqli_real_escape_string($conn, $module['name'])."', 0)");
    }
}

// Now fetch user's maintenance records
$userModules = mysqli_query($conn, "SELECT * FROM maintenance_table_user WHERE user_id = $id");

?>
<div><strong>Account ID:</strong> <?=$id?></div>

<div class="container">
    <form method="post" action="update_maintenance_user.php">
        <input type="hidden" name="user_id" value="<?=$id?>">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Module Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($userModules)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td>
                            <div class="radio-group">
                                <label>
                                    <input type="radio" name="status[<?php echo $row['id']; ?>]" value="0" <?php echo $row['is_closed'] == 0 ? 'checked' : ''; ?>>
                                    Open
                                </label>
                                <label>
                                    <input type="radio" name="status[<?php echo $row['id']; ?>]" value="1" <?php echo $row['is_closed'] == 1 ? 'checked' : ''; ?>>
                                    Close
                                </label>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="action-buttons">
            <button type="submit" class="submit-button">
                Update Status
            </button>
        </div>
    </form>
</div>
