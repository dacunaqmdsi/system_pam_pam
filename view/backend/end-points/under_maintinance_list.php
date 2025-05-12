<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<?php 
$fetch_all_user = $db->under_maintinance_list();
if ($fetch_all_user->num_rows > 0): 
    $count = 1;
    while ($user = $fetch_all_user->fetch_assoc()): 
?>

<tr>
    <td class="p-2"><?php echo $count++ ?></td>
    
    <td class="p-2">
        <div class="flex items-center justify-center w-12 h-12">
            <?php if (!empty($user['image'])): ?>
                <img src="../uploads/images/<?php echo htmlspecialchars($user['image']); ?>" 
                    alt="Profile Picture" 
                    class="w-10 h-10 rounded-full">
            <?php else: ?>
                <i class="material-icons text-gray-500" style="font-size: 3rem;">image</i>
            <?php endif; ?>
        </div>
    </td>
  
    <td class="p-2"><?php echo htmlspecialchars($user['asset_code']); ?></td>
    <td class="p-2"><?php echo htmlspecialchars($user['name']); ?></td>
    <td class="p-2"><?php echo htmlspecialchars($user['description']); ?></td>
    <td class="p-2"><?php echo htmlspecialchars($user['category_name']); ?></td>
    <td class="p-2"><?php echo htmlspecialchars($user['subcategory_name']); ?></td>
    <td class="p-2"><?php echo htmlspecialchars($user['condition_status']); ?></td>
    <td class="p-2"><?php echo htmlspecialchars($user['office_name']); ?></td>
    <td class="p-2"><?php echo htmlspecialchars($user['purchase_date']); ?></td>
    <td class="p-2"><?php echo htmlspecialchars($user['status']); ?></td>
    <td class="p-2">
        <div class="mb-4">
                <select name="assets_status" id="repair_assets" class="w-full p-2 border rounded-md"
                    data-asset_id="<?= $user['id']; ?>">
                    <option value="Available" <?php if($user['status'] == "Available") echo "selected"; ?>>Available</option>
                    <option value="Assigned" <?php if($user['status'] == "Assigned") echo "selected"; ?>>Assigned</option>
                    <option value="Under Maintenance" <?php if($user['status'] == "Under Maintenance") echo "selected"; ?>>Under Maintenance</option>
                    <option value="Disposed" <?php if($user['status'] == "Disposed") echo "selected"; ?>>Disposed</option>
                    <option value="Fixed" <?php if($user['status'] == "Fixed") echo "selected"; ?>>Fixed</option>
                </select>
        </div>
    </td>

   
</tr>

<?php endwhile; ?>
<?php else: ?>
<tr>
    <td colspan="12" class="p-2 text-center">No record found.</td>
</tr>
<?php endif; ?>

<!-- Modal for displaying large QR Code -->
<div id="qr-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display:none;">
    <div class="bg-white p-5 rounded-md w-96 flex flex-col">
        <div class="flex justify-end mb-4">
            <button id="close-modal" class="text-red-500 text-xl">&times;</button>
        </div>
        <div id="large-qr-container" class="flex justify-center items-center mb-4">
        </div>
        <div class="flex justify-center">
            <button class="bg-blue-500 text-white py-1 px-3 rounded-md togglerPrintQr">Print</button>
        </div>
    </div>
</div>


<script>
   $(document).ready(function() {
    // Generate QR Codes for assets
    <?php 
    $fetch_all_user = $db->fetch_all_assets();
    while ($user = $fetch_all_user->fetch_assoc()): 
    ?>
        var assetDetails = "<?php echo htmlspecialchars($user['asset_code']); ?> | <?php echo htmlspecialchars($user['name']); ?> | <?php echo htmlspecialchars($user['description']); ?>";

        new QRCode(document.getElementById("qrcode-<?php echo $user['id']; ?>"), {
            text: assetDetails,
            width: 80,
            height: 80
        });
    <?php endwhile; ?>

    // Click event to open modal with large QR code
    $('.qr-container').click(function() {
        var assetDetails = $(this).data('asset-details');  // Get asset details dynamically from the clicked QR container

        var largeQRCode = new QRCode(document.createElement("div"), {
            text: assetDetails,
            width: 200,
            height: 200
        });

        $('#large-qr-container').html(largeQRCode._oDrawing._el);  // Inject the larger QR code
        $('#qr-modal').fadeIn();  // Show the modal
    });

    // Close modal
    $('#close-modal').click(function() {
        $('#qr-modal').fadeOut();  // Hide the modal
    });

    // Close Modal when clicking outside the modal content
    $("#qr-modal").click(function(event) {
        if ($(event.target).is("#qr-modal")) {
            $("#qr-modal").fadeOut();
        }
    });

    // Print QR Code with fitting adjustments and centering
    $(".togglerPrintQr").click(function() {
        var printContent = $('#large-qr-container').html();  // Get the QR code content
        var printWindow = window.open('', '', 'height=600,width=800');
        
        printWindow.document.write('<html><head><title>Print QR Code</title>');
        printWindow.document.write('<style>');
        printWindow.document.write('body { font-family: Arial, sans-serif; margin: 0; padding: 0; display: flex; justify-content: center; align-items: center; height: 100vh; }');
        printWindow.document.write('#print-container { width: 100%; text-align: center; padding: 20px; }');
        printWindow.document.write('.qr-code { max-width: 100%; height: auto; margin: 0 auto; }');  // Ensures the QR code fits and is centered
        printWindow.document.write('@media print { body { margin: 0; padding: 0; height: 100%; } #print-container { display: flex; justify-content: center; align-items: center; height: 100%; } }');
        printWindow.document.write('</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write('<div id="print-container">');
        printWindow.document.write('<div class="qr-code">' + printContent + '</div>');  // Insert QR code into print window
        printWindow.document.write('</div>');
        printWindow.document.write('</body></html>');
        
        printWindow.document.close();  // Necessary for IE >= 10
        printWindow.print();  // Print the window content
    });
});
</script>
