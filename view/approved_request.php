<?php include "components/header.php";
$conn = mysqli_connect("localhost", "root", "", "pam");
$db->read_notif();
?>
<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Approved Request</h2>
    <div class="flex items-center space-x-3">
        <?php
        $userImage = !empty($On_Session[0]['profile_picture']) ? $On_Session[0]['profile_picture'] : null;
        ?>
        <div class="w-10 h-10 rounded-full overflow-hidden flex items-center justify-center bg-gray-200 text-gray-600">
            <?php if ($userImage): ?>
                <img src="../uploads/images/<?php echo $userImage; ?>" alt="User Avatar" class="w-full h-full object-cover">
            <?php else: ?>
                <span class="material-icons text-3xl">account_circle</span>
            <?php endif; ?>
        </div>
        <div>
        <?php
            $notificationCount = $db->GetValue("SELECT COUNT(request_id) FROM request WHERE is_viewed = 0 AND request_user_id = " . intval($_SESSION['id']));
            ?>
            <span class="relative inline-block cursor-pointer" title="Notifications">
                <span class="material-icons text-gray-600 text-2xl">notifications</span>
                <?php if ($notificationCount > 0): ?>
                    <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full px-1">
                        <?php echo $notificationCount; ?>
                    </span>
                <?php endif; ?>
            </span>

        </div>
        <span class="text-gray-700 font-medium">
            <?php echo ucfirst($On_Session[0]['fullname']); ?>
        </span>
    </div>
</div>
<div class="relative mb-4 w-full max-w-md">
    <span class="absolute inset-y-0 left-3 flex items-center text-gray-500">
        <i class="material-icons text-lg">search</i>
    </span>
    <input type="text" id="searchInput" placeholder="Search users..."
        class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-400 focus:border-red-400 transition">
</div>
<? //include('request_add.php'); 
?>
<div id="mainC">
    <script>
        $(document).ready(function() {
            $('#userTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true
            });
        });
    </script>


    <!-- User Table Card -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6 mt-6">
        <div class="overflow-x-auto">
            <table id="" class="table-auto w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-3">#</th>
                        <th class="p-3">Invoice</th>
                        <th class="p-3">Request By</th>
                        <!-- <th class="p-3">Designation</th> -->
                        <th class="p-3">Request Date</th>
                        <th class="p-3">Status</th>
                        <!-- <th class="p-3 text-center">Actions</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php include "backend/end-points/approved_list.php"; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include "components/footer.php"; ?>
<script src="assets/js/filter_assets_category.js"></script>