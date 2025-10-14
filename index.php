<?php
session_start();
include('includes/db.php');

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Fetch user info
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
    <title>Dashboard | Farming Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">

    <!-- Sidebar -->
    <div class="w-64 bg-green-700 h-screen p-6 text-white flex flex-col">
        <h2 class="text-2xl font-bold mb-8">🌾 FMS Dashboard</h2>
        <a href="index.php" class="mb-4 py-2 px-4 rounded hover:bg-green-600 transition">Dashboard</a>
        <a href="pages/weather.php" class="mb-4 py-2 px-4 rounded hover:bg-green-600 transition">Weather Forecast</a>
        <a href="pages/soil_quality.php" class="mb-4 py-2 px-4 rounded hover:bg-green-600 transition">Soil Quality</a>
        <a href="pages/fertilizer.php" class="mb-4 py-2 px-4 rounded hover:bg-green-600 transition">Fertilizer Check</a>
        <a href="pages/fertilizer_history.php" class="block mb-3 py-2 px-4 rounded hover:bg-green-600 transition">Fertilizer History</a>
        <a href="pages/schemes.php" class="mb-4 py-2 px-4 rounded hover:bg-green-600 transition">Government Schemes</a>
        <a href="pages/schedule.php" class="mb-4 py-2 px-4 rounded hover:bg-green-600 transition">Work Scheduler</a>
        <a href="logout.php" class="mt-auto py-2 px-4 rounded hover:bg-red-600 transition">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-10">
        <h1 class="text-3xl font-bold text-green-700 mb-4">Welcome, <?php echo $user['name']; ?>! 🌱</h1>
        <p class="text-gray-700 mb-6">Use the sidebar to navigate through your Farming Management System modules:</p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="pages/weather.php" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <h2 class="font-bold text-green-700 text-xl mb-2">Weather Forecast</h2>
                <p>Check real-time weather updates for your location.</p>
            </a>
            <a href="pages/soil_quality.php" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <h2 class="font-bold text-green-700 text-xl mb-2">Soil Quality</h2>
                <p>Analyze your field's soil health and get recommendations.</p>
            </a>
            <a href="pages/fertilizer.php" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <h2 class="font-bold text-green-700 text-xl mb-2">Fertilizer Check</h2>
                <p>Evaluate fertilizer quality and usage tips.</p>
            </a>
            <a href="pages/schemes.php" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <h2 class="font-bold text-green-700 text-xl mb-2">Government Schemes</h2>
                <p>Explore latest agricultural schemes beneficial for farmers.</p>
            </a>
            <a href="pages/schedule.php" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <h2 class="font-bold text-green-700 text-xl mb-2">Work Scheduler</h2>
                <p>Plan and track your daily farming tasks effectively.</p>
            </a>
        </div>
    </div>

</body>
</html>
