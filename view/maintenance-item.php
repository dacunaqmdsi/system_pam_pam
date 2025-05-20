<?php include "components/header.php"; ?>

<!-- Page Wrapper -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-8">

    <!-- Top Bar with Title and User Info -->
    <div class="flex justify-between items-center bg-white p-4 rounded-xl shadow">
        <h2 class="text-2xl font-semibold text-gray-800">Under Maintenance Assets</h2>
        <div class="flex items-center space-x-3">
            <?php
            $userImage = !empty($On_Session[0]['profile_picture']) ? $On_Session[0]['profile_picture'] : null;
            ?>
            <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center text-gray-600">
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


    <!-- Under Maintenance Assets Card -->
    <div class="bg-white rounded-xl shadow p-6">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800 mb-2 sm:mb-0">Under Maintenance Assets</h2>

            <!-- Search Bar -->
            <div class="relative w-full sm:w-80">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <i class="material-icons text-base">search</i>
                </span>
                <input type="text" id="searchInput" placeholder="Search assets..."
                       class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-400 focus:border-red-400 transition">
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table id="userTable" class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="p-3 font-medium">#</th>
                        <!-- <th class="p-3 font-medium">Image</th> -->
                        <th class="p-3 font-medium">Asset ID</th>
                        <th class="p-3 font-medium">Name</th>
                        <th class="p-3 font-medium">Description</th>
                        <th class="p-3 font-medium">Category</th>
                        <th class="p-3 font-medium">Subcategory</th>
                        <th class="p-3 font-medium">Condition</th>
                        <th class="p-3 font-medium">Office</th>
                        <th class="p-3 font-medium">Purchase Date</th>
                        <th class="p-3 font-medium">Status</th>
                        <th class="p-3 font-medium">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php include "backend/end-points/under_maintinance_list.php"; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Search Function -->
<script>
    $(document).ready(function () {
        $("#searchInput").on("keyup", function () {
            const value = $(this).val().toLowerCase();
            $("#userTable tbody tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    });
</script>

<?php include "components/footer.php"; ?>
