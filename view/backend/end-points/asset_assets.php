<?php 
                $fetch_all_assets = $db->fetch_all_assets();
                if ($fetch_all_assets->num_rows > 0): 
                    while ($assets = $fetch_all_assets->fetch_assoc()): 
                    ?>

                        <option value="<?=$assets['id']?>"><?=$assets['name']?></option>
                
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="p-2 text-center">No record found.</td>
                    </tr>
                <?php endif; ?>