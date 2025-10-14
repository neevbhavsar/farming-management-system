<?php
session_start();
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true){
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<!-- Sidebar -->
<div class="fixed top-0 left-0 h-full w-64 bg-green-700 text-white flex flex-col justify-between">
    <!-- Top navigation links -->
    <div>
        <div class="p-6 text-2xl font-bold border-b border-green-600">Farm Admin</div>
        <nav class="mt-6 flex flex-col">
            <a href="dashboard.php" class="block py-3 px-6 hover:bg-green-600 transition">Dashboard</a>
            <a href="manage_users.php" class="block py-3 px-6 hover:bg-green-600 transition">Manage Users</a>
            <a href="manage_schemes.php" class="block py-3 px-6 hover:bg-green-600 transition">Manage Schemes</a>
            <a href="../pages/weather.php" class="block py-3 px-6 hover:bg-green-600 transition">Weather</a>
        </nav>
    </div>

    <!-- Logout button at bottom -->
    <div class="p-6">
        <a href="./logout.php" class="block py-3 px-6 bg-red-600 hover:bg-red-500 text-white text-center rounded transition">Logout</a>
    </div>
</div>


<!-- Topbar -->
<div class="ml-64 h-16 bg-white flex items-center justify-between px-6 shadow fixed top-0 left-0 right-0 z-10">
    <h1 class="text-xl font-bold text-green-700">Admin Dashboard</h1>
    <span class="text-gray-700">Welcome, <?php echo $_SESSION['admin_username']; ?></span>
</div>

<!-- Page content wrapper -->

<!-- Your dashboard content goes here -->
