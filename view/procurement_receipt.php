<?php

include "components/header.php";

$request_id = $_GET['request_id'];
$fetch_request_receipt = $db->fetch_request_receipt($request_id);
$fetch_request_item = $db->fetch_request_item($fetch_request_receipt['request_id']);



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
        ajax_fn('procurement_receipt_save.php?r_item_id=' + r_item_id + '&r_finance_price=' + r_finance_price, 'tmp');

    }
</script>
<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg" id="printedArea">
    <!-- Header -->
    <div class="text-center mb-4">
        <h1 class="text-xl font-bold sm:text-2xl">Purchase Order</h1>
        <p class="text-sm text-gray-600 sm:text-base">List of Request</p>
    </div>

    <div class="mb-4 border-b pb-4">
        <p class="text-sm sm:text-base"><strong>Date:</strong> <?= date('M. d, Y', strtotime($fetch_request_receipt['request_date'])); ?></p>
        <p class="text-sm sm:text-base"><strong>Request By:</strong> <?= $fetch_request_receipt['user_fullname'] ?></p>
        <p class="text-sm sm:text-base"><strong>ID No:</strong> <?= $fetch_request_receipt['user_id'] ?></p>
        <p class="text-sm sm:text-base"><strong>Office Designation:</strong> <?= $fetch_request_receipt['request_designation'] ?></p>
        <p class="text-sm sm:text-base"><strong>Status:</strong> <?= ucfirst($fetch_request_receipt['request_status']) ?></p>
    </div>

    <!-- Table -->
    <table class="w-full border-collapse border border-gray-300 text-sm text-gray-700 sm:text-base">
        <thead class="bg-gray-200">
            <tr>
                <th class="border p-2">Request Item</th>
                <th class="border p-2">Variety</th>
                <th class="border p-2">Request Quantity</th>
                <!-- <th class="border p-2">Price</th>
                <th class="border p-2">Total</th> -->
                <th class="border p-2">Input Price</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($fetch_request_item)):
                $count = 1;
                foreach ($fetch_request_item as $item):
                    $total_price = $item['r_item_price'] * $item['r_item_qty'];
            ?>
                    <tr class="border">
                        <td class="border p-2 text-center"><?= $item['name'] ?></td>
                        <!-- <td class="border p-2 text-center"><?= $item['r_item_variety'] ?? 'N/A' ?> <small>(<?= $item['sss'] ?>)</small></td> -->

                        <td class="border p-2 text-center">
                            <?= htmlspecialchars($item['r_item_variety'] ?? '') ?>
                            <?php
                            $specification = json_decode($item['r_specification_array'] ?? '', true); // decode JSON as array

                            if ($specification) {
                                echo '<strong>Name:</strong> ' . htmlspecialchars($specification['name']) . '<br>';
                                echo '<strong>Details:</strong><ul class="list-disc list-inside text-left">';
                                foreach ($specification['values'] as $value) {
                                    echo '<li>' . htmlspecialchars($value) . '</li>';
                                }
                                echo '</ul>';
                            } else {
                                echo ''; // Or you can echo 'Invalid format' if needed
                            }
                            ?>
                        </td>

                        <td class="border p-2 text-center"><?= $item['r_item_qty'] ?></td>
                        <!-- <td class="border p-2 text-center">₱<?= number_format($item['r_item_price'], 2) ?></td>
                        <td class="border p-2 text-center">₱<?= number_format($total_price, 2) ?></td> -->
                        <td class="border p-2 text-center"><input type="number" value="<?= $item['r_finance_price'] ?>" placeholder="Price" class="bg-gray-200" id="r_finance_price<?= $item['r_item_id'] ?>" name="r_finance_price" />


                            <?php if ($_SESSION['role'] == "Head Finance" || $_SESSION['role'] == "Administrator") { ?>

                                <button onclick="save_price(<?= $item['r_item_id'] ?>);">Save</button>

                            <?php } ?>


                        </td>
                        <span id="tmp"></span>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">No records found.</td> <!-- Adjust colspan if necessary -->
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






<br>
<?php


if ($On_Session[0]['role'] == "Administrator") {
    $fetch_all_user = $db->fetch_all_request_for_admin2($_GET['request_id']);
} else if ($On_Session[0]['role'] == "Head Finance") {
    $fetch_all_user = $db->fetch_all_request_for_head2($On_Session[0]['role'], $_GET['request_id']);
} else if ($On_Session[0]['role'] == "Head Library") {
    $fetch_all_user = $db->fetch_all_request_for_head2($On_Session[0]['role'], $_GET['request_id']);
} else if ($On_Session[0]['role'] == "Head IACEPO & NSTP") {
    $fetch_all_user = $db->fetch_all_request_for_head2($On_Session[0]['role'], $_GET['request_id']);
} else if ($On_Session[0]['role'] == "Head Basic Education") {
    $fetch_all_user = $db->fetch_all_request_for_head2($On_Session[0]['role'], $_GET['request_id']);
} else {
    $fetch_all_user = $db->fetch_all_request2($_SESSION['id'], $_GET['request_id']);
}





