<?php
session_start();
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true){
    header("Location: login.php");
    exit;
}

include('../includes/db.php');
include('includes/header.php'); // Includes sidebar + topbar
?>

<div class="ml-64 mt-16 p-6">

    <h2 class="text-3xl font-extrabold text-green-700 mb-6">🛠️ Admin - Manage Schemes</h2>

    <?php
    // Add Scheme
    if(isset($_POST['addScheme'])){
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $link = trim($_POST['link']);
        $state = trim($_POST['state']);

        $stmt = $conn->prepare("INSERT INTO schemes (name, description, link, state) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $description, $link, $state);
        $stmt->execute();
        $stmt->close();

        echo "<p class='text-green-600 mb-4 font-semibold'>✅ Scheme added successfully!</p>";
    }

    // Delete Scheme
    if(isset($_GET['delete'])){
        $id = (int)$_GET['delete'];
        $conn->query("DELETE FROM schemes WHERE id=$id");
        echo "<p class='text-red-600 mb-4 font-semibold'>🗑️ Scheme deleted successfully!</p>";
    }

    // Pagination settings
    $limit = 6; // Number of schemes per page
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    // Total schemes
    $totalResult = $conn->query("SELECT COUNT(*) as total FROM schemes");
    $totalRow = $totalResult->fetch_assoc();
    $totalSchemes = $totalRow['total'];
    $totalPages = ceil($totalSchemes / $limit);

    // Fetch schemes with limit
    $result = $conn->query("SELECT * FROM schemes ORDER BY id DESC LIMIT $offset, $limit");
    ?>

    <!-- Add Scheme Form -->
    <form method="POST" class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-4 bg-white p-6 rounded-2xl shadow-md">
        <input type="text" name="name" placeholder="Scheme Name" class="p-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400 shadow-sm" required>
        <input type="text" name="state" placeholder="State" class="p-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400 shadow-sm">
        <input type="text" name="link" placeholder="Scheme Link" class="p-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400 shadow-sm">
        <textarea name="description" placeholder="Scheme Description" class="p-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400 shadow-sm md:col-span-2"></textarea>
        <button type="submit" name="addScheme" class="bg-green-600 text-white px-6 py-3 rounded-xl hover:bg-green-700 transition font-semibold md:col-span-2">Add Scheme</button>
    </form>

    <!-- List of Schemes -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php while($scheme = $result->fetch_assoc()): 
            $desc = $scheme['description'] ?: 'No description available.';
            $shortDesc = strlen($desc) > 150 ? substr($desc, 0, 150).'...' : $desc;
        ?>
            <div class="bg-white p-6 rounded-2xl shadow-lg flex flex-col justify-between hover:shadow-2xl transition">
                <div>
                    <h3 class="font-bold text-green-700 text-xl mb-2"><?= htmlspecialchars($scheme['name']) ?></h3>
                    <p class="text-gray-700 mb-4"><?= htmlspecialchars($shortDesc) ?></p>
                </div>
                <div class="flex justify-between items-center mt-auto">
                    <?php if(!empty($scheme['link'])): ?>
                        <a href="<?= htmlspecialchars($scheme['link']) ?>" target="_blank" class="text-blue-600 hover:underline font-semibold">Read More</a>
                    <?php endif; ?>
                    <a href="?delete=<?= $scheme['id'] ?>&page=<?= $page ?>" onclick="return confirm('Are you sure you want to delete this scheme?')" class="text-red-600 hover:underline font-semibold">Delete</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Pagination -->
    <?php if($totalPages > 1): ?>
        <div class="mt-6 flex justify-center space-x-2">
            <?php for($i=1; $i<=$totalPages; $i++): 
                $active = ($i==$page) ? "bg-green-600 text-white" : "bg-gray-200 text-gray-700";
            ?>
                <a href="?page=<?= $i ?>" class="px-3 py-1 rounded-lg <?= $active ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>

</div>

<?php include('includes/footer.php'); ?>
