<?php
session_start();
include('backend/class.php');
$db = new global_class();
$maintenance = $db->fetch_maintenance();
if (isset($_SESSION['id'])) {
  header("location: view/users");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Procurement & Assets Management System</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/png" href="assets/logo/<?= $maintenance['system_image'] ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js"></script>
</head>

<!-- <body class="min-h-screen bg-gradient-to-br from-red-900 to-red-700 flex items-center justify-center px-4 py-10"> -->

<body class="min-h-screen bg-cover bg-center flex items-center justify-center px-4 py-10" style="background-image: url('background.jpeg');">
  <div class="bg-white bg-opacity-80 p-8 rounded shadow-lg">
    <?php include "function/PageSpinner.php"; ?>

    <div class="bg-white bg-opacity-90 rounded-xl shadow-lg w-full max-w-5xl grid grid-cols-1 md:grid-cols-2 overflow-hidden backdrop-blur-sm">

      <!-- Left side: Description -->
      <div class="bg-red-800 text-white flex flex-col justify-center items-center p-8 md:p-12">
        <img src="assets/logo/<?= $maintenance['system_image'] ?>" alt="Logo" class="w-24 h-24 object-contain mb-4 rounded-full shadow-lg bg-white p-1">
        <h1 class="text-1xl font-bold mb-2">Procurement & Assets Management System</h1>
        <p class="text-center text-sm md:text-base">Welcome to the <?= $maintenance['system_name'] ?> portal. Please sign in to continue.</p>
      </div>

      <!-- Right side: Login form -->
      <div class="p-6 sm:p-8 relative">

        <!-- Spinner -->
        <div class="spinner" id="spinner" style="display:none;">
          <div class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center">
            <div class="w-10 h-10 border-4 border-red-700 border-t-transparent rounded-full animate-spin"></div>
          </div>
        </div>

        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-800 mb-6 text-center">Login</h2>

        <form id="frmLogin" class="space-y-5">
          <div>
            <label for="email" class="block text-sm font-semibold text-gray-700">Username</label>
            <input type="text" id="email" name="email" class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
          </div>
          <div class="mb-4">
            <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
            <div class="relative">
              <input type="password" id="password" name="password" class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10">
              <button type="button" onclick="toggleIndexPassword()" class="absolute right-3 top-3 text-sm text-gray-600">
                👁️
              </button>
            </div>
          </div>
          <script>
            function toggleIndexPassword() {
              const input = document.getElementById('password');
              input.type = input.type === 'password' ? 'text' : 'password';
            }
          </script>


          <div>
            <button type="submit" id="btnLogin" class="w-full py-3 px-4 rounded-lg shadow-md text-sm font-semibold text-white bg-red-800 hover:bg-red-900 transition duration-200">
              Sign in
            </button>
            <div class="text-center mt-3">
              <a href="forgot" class="text-sm text-red-700 hover:underline">Forgot password?</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script src="assets/js/app.js"></script>
</body>

</html>