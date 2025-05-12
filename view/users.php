<?php include "components/header.php"; ?>


<?php

if ($_SESSION['role'] == "Administrator" || $_SESSION['role'] == "Office Heads") {

?>

    <!-- Top bar with user profile -->
    <div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
        <h2 class="text-lg font-semibold text-gray-700">Manage Users</h2>
        <div class="flex items-center space-x-3">
            <?php
            $userImage = !empty($On_Session[0]['profile_picture']) ? $On_Session[0]['profile_picture'] : null;


            ?>
            <div class="w-10 h-10 rounded-full overflow-hidden flex items-center justify-center bg-gray-200 text-gray-600">
                <?php if ($userImage): ?>
                    <img src="../uploads/images/<?php echo $userImage; ?>" alt="User Avatar" class="w-full h-full object-cover">
                <?php else: ?>
                    <span class="material-icons text-3xl">account_circle</span>
                <?php endif; ?>
            </div>
            <span class="text-gray-700 font-medium">
                <?php echo ucfirst($On_Session[0]['fullname']); ?>
            </span>
        </div>
    </div>



    <!-- Search Input with Icon -->
    <div class="relative mb-4 w-full max-w-md">
        <span class="absolute inset-y-0 left-3 flex items-center text-gray-500">
            <i class="material-icons text-lg">search</i>
        </span>
        <input type="text" id="searchInput" placeholder="Search users..."
            class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-400 focus:border-red-400 transition">
    </div>
    <script>
        $(document).ready(function() {
            $('#userTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true
            });
        });
    </script>
    <!-- User Table Card -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <button id="adduserButton" class="bg-red-500 text-white py-2 px-4 text-sm rounded-lg flex items-center hover:bg-red-600 transition duration-300 mb-4">
            <span class="material-icons mr-2 text-base">person_add</span>
            Add New
        </button>

        <!-- Table Wrapper for Responsiveness -->
        <div class="overflow-x-auto">
            <table id="userTable" class="table-auto w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-3">ID</th>
                        <th class="p-3">User Image</th>
                        <th class="p-3">Fullname</th>
                        <th class="p-3">Nickname</th>
                        <th class="p-3">Username</th>
                        <th class="p-3">User Type</th>
                        <th class="p-3">Created At</th>
                        <th class="p-3">Office Designation</th>
                        <th class="p-3">Password</th>
                        <th class="p-3">Status</th>

                        <?php if ($On_Session[0]['role'] == "Administrator") {
                            echo '<th class="p-3">Action</th>';
                        } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php include "backend/end-points/user_list.php"; ?>
                </tbody>
            </table>
        </div>
    </div>


    <div id="updateUserModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display:none;">
        <div class="bg-white rounded-lg shadow-lg w-[40rem] p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Update User</h3>
            <form id="updateUserForm">

                <div class="spinner" id="spinner" style="display:none;">
                    <div class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center">
                        <div class="w-10 h-10 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
                    </div>
                </div>

                <input hidden type="text" id="update_id" name="update_id">



                <div class="mb-4">
                    <label for="update_user_id" class="block text-sm font-medium text-gray-700">User ID</label>
                    <input type="text" id="update_user_id" name="update_user_id" class="w-full p-2 border rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="update_user_fullname" class="block text-sm font-medium text-gray-700">Fullname</label>
                    <input type="text" id="update_user_fullname" name="user_fullname" class="w-full p-2 border rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="update_user_nickname" class="block text-sm font-medium text-gray-700">Nickname</label>
                    <input type="text" id="update_user_nickname" name="user_nickname" class="w-full p-2 border rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="update_user_email" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" id="update_user_email" name="user_email" class="w-full p-2 border rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="update_user_type" class="block text-sm font-medium text-gray-700">User Type</label>
                    <select name="user_type" id="update_user_type" class="w-full p-2 border rounded-md" required>
                        <option value="Administrator">Administrator</option>
                        <option value="Office Heads">Office Heads</option>
                        <option value="IACEPO & NSTP">IACEPO & NSTP</option>
                        <option value="Finance">Finance</option>
                        <option value="Library">Library</option>
                        <option value="Basic Education">Basic Education</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="update_user_designation" class="block text-sm font-medium text-gray-700">Office Designation</label>
                    <select name="user_designation" id="update_user_designation" class="w-full p-2 border rounded-md" required>
                        <option value="Registrar's Office">Registrar's Office</option>
                        <option value="Finance's Office">Finance's Office</option>
                        <option value="VPAA">VPAA</option>
                        <option value="HRDO">HRDO</option>
                        <option value="WASTFI">WASTFI</option>
                        <option value="Library">Library</option>
                        <option value="Computer Lab">Computer Lab</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="update_user_image" class="block text-sm font-medium text-gray-700">User Image</label>
                    <input type="file" id="update_user_image" name="user_image" class="w-full p-2 border rounded-md">
                </div>

                <div class="mb-4">
                    <label for="update_user_password" class="block text-sm font-medium text-gray-700">New Password</label>
                    <div class="relative">
                        <input type="password" id="update_user_password" name="user_password" class="w-full p-2 border rounded-md pr-10">
                        <button type="button" onclick="toggleUpdatePassword()" class="absolute right-2 top-2 text-sm text-gray-600">
                            👁️
                        </button>
                    </div>
                </div>


                <div class="flex justify-end gap-2">
                    <button type="button" class="updateUserModalClose bg-gray-500 hover:bg-gray-600 text-white py-1 px-3 rounded-md">Cancel</button>
                    <button id="btnUpdateUser" type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-md">Update</button>
                </div>
            </form>
        </div>
    </div>



    <!-- Modal for Adding Promo -->
    <div id="addUserModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display:none;">
        <div class="bg-white rounded-lg shadow-lg w-[40rem] p-6"> <!-- Updated width -->
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Add New User</h3>
            <form id="adduserForm">

                <!-- Spinner -->
                <div class="spinner" id="spinner" style="display:none;">
                    <div class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center">
                        <div class="w-10 h-10 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
                    </div>
                </div>


                <div class="mb-4">
                    <label for="add_user_id" class="block text-sm font-medium text-gray-700">User ID</label>
                    <input type="text" id="add_user_id" name="add_user_id" class="w-full p-2 border rounded-md" required>
                </div>


                <div class="mb-4">
                    <label for="add_user_fullname" class="block text-sm font-medium text-gray-700">Fullname</label>
                    <input type="text" id="add_user_fullname" name="user_fullname" class="w-full p-2 border rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="add_user_nickname" class="block text-sm font-medium text-gray-700">Nickname</label>
                    <input type="text" id="add_user_nickname" name="user_nickname" class="w-full p-2 border rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="add_user_email" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" id="add_user_email" name="user_email" class="w-full p-2 border rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="add_user_email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="text" id="email_official" name="email_official" class="w-full p-2 border rounded-md" required>
                </div>


                <div class="mb-4">
                    <label for="add_user_type" class="block text-sm font-medium text-gray-700">User Type</label>
                    <select name="user_type" id="add_user_type" class="w-full p-2 border rounded-md" required>
                        <option value="Administrator">System Admin</option>
                        <option value="Head Maintenance">Head Maintenance</option>
                        <option value="Office Heads">Office Heads</option>
                        <option value="Head IACEPO & NSTP">Head IACEPO & NSTP</option>
                        <option value="IACEPO & NSTP">IACEPO & NSTP</option>
                        <!-- <option value="Head Finance">Head Finance</option> -->
                        <option value="Head Finance">Procurement Officer</option>
                        <option value="Finance">Finance</option>
                        <option value="Head Library">Head Library</option>
                        <option value="Library">Library</option>
                        <option value="Head Basic Education">Head Basic Education</option>
                        <option value="Basic Education">Basic Education</option>
                        <option value="WASTFI HEAD">WASTFI HEAD</option>
                    </select>
                </div>


                <div class="mb-4">
                    <label for="add_user_designation" class="block text-sm font-medium text-gray-700">Office Designation</label>
                    <select name="user_designation" id="add_user_designation" class="w-full p-2 border rounded-md" required>
                        <option value="Registrar's Office">Registrar's Office</option>
                        <option value="Maintenance">Maintenance</option>
                        <option value="Finance's Office">Finance's Office</option>
                        <option value="VPAA">VPAA</option>
                        <option value="HRDO">HRDO</option>
                        <option value="WASTFI">WASTFI</option>
                        <option value="Library">Library</option>
                        <option value="Computer Lab">Computer Lab</option>
                        <option value="IACEPO/NSTP">IACEPO/NSTP</option>
                    </select>
                </div>


                <div class="mb-4">
                    <label for="add_user_image" class="block text-sm font-medium text-gray-700">User Image</label>
                    <input type="file" id="add_user_image" name="user_image" class="w-full p-2 border rounded-md">
                </div>

                <div class="mb-4">
                    <label for="add_user_password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="relative">
                        <input type="password" id="add_user_password" name="user_password" class="w-full p-2 border rounded-md pr-10" required>
                        <button type="button" onclick="toggleAddPassword()" class="absolute right-2 top-2 text-sm text-gray-600">
                            👁️
                        </button>
                    </div>
                </div>


                <script>
                    function toggleAddPassword() {
                        const input = document.getElementById('add_user_password');
                        input.type = input.type === 'password' ? 'text' : 'password';
                    }

                    function toggleUpdatePassword() {
                        const input = document.getElementById('update_user_password');
                        input.type = input.type === 'password' ? 'text' : 'password';
                    }
                </script>



                <div class="flex justify-end gap-2">
                    <button type="button" class="addUserModalClose bg-gray-500 hover:bg-gray-600 text-white py-1 px-3 rounded-md">Cancel</button>
                    <button id="btnAdduser" type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-md">Add new</button>
                </div>
            </form>
        </div>
    </div>





    <script>
        $(document).ready(function() {
            $("#searchInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#userTable tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>




<?php } else { ?>

    <div class="w-full p-6 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 rounded-lg text-lg">
        <p class="font-bold">You are not authorized here!</p>

    </div>

<?php }  ?>

<?php include "components/footer.php"; ?>