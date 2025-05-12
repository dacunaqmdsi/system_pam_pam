<?php
error_reporting(0);
include "components/header.php";

$month = isset($_GET['month']) ? intval($_GET['month']) : null; // e.g. 4 for April
$year = isset($_GET['year']) ? intval($_GET['year']) : null;    // e.g. 2025
$department = isset($_GET['department']) ? $_GET['department'] : null;    // Department name or identifier


$fetch_all_user = $db->fetch_all_request_report_detailed($month, $year, $department);
$maintenance = $db->fetch_maintenance();


date_default_timezone_set('Asia/Manila');


$today = date('M. d, Y');
?>


<div id="printArea">
    <!-- Header -->
    <div class="text-center mb-6">
        <img src="../assets/logo/<?= $maintenance['system_image'] ?>" alt="School Logo" class="mx-auto w-20 mb-2"> <!-- Optional -->
        <h1 class="text-xl font-bold uppercase text-red-700">Westmead International School</h1>
        <p class="text-sm">122 Gulod Labac, Batangas City, Batangas</p><?= $maintenance['system_image'] ?>
        <p class="text-sm">Email: westmead@gmail.com | Phone: (043) 425-7608</p>
        <h2 class="mt-4 text-lg font-semibold underline">Procurement Report</h2>
    </div>

    <!-- Report Metadata -->
    <div class="mb-6 text-sm">
        <p><strong>Date:</strong> <?= $today ?></p>
        <p><strong>Full Name:</strong> <?= $On_Session[0]['fullname'] ?></p>
        <p><strong>ID No:</strong> <?= $On_Session[0]['user_id'] ?></p>
        <p><strong>Office Designation:</strong> <?= $On_Session[0]['designation'] ?></p>
    </div>

    <!-- Table -->
    <table class="w-full text-sm border border-gray-500 border-collapse">
        <thead class="bg-gray-200">
            <tr>
                <th class="border border-gray-400 p-2">Request Date</th>
                <th class="border border-gray-400 p-2">Request Item</th>
                <th class="border border-gray-400 p-2">Request Quantity</th>
                <th class="border border-gray-400 p-2">Request By</th>
                <th class="border border-gray-400 p-2">Price</th>
                <th class="border border-gray-400 p-2">Total</th>
                <th class="border border-gray-400 p-2">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($fetch_all_user->num_rows > 0):
                while ($user = $fetch_all_user->fetch_assoc()):
                    $total_price = $user['finance_'] * $user['request_qty'];
                    $request_date = date('M. d, Y', strtotime($user['request_date']));

                    $get_ +=  $total_price;
            ?>
                    <tr class="border">
                        <td class="border border-gray-300 p-2 text-center"><?= $request_date ?></td>
                        <td class="border border-gray-300 p-2 text-center"><?= htmlspecialchars($user['assets_name']) ?> <i>(<?= htmlspecialchars($user['request_variety']) ?>)</i></td>
                        <td class="border border-gray-300 p-2 text-center"><?= $user['request_qty'] ?></td>
                        <td class="border border-gray-300 p-2 text-center"><?= htmlspecialchars($user['user_fullname']) ?></td>
                        <td class="border border-gray-300 p-2 text-center">₱<?= number_format($user['finance_'], 2) ?></td>
                        <td class="border border-gray-300 p-2 text-center">₱<?= number_format($total_price, 2) ?></td>
                        <td class="border border-gray-300 p-2 text-center"><?= htmlspecialchars($user['request_status']) ?></td>
                    </tr>
                <?php endwhile; ?>

                <tr class="border">
                    <td class="border border-gray-300 p-2 text-center"></td>
                    <td class="border border-gray-300 p-2 text-center"></td>
                    <td class="border border-gray-300 p-2 text-center"></td>
                    <td class="border border-gray-300 p-2 text-center"></td>
                    <td class="border border-gray-300 p-2 text-center"></td>
                    <td class="border border-gray-300 p-2 text-center">Total: <b><?= number_format($get_, 2) ?></b></td>
                    <td class="border border-gray-300 p-2 text-center"></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center text-gray-500 py-4">No records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Footer Signatures -->
    <div class="mt-12 grid grid-cols-3 gap-4 text-center text-sm">
        <div>
            <p class="border-t border-gray-600 pt-2">Prepared by</p>
        </div>
        <div>
            <p class="border-t border-gray-600 pt-2">Noted by</p>
        </div>
        <div>
            <p class="border-t border-gray-600 pt-2">Approved by</p>
        </div>
    </div>
</div>

<hr>
<div class="text-center my-4">
    <button id="printButton" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Print Report
    </button>
</div>
<script>
    $('#printButton').on('click', function() {
        var printContents = $('#printArea').html();
        var printWindow = window.open('', '', 'height=800,width=1000');
        printWindow.document.write(`
            <html>
                <head>
                    <title>Print Report</title>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
                    <style>
                        body { padding: 20px; font-family: sans-serif; }
                        table { border-collapse: collapse; width: 100%; }
                        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
                    </style>
                </head>
                <body onload="window.print(); setTimeout(() => window.close(), 100);">
                    ${printContents}
                </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.focus();
    });
</script>
<?php include "components/footer.php"; ?>