
<?php include "components/header.php";

$fetch_all_user = $db->fetch_all_assets();
$maintenance = $db->fetch_maintenance();
date_default_timezone_set('Asia/Manila');

$today = date('M. d, Y'); 
?>
<div id="printArea">

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
       <!-- Header -->
        <div class="text-center mb-6">
            <img src="../assets/logo/<?=$maintenance['system_image']?>" alt="School Logo" class="mx-auto w-20 mb-2"> <!-- Optional -->
            <h1 class="text-xl font-bold uppercase text-red-700">Westmead International School</h1>
            <p class="text-sm">122 Gulod Labac, Batangas City, Batangas</p><?=$maintenance['system_image']?>
            <p class="text-sm">Email: westmead@gmail.com | Phone: (043) 425-7608</p>
            <h2 class="mt-4 text-lg font-semibold underline">Inventory Report</h2>
            <p class="text-sm text-gray-600">List of Assets</p>
        </div>
         
        
        
        <!-- Employee Information -->
        <div class="mb-6 text-sm">
        <p><strong>Date:</strong> <?=$today?></p>
        <p><strong>Full Name:</strong> <?=$On_Session[0]['fullname']?></p>
        <p><strong>ID No:</strong> <?=$On_Session[0]['user_id']?></p>
        <p><strong>Office Designation:</strong> <?=$On_Session[0]['designation']?></p>
    </div>
        
        <!-- Table -->
        <table class="w-full border-collapse border border-gray-300 text-sm text-gray-700">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border p-2">Asset Code</th>
                    <th class="border p-2">Name</th>
                    <th class="border p-2">Item Description</th>
                    <th class="border p-2">Price</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($fetch_all_user->num_rows > 0): 
                    $count = 1;
                    while ($user = $fetch_all_user->fetch_assoc()):
                    ?>
                            <tr class="border">
                                <td class="border p-2 text-center"><?=$user['asset_code']?></td>
                                <td class="border p-2 text-center"><?=$user['name']?></td>
                                <td class="border p-2 text-center"><p><?=$user['description']?><p></td>
                                <td class="border p-2 text-center">₱<?=$user['price']?></td>
                             
                            </tr>
                <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="p-4 text-center text-gray-500">No records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
         <!-- Footer Signatures -->
        <!-- <div class="mt-12 grid grid-cols-3 gap-4 text-center text-sm">
            <div>
                <p class="border-t border-gray-600 pt-2">Prepared by</p>
            </div>
            <div>
                <p class="border-t border-gray-600 pt-2">Noted by</p>
            </div>
            <div>
                <p class="border-t border-gray-600 pt-2">Approved by</p>
            </div>
        </div> -->
        
    </div>
</div>

<hr>
    <div class="text-center my-4">
    <button id="printButton" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Print Report
    </button>
</div>

    <script>
    $('#printButton').on('click', function () {
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
<?php include "components/footer.php";?>