if ($fetch_all_user->num_rows > 0):
    $count = 1;
    while ($user = $fetch_all_user->fetch_assoc()): ?>
        <div align="left" class="flex items-center justify-center space-x-2">


            <?php if (isset($On_Session[0]['role']) && $On_Session[0]['role'] == "Administrator") { ?>
                <select class="togglerRequest bg-blue-500 text-white py-1 px-3 rounded-md"
                    data-request_id="<?= htmlspecialchars($user['request_id']) ?>"
                    aria-label="Select User Status">
                    <!-- Only show Pending if status is not Delivered -->
                    <?php if ($user['request_status'] != 'Delivered') { ?>
                        <option value="" <?= !$user['request_status'] ? 'selected' : '' ?>>Pending</option>
                    <?php } ?>
                    <!-- Only show Approve if status is not Delivered -->
                    <?php if ($user['request_status'] != 'Delivered') { ?>
                        <option value="Approve" <?= $user['request_status'] == 'Approve' ? 'selected' : '' ?>>Approve</option>
                    <?php } ?>
                    <!-- Only show Ongoing if status is not Delivered -->
                    <?php if ($user['request_status'] != 'Delivered') { ?>
                        <option value="Ongoing" <?= $user['request_status'] == 'Ongoing' ? 'selected' : '' ?>>Ongoing</option>
                    <?php } ?>
                    <!-- Always show Delivered -->
                    <option value="Delivered" <?= $user['request_status'] == 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                    <!-- Only show Decline if status is not Delivered -->
                    <?php if ($user['request_status'] != 'Delivered') { ?>
                        <option value="Decline" class="text-red-500" <?= $user['request_status'] == 'Decline' ? 'selected' : '' ?>>Decline</option>
                    <?php } ?>
                </select>
            <?php } ?>



            <!-- Other heads -->
            <?php if (isset($On_Session[0]['role']) && ($On_Session[0]['role'] == "Head Library" || $On_Session[0]['role'] == "Head Basic Education" || $On_Session[0]['role'] == "Head IACEPO & NSTP")) { ?>
                <select class="togglerRequest bg-blue-500 text-white py-1 px-3 rounded-md"
                    data-request_id="<?= htmlspecialchars($user['request_id']) ?>"
                    aria-label="Select User Status">
                    <!-- Only show Pending if status is not Delivered -->
                    <?php if ($user['request_status'] != 'Delivered') { ?>
                        <option value="" <?= !$user['request_status'] ? 'selected' : '' ?>>Pending</option>
                    <?php } ?>
                    <!-- Only show Approve if status is not Delivered -->
                    <?php if ($user['request_status'] != 'Delivered') { ?>
                        <option value="Approve" <?= $user['request_status'] == 'Approve' ? 'selected' : '' ?>>Approve</option>
                    <?php } ?>
                    <?php if ($user['request_status'] != 'Delivered') { ?>
                        <option value="Decline" class="text-red-500" <?= $user['request_status'] == 'Decline' ? 'selected' : '' ?>>Decline</option>
                    <?php } ?>
                </select>
            <?php } ?>


            <!-- Head of Finance -->
            <?php if (isset($On_Session[0]['role']) && $On_Session[0]['role'] == "Head Finance") { ?>
                <select class="togglerRequest bg-blue-500 text-white py-1 px-3 rounded-md"
                    data-request_id="<?= htmlspecialchars($user['request_id']) ?>"
                    aria-label="Select User Status">
                    <!-- Only show Pending if status is not Delivered -->
                    <?php if ($user['request_status'] != 'Delivered') { ?>
                        <option value="" <?= !$user['request_status'] ? 'selected' : '' ?>>Pending</option>
                    <?php } ?>
                    <!-- Only show Approve if status is not Delivered -->
                    <?php if ($user['request_status'] != 'Delivered') { ?>
                        <option value="Approve" <?= $user['request_status'] == 'Approve' ? 'selected' : '' ?>>Approve</option>
                    <?php } ?>
                    <!-- Only show Ongoing if status is not Delivered -->
                    <?php if ($user['request_status'] != 'Delivered') { ?>
                        <option value="Ongoing" <?= $user['request_status'] == 'Ongoing' ? 'selected' : '' ?>>Ongoing</option>
                    <?php } ?>
                    <!-- Always show Delivered -->
                    <option value="Delivered" <?= $user['request_status'] == 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                    <!-- Only show Decline if status is not Delivered -->
                    <?php if ($user['request_status'] != 'Delivered') { ?>
                        <option value="Decline" class="text-red-500" <?= $user['request_status'] == 'Decline' ? 'selected' : '' ?>>Decline</option>
                    <?php } ?>
                </select>
            <?php } ?>
        </div>
    <?php endwhile; ?>
<?php else: ?>
<?php endif; ?>


















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