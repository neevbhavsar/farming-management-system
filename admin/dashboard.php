<?php
include('includes/header.php');
?>
<div class="ml-64 mt-16 p-6">
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    <a href="manage_users.php" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
        <h3 class="text-xl font-bold text-green-700 mb-2">Manage Users</h3>
        <p>View, edit or delete registered farmers.</p>
    </a>

    <a href="manage_schemes.php" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
        <h3 class="text-xl font-bold text-green-700 mb-2">Manage Schemes</h3>
        <p>Add or update government schemes for farmers.</p>
    </a>

    <a href="../pages/weather.php" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
        <h3 class="text-xl font-bold text-green-700 mb-2">Weather</h3>
        <p>Check the latest weather for different cities.</p>
    </a>

</div>
</div>
<?php
include('includes/footer.php');
?>
