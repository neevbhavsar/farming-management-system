<?php
include('includes/db.php');

if (isset($_POST['register'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
  $location = $_POST['location'];

  if ($password !== $confirm_password) {
    echo "<script>alert('❌ Passwords do not match!');</script>";
  } else {
    // Check if email already exists
    $check = $conn->prepare("SELECT * FROM users WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
      echo "<script>alert('⚠️ Email already registered! Please login.');</script>";
    } else {
      $query = $conn->prepare("INSERT INTO users(name, email, password, location) VALUES(?, ?, ?, ?)");
      $query->bind_param("ssss", $name, $email, $password, $location);
      if ($query->execute()) {
        echo "<script>alert('✅ Registration successful! Please login.'); window.location='login.php';</script>";
      } else {
        echo "<script>alert('❌ Error registering! Please try again.');</script>";
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Farmer Registration | Farming Management System</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Floating farm objects */
    .object {
      position: absolute;
      width: 60px;
      height: 60px;
      opacity: 0.3;
      animation: float 15s linear infinite;
    }
    .object1 { top: 10%; left: 10%; animation-duration: 16s; }
    .object2 { top: 50%; left: 75%; animation-duration: 18s; }
    .object3 { top: 80%; left: 40%; animation-duration: 20s; }

    @keyframes float {
      0% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(-10px) rotate(5deg); }
      100% { transform: translateY(0px) rotate(0deg); }
    }
  </style>
</head>
<body class="bg-gradient-to-br from-green-100 to-green-200 flex justify-center items-center h-screen relative overflow-hidden">

  <!-- Registration Card -->
  <div class="bg-white p-10 rounded-3xl shadow-xl w-full max-w-2xl relative z-10">
    <div class="text-center mb-6">
      <h2 class="text-3xl font-extrabold text-green-700 mb-2">🌱 Farmer Registration 🚜</h2>
      <p class="text-gray-600">Create your account to manage your farm</p>
    </div>

    <form action="" method="POST" class="space-y-4">
      <div>
        <label class="block text-gray-700 mb-1">Full Name 👨‍🌾</label>
        <input type="text" name="name" placeholder="Your Full Name" class="w-full p-3 border border-green-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-300" required>
      </div>
      <div>
        <label class="block text-gray-700 mb-1">Email ✉️</label>
        <input type="email" name="email" placeholder="Email Address" class="w-full p-3 border border-green-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-300" required>
      </div>
      <div>
        <label class="block text-gray-700 mb-1">Password 🔒</label>
        <input type="password" name="password" placeholder="Password" class="w-full p-3 border border-green-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-300" required>
      </div>
      <div>
        <label class="block text-gray-700 mb-1">Confirm Password 🔁</label>
        <input type="password" name="confirm_password" placeholder="Confirm Password" class="w-full p-3 border border-green-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-300" required>
      </div>
      <div>
        <label class="block text-gray-700 mb-1">Location 📍</label>
        <input type="text" name="location" placeholder="City / State" class="w-full p-3 border border-green-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-300" required>
      </div>

      <button type="submit" name="register" class="w-full bg-green-500 text-white py-3 rounded-xl font-semibold hover:bg-green-600 transition">Register</button>
    </form>

    <p class="text-sm text-center text-gray-600 mt-4">Already have an account? 
      <a href="login.php" class="text-green-600 font-semibold hover:underline">Login</a>
    </p>
  </div>

</body>
</html>
