<?php
session_start();
include('backend/class.php');

$db = new global_class();

$maintenance = $db->fetch_maintenance();

if (isset($_SESSION['id'])) {
    $id = intval($_SESSION['id']);


    $On_Session = $db->check_account($id);

    //    echo "<pre>";
    //    print_r($On_Session);
    //    echo "</pre>";



    // if (!empty($On_Session)) {
    //     if($_SESSION['role']!="Administrator"){
    //       header('location: ../home');
    //     }
    // } else {
    //    header('location: ../');
    // }
} else {
    header('location: ../');
}


// $conn = mysqli_connect("localhost", "u680385054_procurement", "@Mk5^vnVJ", "u680385054_pro");
$conn = mysqli_connect("localhost", "root", "", "pam");

// include('../connection_short.php');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


// function isNavClosed($conn, $navId, $userType)
// {
//     if ($userType == "Administrator") {
//         return false;
//     } else {
//         $stmt = $conn->prepare("SELECT is_closed FROM maintenance_table WHERE id = ?");
//         $stmt->bind_param("i", $navId); // assuming $navId is an integer
//         $stmt->execute();
//         $result = $stmt->get_result();

//         if ($row = $result->fetch_assoc()) {
//             return (int)$row['is_closed'] === 1; // returns true if closed
//         }

//         return false; // explicitly return false if not found
//     }
// }

function isNavClosed($conn, $navId, $userType, $userId)
{
    // Allow Administrator and Head Maintenance full access
    if ($userType == "Administrator" || $userType == "Head Maintenance") {
        return false;
    }

    // First, check general navigation lock from maintenance_table
    $stmt = $conn->prepare("SELECT is_closed FROM maintenance_table WHERE id = ?");
    $stmt->bind_param("i", $navId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if ((int)$row['is_closed'] === 1) {
            return true; // Globally closed
        }
    }

    // If not globally closed, check per user in maintenance_table_user
    $stmt = $conn->prepare("SELECT is_closed FROM maintenance_table_user WHERE user_id = ? AND name = (SELECT name FROM maintenance_table WHERE id = ? LIMIT 1) LIMIT 1");
    $stmt->bind_param("ii", $userId, $navId);
    $stmt->execute();
    $userResult = $stmt->get_result();

    if ($userRow = $userResult->fetch_assoc()) {
        return (int)$userRow['is_closed'] === 1; // true if user's navigation is closed
    }

    return false; // Default to open if no user record found
}



?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procurement & Assets Management System</title>
    <link rel="icon" type="image/png" href="../assets/logo/<?= $maintenance['system_image'] ?>">

    <script src="https://cdn.tailwindcss.com"></script>

    <!-- AlertifyJS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.css" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js" crossorigin="anonymous"></script>

    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- ONLY DataTables core (NO Bootstrap) -->
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>

