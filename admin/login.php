<?php
session_start();

$error = '';

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hardcoded credentials
    $admin_user = "admin";
    $admin_pass = "admin123";

    if($username === $admin_user && $password === $admin_pass){
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "❌ Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
    /* Farmer-themed background objects */
    body {
        background: linear-gradient(to top, #c6f6d5 0%, #f0fff4 100%);
        overflow: hidden;
    }
    .object {
        position: absolute;
        width: 80px;
        height: 80px;
        opacity: 0.5;
        animation: float 10s linear infinite;
    }
    .object1 { top: 20%; left: 10%; animation-duration: 12s; }
    .object2 { top: 40%; left: 70%; animation-duration: 15s; }
    .object3 { top: 70%; left: 30%; animation-duration: 18s; }

    @keyframes float {
        0% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(20deg); }
        100% { transform: translateY(0px) rotate(0deg); }
    }
</style>
</head>
<body class="flex items-center justify-center h-screen relative">

    <!-- Login Card -->
    <div class="bg-white p-10 rounded-3xl shadow-2xl w-full max-w-md relative z-10">
        <div class="text-center mb-6">
            <h2 class="text-3xl font-extrabold text-green-700 mb-2">🌾 Admin Login 🌱</h2>
            <p class="text-gray-500">Manage your farm schemes & users</p>
        </div>

        <?php if($error) echo "<p class='text-red-500 mb-4 font-semibold text-center'>$error</p>"; ?>

        <form method="POST" class="space-y-5">
            <div>
                <label class="block mb-1 text-gray-600">Username 👤</label>
                <input type="text" name="username" placeholder="Enter username" class="w-full p-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400" required>
            </div>
            <div>
                <label class="block mb-1 text-gray-600">Password 🔒</label>
                <input type="password" name="password" placeholder="Enter password" class="w-full p-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400" required>
            </div>
            <button type="submit" name="login" class="w-full bg-green-600 text-white py-3 rounded-xl font-semibold hover:bg-green-700 transition">Login</button>
        </form>

        <p class="text-gray-400 text-sm text-center mt-4">© 2025 Farm Admin Panel</p>
    </div>
</body>
</html>
