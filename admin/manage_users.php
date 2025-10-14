<?php
session_start();
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true){
    header("Location: login.php");
    exit;
}

include('../includes/db.php');
include('includes/header.php'); // Includes sidebar and topbar
?>

<div class="ml-64 mt-16 p-6">

    <h2 class="text-3xl font-bold text-green-700 mb-6">Manage Users</h2>

    <?php
    // Delete User
    if(isset($_GET['delete'])){
        $id = (int)$_GET['delete'];
        $conn->query("DELETE FROM users WHERE id=$id");
        echo "<p class='text-red-600 font-bold mb-4'>🗑️ User deleted!</p>";
    }

    // Pagination setup
    $limit = 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    $totalResult = $conn->query("SELECT COUNT(*) as total FROM users");
    $totalRow = $totalResult->fetch_assoc();
    $totalUsers = $totalRow['total'];
    $totalPages = ceil($totalUsers / $limit);

    $result = $conn->query("SELECT * FROM users ORDER BY created_at DESC LIMIT $offset, $limit");
    ?>

    <!-- Users Table -->
    <div class="overflow-x-auto bg-white rounded-xl shadow p-4">
        <table class="table-auto w-full">
            <thead>
                <tr class="bg-green-700 text-white">
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Location</th>
                    <th class="px-4 py-2">Registered At</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr class="text-center border-b hover:bg-gray-50">
                            <td class="px-4 py-2"><?php echo $row['id']; ?></td>
                            <td class="px-4 py-2"><?php echo $row['name']; ?></td>
                            <td class="px-4 py-2"><?php echo $row['email']; ?></td>
                            <td class="px-4 py-2"><?php echo $row['location']; ?></td>
                            <td class="px-4 py-2"><?php echo $row['created_at']; ?></td>
                            <td class="px-4 py-2">
                                <a href="?delete=<?php echo $row['id']; ?>" 
                                   onclick="return confirm('Are you sure you want to delete this user?');" 
                                   class="text-red-600 hover:underline font-semibold">
                                   Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if($totalPages > 1): ?>
        <div class="mt-6 flex justify-center space-x-2">
            <?php for($i=1; $i<=$totalPages; $i++): ?>
                <?php 
                    $active = ($i == $page) ? "bg-green-600 text-white" : "bg-gray-200 text-gray-700 hover:bg-gray-300";
                ?>
                <a href="?page=<?php echo $i; ?>" class="px-4 py-2 rounded-lg <?php echo $active; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>

</div>

<?php include('includes/footer.php'); ?>