<body class="bg-gray-100 font-sans antialiased ">



    <?php include "../function/PageSpinner.php"; ?>


    <input hidden type="text" id="user_type" value="<?= $On_Session[0]['role'] ?>">
    <input hidden type="text" id="session_user_id" value="<?= $On_Session[0]['id'] ?>">


    <div class="min-h-screen flex flex-col lg:flex-row">

        <aside id="sidebar" class="bg-gradient-to-br from-red-900 to-red-700 shadow-lg w-64 lg:w-1/5 xl:w-1/6 p-6 space-y-6 lg:static fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">

            <!-- Hide Sidebar Button -->
            <div class="flex items-center space-x-4 p-4 bg-gradient-to-br from-red-900 to-red-700 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 max-w-full">
                <img src="../assets/logo/<?= $maintenance['system_image'] ?>" alt="Logo" class="w-20 h-20 rounded-full border-2 border-gray-300 shadow-sm transform transition-transform duration-300 hover:scale-105">
                <h1 class="text-xl font-bold text-white tracking-tight text-left truncate lg:text-left hover:text-yellow-300 transition-colors duration-300 max-w-[70%]">
                    <?
                    if ($On_Session[0]['role'] == "Administrator") {
                        echo 'System Admin';
                    } else if ($On_Session[0]['role'] == "Head Finance") {
                        echo 'Proc. Officer';
                    }
                    ?>
                    <?php if ($_SESSION['role'] == "Finance" || $_SESSION['role'] == "Library" || $_SESSION['role'] == "Basic Education" || $_SESSION['role'] == "IACEPO & NSTP") { ?>
                        <small style="font-size:11px;" class="text-white">(Secretary)</small>
                    <?php } else { ?>
                    <?php } ?>

                </h1>

            </div>


            <nav class="space-y-4 text-left lg:text-left sticky-top">

                <?php if ($_SESSION['role'] == "Administrator" || $_SESSION['role'] == "Office Heads") { ?>


                    <a href="dashboard" class="flex items-center lg:justify-start space-x-3 text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">
                        <span class="material-icons">dashboard</span>
                        <span>Dashboard</span>
                    </a>

                    <a href="users" class="flex items-center lg:justify-start space-x-3 text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">
                        <span class="material-icons">manage_accounts</span>
                        <span>User Management</span>
                    </a>

                    <a href="receive_logs" class="flex items-center lg:justify-start space-x-3 text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">
                        <span class="material-icons">inventory</span>
                        <span>Receive Logs</span>
                    </a>


                    <?php if (isNavClosed($conn, 10, $On_Session[0]['role'], $On_Session[0]['id'])) { ?>
                        <a href="close" class="flex items-center lg:justify-start space-x-3 text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">
                            <span class="material-icons">manage_accounts</span>
                            <span>Requisition</span>
                        </a>
                    <?php  } else { ?>
                        <a href="request" class="flex items-center lg:justify-start space-x-3 text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">
                            <span class="material-icons">manage_accounts</span>
                            <span>Requisition</span>
                        </a>
                    <?php } ?>



                <?php } ?>


                <?php if ($_SESSION['role'] == "Finance" || $_SESSION['role'] == "Library" || $_SESSION['role'] == "Basic Education" || $_SESSION['role'] == "IACEPO & NSTP") { ?>


                <?php } else { ?>

                    <a href="receive_logs" class="flex items-center lg:justify-start space-x-3 text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">
                        <span class="material-icons">inventory</span>
                        <span>Receive Logs</span>
                    </a>
                    <?php if (isNavClosed($conn, 1, $On_Session[0]['role'], $On_Session[0]['id'])) { ?>
                        <a href="close" class="flex items-center lg:justify-start space-x-3 text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">
                            <span class="material-icons">shopping_cart</span>
                            <span>Procurements</span>
                            <?php if ($_SESSION['role'] == "Administrator" || $_SESSION['role'] == "Office Heads") { ?>
                                <span id="PendingCounts" class="bg-red-500 text-white text-xs font-semibold rounded-full w-5 h-5 flex items-center justify-center ">
                                    0
                                </span>
                            <?php } ?>
                        </a>
                    <?php  } else { ?>

                        <?php if ($_SESSION['role'] == "Head Maintenance") { ?>

                            <a href="request" class="flex items-center lg:justify-start space-x-3 text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">
                                <span class="material-icons">manage_accounts</span>
                                <span>Requisition</span>
                            </a>

                            <button id="toggleAssets" class="w-full flex items-center justify-between text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">
                                <div class="flex items-center space-x-3">
                                    <span class="material-icons">work</span>
                                    <span>Inventory</span>
                                </div>
                                <span class="material-icons">expand_more</span>
                            </button>
                            <div id="assetsDropdown" class="ml-8 space-y-2 hidden">
                                <!-- <a href="receive_logs" class="block text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">➤ Receive Logs</a> -->

                                <a href="manage_assets.php?id=10" class="block text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">➤ Assets</a>

                                <a href="inventory" class="block text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">➤ Inventory</a>

                            </div>
                            <a href="maintenance-item" class="flex items-center lg:justify-start space-x-3 text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">
                                <span class="material-icons">build</span>

                                <span>Maintenance</span>
                            </a>


                        <?php  } else { ?>
                            <a href="requestManagement" class="flex items-center lg:justify-start space-x-3 text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">
                                <span class="material-icons">shopping_cart</span>
                                <span>Procurements</span>
                                <?php if ($_SESSION['role'] == "Administrator" || $_SESSION['role'] == "Office Heads") { ?>
                                    <span id="PendingCounts" class="bg-red-500 text-white text-xs font-semibold rounded-full w-5 h-5 flex items-center justify-center ">
                                        0
                                    </span>
                                <?php } ?>
                            </a>
                        <?php } ?>


                    <?php } ?>


                <?php } ?>


                <?php if (isNavClosed($conn, 2, $On_Session[0]['role'], $On_Session[0]['id'])) { ?>
                    <?php if ($_SESSION['role'] == "Head Finance" || $_SESSION['role'] == "Administrator" || $_SESSION['role'] == "Office Heads") { ?>
                        <a href="close" class="flex items-center lg:justify-start space-x-3 text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">
                            <span class="material-icons">receipt_long</span>
                            <span>Purchase Order</span>
                        </a>
                    <?php } ?>
                <?php  } else { ?>
                    <?php if ($_SESSION['role'] == "Head Finance" || $_SESSION['role'] == "Administrator" || $_SESSION['role'] == "Office Heads") { ?>
                        <a href="purchase-order" class="flex items-center lg:justify-start space-x-3 text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">
                            <span class="material-icons">receipt_long</span>
                            <span>Purchase Order</span>
                        </a>
                    <?php } ?>
                <?php } ?>

                <?php if (isNavClosed($conn, 10, $On_Session[0]['role'], $On_Session[0]['id'])) { ?>
                    <?php if ($_SESSION['role'] == "Finance" || $_SESSION['role'] == "Library" || $_SESSION['role'] == "Basic Education" || $_SESSION['role'] == "IACEPO & NSTP") { ?>
                        <a href="close" class="flex items-center lg:justify-start space-x-3 text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">
                            <span class="material-icons">manage_accounts</span>
                            <span>Requisition</span>
                        </a>
                    <?php } ?>
                <?php  } else { ?>
                    <?php if ($_SESSION['role'] == "Finance" || $_SESSION['role'] == "Library" || $_SESSION['role'] == "Basic Education" || $_SESSION['role'] == "IACEPO & NSTP") { ?>
                        <a href="request" class="flex items-center lg:justify-start space-x-3 text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">
                            <span class="material-icons">manage_accounts</span>
                            <span>Requisition</span>
                        </a>
                    <?php } ?>
                <?php } ?>


                <?php if ($_SESSION['role'] == "Administrator" || $_SESSION['role'] == "Office Heads") { ?>



                    <button id="toggleAssets" class="w-full flex items-center justify-between text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">
                        <div class="flex items-center space-x-3">
                            <span class="material-icons">work</span>
                            <span>Inventory</span>
                        </div>
                        <span class="material-icons">expand_more</span>
                    </button>
                    <div id="assetsDropdown" class="ml-8 space-y-2 hidden">
                        <?php if (isNavClosed($conn, 9, $On_Session[0]['role'], $On_Session[0]['id'])) { ?>
                            <a href="close" class="block text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">➤ Receive Logs</a>
                        <?php  } else { ?>
                            <!-- <a href="receive_logs" class="block text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">➤ Receive Logs</a> -->
                        <?php } ?>


                        <?php if (isNavClosed($conn, 6, $On_Session[0]['role'], $On_Session[0]['id'])) { ?>
                            <a href="close" class="block text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">➤ Assets</a>
                        <?php  } else { ?>
                            <a href="manage_assets.php?id=10" class="block text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">➤ Assets</a>
                        <?php } ?>

                        <?php if (isNavClosed($conn, 8, $On_Session[0]['role'], $On_Session[0]['id'])) { ?>
                            <a href="close" class="block text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">➤ Inventory</a>
                        <?php  } else { ?>
                            <a href="inventory" class="block text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">➤ Inventory</a>
                        <?php } ?>
                    </div>

                    <a href="maintinance" class="flex items-center lg:justify-start space-x-3 text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">
                        <span class="material-icons">construction</span>
                        <span>System Maintenance</span>
                        <?php if ($_SESSION['role'] == "Administrator" || $_SESSION['role'] == "Office Heads") { ?>
                            <span id="UnderMaintenanceCounts" class="bg-red-500 text-white text-xs font-semibold rounded-full w-5 h-5 flex items-center justify-center ">
                                0
                            </span>
                        <?php } ?>
                    </a>

                    <a href="maintenance-item" class="flex items-center lg:justify-start space-x-3 text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">
                        <span class="material-icons">build</span>

                        <span>Maintenance</span>
                    </a>

                    <?php if (isNavClosed($conn, 4, $On_Session[0]['role'], $On_Session[0]['id'])) { ?>
                        <a href="close" class="flex items-center lg:justify-start space-x-3 text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">
                            <span class="material-icons">bar_chart</span>
                            <span>Report Generation</span>
                        </a>
                    <?php  } else { ?>
                        <a href="reports" class="flex items-center lg:justify-start space-x-3 text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">
                            <span class="material-icons">bar_chart</span>
                            <span>Report Generation</span>
                        </a>
                    <?php } ?>


                <?php } ?>


                <?php if (isNavClosed($conn, 5, $On_Session[0]['role'], $On_Session[0]['id'])) { ?>
                    <a href="close" class="flex items-center lg:justify-start space-x-3 text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">
                        <span class="material-icons">settings</span>
                        <span>Account Settings</span>
                    </a>

                <?php  } else { ?>
                    <a href="settings" class="flex items-center lg:justify-start space-x-3 text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">
                        <span class="material-icons">settings</span>
                        <span>Account Settings</span>
                    </a>

                <?php } ?>


                <?php if ($_SESSION['role'] == "Administrator" || $_SESSION['role'] == "Head Finance") { ?>
                    <a href="supplier" class="flex items-center lg:justify-start space-x-3 text-gray-200 hover:text-yellow-300 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">
                        <span class="material-icons">inventory_2</span>
                        <span>Supplier</span>
                    </a>


                <?php } ?>



                <button class="btnLogout flex items-center lg:justify-start space-x-3 text-gray-200 hover:text-red-500 hover:bg-gray-800 px-4 py-2 rounded-md transition-all duration-300">
                    <span class="material-icons">logout</span>
                    <span>Logout</span>
                </button>

            </nav>
        </aside>





        <!-- Overlay for Mobile Sidebar -->
        <div id="overlay" class="fixed inset-0 bg-black opacity-50 hidden lg:hidden z-40"></div>

        <!-- Main Content -->
        <main class="flex-1 bg-gray-50 p-8 lg:p-12">
            <!-- Mobile menu button -->
            <button id="menuButton" class="lg:hidden text-gray-700 mb-4">
                <span class="material-icons">menu</span>
            </button>