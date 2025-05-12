<?php include "components/header.php"; ?>

<!-- Top bar with user profile -->
<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Inventory</h2>
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
        <span class="text-gray-700 font-medium">
            <?php echo ucfirst($On_Session[0]['fullname']); ?>
        </span>
    </div>
</div>



<!-- Search Input with Icon -->
<div class="relative mb-4 w-full max-w-md">
    <span class="absolute inset-y-0 left-3 flex items-center text-gray-500">
        <i class="material-icons text-lg">search</i>
    </span>
    <input type="text" id="searchInput" placeholder="Search users..."
        class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-400 focus:border-red-400 transition">
</div>
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
<div class="bg-white rounded-lg shadow-lg p-6 mb-6">


    <!-- Table Wrapper for Responsiveness -->
    <div class="overflow-x-auto">
        <table id="userTable" class="table-auto w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="bg-gray-100 text-gray-700">
                <tr>

                    <th class="p-3">Image</th>
                    <th class="p-3">Asset Code</th>
                    <th class="p-3">Name</th>

                    <th class="p-3">Category</th>
                    <th class="p-3">Office</th>
                    <th class="p-3">Purchase Date</th>
                    <th class="p-3">Price</th>
                    <th class="p-3">Status</th>



                </tr>
            </thead>
            <tbody>
                <?php include "backend/end-points/inventory_list.php"; ?>
            </tbody>
        </table>
    </div>
</div>







</div>



<?php include "components/footer.php"; ?>