<?php 
                $fetch_all_user = $db->fetch_all_assets();
                if ($fetch_all_user->num_rows > 0): 
                    $count = 1;
                    while ($user = $fetch_all_user->fetch_assoc()): 
                    ?>


                    <tr>
                       
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
                        <td class="p-2"><?php echo htmlspecialchars($user['category_name']); ?></td>
                        <td class="p-2"><?php echo htmlspecialchars($user['office_name']); ?></td>
                        <td class="p-2"><?php echo htmlspecialchars($user['purchase_date']); ?></td>
                        <td class="p-2">₱<?php echo htmlspecialchars(number_format($user['price'],2)); ?></td>
                        <td class="p-2"><?php echo htmlspecialchars($user['status']); ?></td>

                       
                    </tr>

                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="p-2 text-center">No record found.</td>
                    </tr>
                <?php endif; ?>