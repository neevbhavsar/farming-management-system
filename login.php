<?php
include('includes/db.php');
session_start();

if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Prepared statement for security
  $query = $conn->prepare("SELECT * FROM users WHERE email=? AND password=?");
  $query->bind_param("ss", $email, $password);
  $query->execute();
  $result = $query->get_result();

  if ($result->num_rows > 0) {
    $_SESSION['user'] = $email;
    header("Location: index.php");
    exit();
  } else {
    echo "<script>alert('❌ Invalid Email or Password');</script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Farmer Login | Farming Management System</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Soft floating farm objects */
    .object {
      position: absolute;
      width: 70px;
      height: 70px;
      opacity: 0.3;
      animation: float 15s linear infinite;
    }
    .object1 { top: 10%; left: 15%; animation-duration: 16s; }
    .object2 { top: 60%; left: 75%; animation-duration: 20s; }
    .object3 { top: 80%; left: 35%; animation-duration: 18s; }

    @keyframes float {
      0% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(-10px) rotate(5deg); }
      100% { transform: translateY(0px) rotate(0deg); }
    }

    body::-webkit-scrollbar {
      width: 6px;
    }
    body::-webkit-scrollbar-thumb {
      background-color: #a7f3d0;
      border-radius: 3px;
    }
  </style>
</head>
<body class="bg-gradient-to-br from-green-100 to-green-200 flex justify-center items-center h-screen relative overflow-hidden">

  <!-- Login Card -->
  <div class="bg-white p-10 rounded-3xl shadow-xl w-full max-w-md relative z-10">
    <div class="text-center mb-6">
      <h2 class="text-3xl font-extrabold text-green-700 mb-2">🌾 Farmer Login 🚜</h2>
      <p class="text-gray-600">Access your farm management dashboard</p>
    </div>

    <form action="" method="POST" class="space-y-5">
      <div>
        <label class="block text-gray-700 mb-1">Email ✉️</label>
        <input type="email" name="email" placeholder="Email Address" class="w-full p-3 border border-green-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-300" required>
      </div>
      <div>
        <label class="block text-gray-700 mb-1">Password 🔒</label>
        <input type="password" name="password" placeholder="Password" class="w-full p-3 border border-green-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-300" required>
      </div>
      <button type="submit" name="login" class="w-full bg-green-500 text-white py-3 rounded-xl font-semibold hover:bg-green-600 transition">Login</button>
    </form>

    <p class="text-sm text-center text-gray-600 mt-4">Don’t have an account? 
      <a href="register.php" class="text-green-600 font-semibold hover:underline">Register</a>
    </p>
  </div>

</body>
</html>
