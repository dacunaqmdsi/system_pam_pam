<?php include "components/header.php"; ?>

<!-- Top bar with user profile -->
<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Reports</h2>
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

<div class="flex justify-center">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl">


        <!-- Card 2 (Procurements Report) -->
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <h3 class="text-lg font-semibold mb-4">Procurements Report</h3>
            <p class="text-gray-600 mb-4">Detailed procurement overview.</p>
            <a href="print_procurement_report">
                <button class="print-report-procurements bg-red-500 text-white px-4 py-2 rounded-md mt-2">
                    View Report
                </button>
            </a>
        </div>

        <!-- Card 2 (Procurements Report) -->
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <h3 class="text-lg font-semibold mb-4">Procurements Report (Monthly Report)</h3>
            <p class="text-gray-600 mb-4">Detailed procurement overview.</p>
            <a href="print_procurement_report_m">
                <button class="print-report-procurements bg-red-500 text-white px-4 py-2 rounded-md mt-2">
                    View Report
                </button>
            </a>
        </div>

        <!-- Card 1 -->
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <h3 class="text-lg font-semibold mb-4">Inventory Report</h3>
            <p class="text-gray-600 mb-4">Summary of student performance.</p>
            <a href="print_inventory_report">
                <button class="print-report-inv bg-red-500 text-white px-4 py-2 rounded-md mt-2">
                    View Report
                </button>
            </a>

        </div>
    </div>
</div>



<?php include "components/footer.php"; ?>