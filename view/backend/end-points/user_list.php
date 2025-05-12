<?php 
                $fetch_all_user = $db->fetch_all_user();
                if ($fetch_all_user->num_rows > 0): 
                    while ($user = $fetch_all_user->fetch_assoc()): 
                    ?>


                    <tr>
                        <td class="p-2"><?php echo htmlspecialchars($user['user_id']); ?></td>
                        <td class="p-2">
                            <div class="flex items-center justify-center w-12 h-12">
                                <?php if (!empty($user['profile_picture'])): ?>
                                    <img src="../uploads/images/<?php echo htmlspecialchars($user['profile_picture']); ?>" 
                                        alt="Profile Picture" 
                                        class="w-10 h-10 rounded-full">
                                <?php else: ?>
                                    <i class="material-icons text-gray-500" style="font-size: 3rem;">account_circle</i>



                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="p-2"><?php echo htmlspecialchars(ucfirst($user['fullname'])); ?></td>
                        <td class="p-2"><?php echo htmlspecialchars(ucfirst($user['nickname'])); ?></td>
                        <td class="p-2"><?php echo htmlspecialchars($user['email']); ?></td>
                        <td class="p-2"><?php echo htmlspecialchars($user['role']); ?></td>
                        <td class="p-2"><?php echo htmlspecialchars($user['created_at']); ?></td>
                        <td class="p-2"><?php echo htmlspecialchars($user['designation']); ?></td>
                        <td class="p-2"><?php echo htmlspecialchars($user['password']); ?></td>
                        <td class="p-2">
                        <?php if ($user['status'] == 1): ?>
                            <span class="text-green-600 font-semibold">Active</span>
                        <?php else: ?>
                            <span class="text-red-600 font-semibold">Disabled</span>
                        <?php endif; ?>
                        </td>



                        <?php if (isset($On_Session[0]['role']) && $On_Session[0]['role'] == "Administrator") { ?>
                            <td class="p-2">
                                <button class="bg-blue-500 text-white py-1 px-3 rounded-md togglerUpdateUser" 
                                    data-id="<?= htmlspecialchars($user['id']) ?>"
                                    data-user_id="<?= htmlspecialchars($user['user_id']) ?>"
                                    data-fullname="<?= htmlspecialchars($user['fullname']) ?>"
                                    data-nickname="<?= htmlspecialchars($user['nickname']) ?>"
                                    data-role="<?= htmlspecialchars($user['role']) ?>"
                                    data-email="<?= htmlspecialchars($user['email']) ?>"
                                    data-designation="<?= htmlspecialchars($user['designation']) ?>">
                                    Update
                                </button>

                                <?php if ($user['status'] == 1): ?>
                                    <button class="bg-red-500 text-white py-1 px-3 rounded-md togglerDeleteUser" 
                                    data-id="<?= htmlspecialchars($user['id']) ?>">
                                    Deactivate
                                </button>
                                <?php else: ?>
                                    <button class="bg-green-500 text-white py-1 px-3 rounded-md togglerRestoreUser" 
                                    data-id="<?= htmlspecialchars($user['id']) ?>">
                                    Activate
                                </button>
                                <?php endif; ?>
                               
                            </td>
                        <?php } ?>
                    </tr>

                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="p-2 text-center">No record found.</td>
                    </tr>
                <?php endif; ?>