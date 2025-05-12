<?php include "components/header.php"; ?>

<!-- Top bar with user profile -->
<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Settings</h2>
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

<!-- Form for logo, system name, and color theme -->
<div class="max-w-4xl mx-auto p-6 bg-white rounded-md shadow-md">
    <form id="frmUpdatePassword">
        <!-- Spinner -->
        <div class="spinner" id="spinner" style="display:none;">
            <div class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center">
                <div class="w-10 h-10 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
            </div>
        </div>

        <!-- System Name -->
        <div class="mb-6">
            <label for="email" class="block text-sm font-medium text-gray-700">Username</label>
            <input type="text" id="email" name="email" value="" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 sm:text-sm" placeholder="Enter New User Name" />
        </div>

        <div class="mb-6">
            <label for="fullname" class="block text-sm font-medium text-gray-700">Fullname</label>
            <input type="text" id="fullname" name="fullname" value="" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 sm:text-sm" placeholder="Enter New Full Name" />
        </div>

        <div class="mb-6">
            <label for="nickname" class="block text-sm font-medium text-gray-700">Nickname</label>
            <input type="text" id="nickname" name="nickname" value="" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 sm:text-sm" placeholder="Enter New Nickname" />
        </div>

        <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" id="password" name="password" value="" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 sm:text-sm" placeholder="Enter Password" />
        </div>

        <div class="mb-6">
            <label for="cpassword" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input type="password" id="cpassword" name="cpassword" value="" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 sm:text-sm" placeholder="Enter Confirm Password" />
        </div>
        <div class="mb-6">
            <label for="add_user_image" class="block text-sm font-medium text-gray-700">Update Image</label>
            <input type="file"
                name="user_image"
                accept=".jpg, .jpeg, .png"
                class="w-full p-2 border rounded-md">
        </div>


        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" id="submitBtn" class="inline-flex items-center px-6 py-2 bg-red-600 text-white font-semibold rounded-md shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                Save Changes
            </button>
        </div>
    </form>
</div>





<?php include "components/footer.php"; ?>