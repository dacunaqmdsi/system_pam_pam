<?php 
  
                $fetch_all_receive_logs = $db->fetch_all_receive_logs();
            
                // echo "<pre>";
                // print_r($fetch_all_receive_logs);
                // echo "</pre>";
               

                

                if ($fetch_all_receive_logs->num_rows > 0): 
                    $count=1;
                    while ($logs = $fetch_all_receive_logs->fetch_assoc()): ?>
                        <tr>
                            <td class="p-2"><?php echo $count++; ?></td>
                        
                            <td class="p-2"><?php echo htmlspecialchars(date('M d, Y', strtotime($logs['recieved_date']))); ?></td>
                            <td class="p-2"><?php echo htmlspecialchars($logs['recieved_assets_name']); ?></td>
                            <td class="p-2"><?php echo htmlspecialchars($logs['recieved_description']); ?></td>
                            <td class="p-2"><?php echo htmlspecialchars($logs['recieved_supplier_name']); ?></td>
                            <td class="p-2"><?php echo htmlspecialchars($logs['recieved_supplier_company']); ?></td>
                            <td class="p-2"><?php echo htmlspecialchars($logs['recieved_assets_qty']); ?></td>
                            <td class="p-2"><?php echo htmlspecialchars($logs['fullname']); ?></td>
                            <td class="p-2">
                                <button class="bg-gray-500 text-white py-1 px-3 rounded-md togglerUpdateRecieved"
                                data-recieved_id="<?=$logs['recieved_id']?>"
                                data-recieved_assets_name="<?=$logs['recieved_assets_name']?>"
                                data-recieved_description="<?=$logs['recieved_description']?>"
                                data-recieved_supplier_name="<?=$logs['recieved_supplier_name']?>"
                                data-recieved_supplier_company="<?=$logs['recieved_supplier_company']?>"
                                data-recieved_assets_qty="<?=$logs['recieved_assets_qty']?>"
                                data-fullname="<?=$logs['fullname']?>"
                                >
                                                Update
                                </button>
                            </td>
                           
                           



                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="p-2 text-center">No record found.</td>
                    </tr>
                <?php endif; ?>