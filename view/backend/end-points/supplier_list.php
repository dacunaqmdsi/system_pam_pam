<?php
$fetch_all_receive_logs = $db->fetch_all_supplier();
if ($fetch_all_receive_logs->num_rows > 0) :
    $count = 1;
    while ($logs = $fetch_all_receive_logs->fetch_assoc()) : ?>
        <tr>
            <td class="p-2"><?php echo $count++; ?></td>
            <td class="p-2"><?php echo htmlspecialchars($logs['supplier_name']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($logs['item_name']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($logs['price']); ?></td>
            <!-- <td class="p-2"><?php echo htmlspecialchars($logs['qty']); ?></td> -->
        </tr>
    <?php endwhile; ?>
<?php else : ?>
    <tr>
        <td colspan="4" class="p-2 text-center">No record found.</td>
    </tr>
<?php endif; ?>