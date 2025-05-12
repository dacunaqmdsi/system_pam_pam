<?php 
                $fetch_all_subcategory = $db->fetch_all_subcategory();
                if ($fetch_all_subcategory->num_rows > 0): 
                    while ($subcategory = $fetch_all_subcategory->fetch_assoc()): 
                    ?>

                        <option data-category_id="<?=$subcategory['category_id ']?>" value="<?=$subcategory['id']?>"><?=$subcategory['subcategory_name']?></option>
                
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="p-2 text-center">No record found.</td>
                    </tr>
                <?php endif; ?>