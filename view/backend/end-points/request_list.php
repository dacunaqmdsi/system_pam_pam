<?php


if ($On_Session[0]['role'] == "Administrator") {
    $fetch_all_user = $db->fetch_all_request_for_admin();
} else if ($On_Session[0]['role'] == "Head Finance") {
    $fetch_all_user = $db->fetch_all_request_for_head($On_Session[0]['role']);
} else if ($On_Session[0]['role'] == "Head Library") {
    $fetch_all_user = $db->fetch_all_request_for_head($On_Session[0]['role']);
} else if ($On_Session[0]['role'] == "Head IACEPO & NSTP") {
    $fetch_all_user = $db->fetch_all_request_for_head($On_Session[0]['role']);
} else if ($On_Session[0]['role'] == "Head Basic Education") {
    $fetch_all_user = $db->fetch_all_request_for_head($On_Session[0]['role']);
} else {
    $fetch_all_user = $db->fetch_all_request($_SESSION['id']);
}





if ($fetch_all_user->num_rows > 0):
    $count = 1;
    while ($user = $fetch_all_user->fetch_assoc()): ?>
        <tr>
            <td class="p-2"><?php echo $count++; ?></td>
            <td class="p-2"><?php echo htmlspecialchars($user['request_invoice']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars(ucfirst($user['user_fullname'])); ?></td>
            <!-- <td class="p-2"><?php echo htmlspecialchars($user['request_designation']); ?></td> -->
            <td class="p-2"><?php echo htmlspecialchars($user['request_date']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($user['request_status']); ?></td>


            <td class="p-2 text-center">
                <div class="flex items-center justify-center space-x-2">
                   
                
                    <?php if (isset($On_Session[0]['role']) && $On_Session[0]['role'] == "Administrator") { ?>
                        <select hidden class="togglerRequest bg-blue-500 text-white py-1 px-3 rounded-md"
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
                        <select hidden class="togglerRequest bg-blue-500 text-white py-1 px-3 rounded-md"
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
                        <select hidden class="togglerRequest bg-blue-500 text-white py-1 px-3 rounded-md"
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


                    <!-- View Button -->
                    <a href="procurement_receipt.php?request_id=<?= $user['request_id'] ?>">
                        <button class="bg-gray-500 text-white py-1 px-3 rounded-md">
                            View
                        </button>
                    </a>
                    <?php if (isset($On_Session[0]['role']) && $On_Session[0]['role'] == "Administrator") { ?>
                        <button class="bg-gray-500 text-white py-1 px-3 rounded-md btnArchive"
                            data-request_id="<?= htmlspecialchars($user['request_id']) ?>">
                            Archive
                        </button>
                    <?php } ?>
                </div>
            </td>





        </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="9" class="p-2 text-center">No record found.</td>
    </tr>
<?php endif; ?>