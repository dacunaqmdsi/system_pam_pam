<?php
error_reporting(0);
include "components/header.php";

$department = $_GET['department'];
$fetch_request_receipt = $db->fetch_all_request_for_admin_sort($department);

?>

<script>
    function ajax_fn(url, elementId) {
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById(elementId).innerHTML = "";
                document.getElementById(elementId).innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }

    function save_price(r_item_id) {
        var r_finance_price = document.getElementById('r_finance_price' + r_item_id).value;
        if (r_finance_price) {
            ajax_fn('procurement_receipt_save.php?r_item_id=' + r_item_id + '&r_finance_price=' + r_finance_price, 'tmp');
        } else {
            alert("Please enter a valid price.");
        }
    }
</script>
<style>

</style>
<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg" id="printedArea">
    <!-- Header -->
    <div class="text-center mb-4">
        <h1 class="text-xl font-bold sm:text-2xl">Procurement Receipt</h1>
        <p class="text-sm text-gray-600 sm:text-base">List of Request</p>
    </div>

    <!-- Table -->
    <table class="w-full border-collapse border border-gray-300 text-sm text-gray-700 sm:text-base">
        <thead class="bg-gray-200">
            <tr>
                <th class="border p-2">Request Item</th>
                <th class="border p-2">Variety</th>
                <th class="border p-2">Request Quantity</th>
                <th class="border p-2">Input Price (Head Finance)</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($fetch_request_receipt && $fetch_request_receipt->num_rows > 0):
                while ($item = $fetch_request_receipt->fetch_assoc()):
                    $total_price = $item['r_finance_price'] * $item['r_item_qty'];
                    $get_t += $total_price;
            ?>
                    <tr class="border">
                        <td class="border p-2 text-center"><?= htmlspecialchars($item['asset_name']) ?></td>
                        <td class="border p-2 text-center"><?= htmlspecialchars($item['r_item_variety'] ?? 'N/A') ?></td>
                        <td class="border p-2 text-center"><?= htmlspecialchars($item['r_item_qty']) ?></td>
                        <td class="border p-2 text-center">
                            <input type="number" value="<?= htmlspecialchars($item['r_finance_price']) ?>" placeholder="Price" class="bg-gray-200" id="r_finance_price<?= htmlspecialchars($item['r_item_id']) ?>" name="r_finance_price" />

                            <?php if ($_SESSION['role'] == "Head Finance" || $_SESSION['role'] == "Administrator"): ?>
                                <button id="show_not" onclick="save_price(<?= htmlspecialchars($item['r_item_id']) ?>);">Save</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
                <tr>
                    <td class="border p-2 text-center"></td>
                    <td class="border p-2 text-center"></td>
                    <td class="border p-2 text-center"></td>
                    <td class="border p-2 text-center">Total: <b><?php echo number_format($get_t, 2); ?></b></td>

                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="p-4 text-center text-gray-500">No records found.</td>
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

<!-- Print Button -->
<div class="text-center mt-4">
    <button id="printBtn" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Print Receipt</button>
</div>

<?php include "components/footer.php"; ?>

<script>
    $(document).ready(function() {
        $('#printBtn').click(function() {
            // Hide all other elements except #printedArea
            var printContent = $('#printedArea').html();
            var originalContent = $('body').html();

            $('body').html('<div id="printableArea">' + printContent + '</div>');

            // Trigger the print dialog for the new content
            window.print();

            // After printing, restore the original content
            $('body').html(originalContent);
        });
    });
</script>