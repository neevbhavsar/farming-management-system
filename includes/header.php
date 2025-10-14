<?php
session_start();
include('db.php');

// Redirect if user not logged in
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch logged-in user details
$email = $_SESSION['user'];
$query = $conn->prepare("SELECT * FROM users WHERE email=?");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Farming Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">

<!-- Sidebar -->
<aside class="w-72 bg-green-700 h-screen p-6 text-white flex flex-col fixed">
    <h2 class="text-2xl font-bold mb-8 flex items-center space-x-2">
        <span>🌾</span><span>FMS Dashboard</span>
    </h2>
    <nav class="flex-1">
        <a href="../index.php" class="block mb-3 py-2 px-4 rounded hover:bg-green-600 transition">Dashboard</a>
        <a href="../pages/weather.php" class="block mb-3 py-2 px-4 rounded hover:bg-green-600 transition">Weather Forecast</a>
        <a href="../pages/soil_quality.php" class="block mb-3 py-2 px-4 rounded hover:bg-green-600 transition">Soil Quality</a>
        <a href="../pages/fertilizer.php" class="block mb-3 py-2 px-4 rounded hover:bg-green-600 transition">Fertilizer Check</a>
        <a href="../pages/fertilizer_history.php" class="block mb-3 py-2 px-4 rounded hover:bg-green-600 transition">Fertilizer History</a>
        <a href="../pages/schemes.php" class="block mb-3 py-2 px-4 rounded hover:bg-green-600 transition">Government Schemes</a>
        <a href="../pages/schedule.php" class="block mb-3 py-2 px-4 rounded hover:bg-green-600 transition">Work Scheduler</a>
    </nav>
    <a href="../logout.php" class="mt-auto py-2 px-4 rounded bg-red-600 hover:bg-red-700 text-center transition">Logout</a>
</aside>

<!-- Main Content Wrapper -->
<div class="ml-72 flex-1 flex flex-col min-h-screen">

    <!-- Topbar -->
    <header class="bg-white shadow flex justify-between items-center px-8 py-4 sticky top-0 z-50">
        <h1 class="text-2xl font-bold text-green-700">🌱 Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
        <p class="text-gray-500 text-sm">Location: <?php echo htmlspecialchars($user['location']); ?></p>
    </header>

    <!-- Start Main Content -->
    <main class="flex-1 p-8">
