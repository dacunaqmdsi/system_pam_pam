


<?php 
include "components/header.php";

if($On_Session[0]['role']!="Administrator"){
   echo "<script>window.location.href = 'requestManagement';</script>";
}
?>

<!-- Top bar with user profile -->
<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Home</h2>
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










</div>



<?php include "components/footer.php";?>