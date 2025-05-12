<?php 
                $fetch_all_category = $db->fetch_all_category();
                if ($fetch_all_category->num_rows > 0): 
                    while ($category = $fetch_all_category->fetch_assoc()): 
                    ?>

                        <option value="<?=$category['id']?>"><?=$category['category_name']?></option>
                
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="p-2 text-center">No record found.</td>
                    </tr>
                <?php endif; ?>