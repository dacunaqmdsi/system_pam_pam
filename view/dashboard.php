<?php include "components/header.php";?>


<?php 
 
 $getDataAnalytics = $db->getDataAnalytics();

//  echo "<pre>";
//  print_r($getDataAnalytics );
//  echo "</pre>";

if($_SESSION['role']=="Administrator" || $_SESSION['role']=="Office Heads"){
        
?>
<!-- Top bar with user profile -->
<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Dashboard</h2>
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

<!-- Dashboard Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Card for Total Customer -->
    <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col items-center">
        <img src="../assets/image/teamwork.png" alt="students icon" class="mb-4 w-12 max-w-full" />
        <h3 class="text-gray-700 font-semibold text-lg">No of Users</h3>
        <p class="text-blue-500 text-2xl font-bold totalUser"><?=$getDataAnalytics['totalUser']?></p>
    </div>

    <!-- Card for Total Sales -->
    <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col items-center">
        <img src="../assets/image/boxes.png" alt="students icon" class="mb-4 w-12 max-w-full" />
        <h3 class="text-gray-700 font-semibold text-lg">No of Assets</h3>
        <p class="text-blue-500 text-2xl font-bold totalBranches"><?=$getDataAnalytics['totalAssets']?></p>
    </div>

    <!-- Card for No of Orders -->
    <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col items-center">
        <img src="../assets/image/job-application.png" alt="students icon" class="mb-4 w-12 max-w-full" />
        <h3 class="text-gray-700 font-semibold text-lg">No of Request</h3>
        <p class="text-blue-500 text-2xl font-bold numOrders totalProduct"><?=$getDataAnalytics['request']?></p>
    </div>
</div>




<!-- Chart Section -->
<div class="bg-white mt-6 p-6 rounded-lg shadow-md">
  <h3 class="text-lg font-semibold text-gray-700 mb-4">Request Overview</h3>
  
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <div id="all_request_chart" class="h-64"></div>
    </div>
    <div>
      <h3 class="text-lg font-semibold text-gray-700 mb-4">Request Item</h3>
      <div id="all_item_chart" class="h-64"></div>
    </div>
  </div>
</div>










</div>


<?php }else{ ?>

    <div class="w-full p-6 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 rounded-lg text-lg">
        <p class="font-bold">You are not authorized here!</p>

    </div>

<?php }  ?>

<?php include "components/footer.php";?>


<script src="assets/js/all_user_request.js"></script>
<script src="assets/js/all_item_request.js"></script>