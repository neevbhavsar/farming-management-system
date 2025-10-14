<?php 
include('../includes/header.php'); 
include('../includes/db.php'); 

// Logged-in user email
$user_email = $_SESSION['user'] ?? '';
if(empty($user_email)){
    echo "<p class='text-red-500'>Please log in to see your tasks.</p>";
    exit;
}
?>

<div class="max-w-7xl mx-auto mt-6 flex flex-col items-start">

    <h2 class="text-3xl font-extrabold mb-6 text-green-700">📅 Work Scheduler</h2>

    <!-- Add Task Form -->
    <form method="POST" class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-4 w-full bg-white p-6 rounded-2xl shadow-md">
        <input type="text" name="title" placeholder="Task Title" 
               class="p-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400 shadow-sm" required>
        <input type="date" name="task_date" 
               class="p-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400 shadow-sm" required>
        <input type="text" name="description" placeholder="Task Description" 
               class="p-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400 shadow-sm md:col-span-2" required>
        <button type="submit" name="addTask" 
                class="bg-green-600 text-white px-6 py-3 rounded-xl hover:bg-green-700 transition font-semibold shadow-md md:col-span-2">Add Task</button>
    </form>

<?php
// Add Task
if (isset($_POST['addTask'])) {
    $title = htmlspecialchars($_POST['title']);
    $task_date = $_POST['task_date'];
    $description = htmlspecialchars($_POST['description']);

    $stmt = $conn->prepare("INSERT INTO schedule(user_email, title, task_date, description) VALUES(?,?,?,?)");
    $stmt->bind_param("ssss", $user_email, $title, $task_date, $description);
    if($stmt->execute()){
        echo "<p class='text-green-700 font-semibold mb-4'>✅ Task added successfully!</p>";
    } else {
        echo "<p class='text-red-500 font-semibold mb-4'>❌ Failed to add task.</p>";
    }
    $stmt->close();
}

// Edit Task
if(isset($_POST['editTask'])){
    $id = $_POST['task_id'];
    $title = htmlspecialchars($_POST['title']);
    $task_date = $_POST['task_date'];
    $description = htmlspecialchars($_POST['description']);

    $stmt = $conn->prepare("UPDATE schedule SET title=?, task_date=?, description=? WHERE id=? AND user_email=?");
    $stmt->bind_param("sssis", $title, $task_date, $description, $id, $user_email);
    $stmt->execute();
    $stmt->close();
    echo "<p class='text-green-700 font-semibold mb-4'>✅ Task updated successfully!</p>";
}

// Delete Task
if(isset($_GET['delete'])){
    $del_id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM schedule WHERE id=? AND user_email=?");
    $stmt->bind_param("is", $del_id, $user_email);
    $stmt->execute();
    $stmt->close();
    echo "<p class='text-red-600 font-semibold mb-4'>🗑️ Task deleted successfully!</p>";
}

// Pagination
$limit = 5; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Total tasks
$totalResult = $conn->prepare("SELECT COUNT(*) as total FROM schedule WHERE user_email=?");
$totalResult->bind_param("s", $user_email);
$totalResult->execute();
$totalResult->bind_result($totalTasks);
$totalResult->fetch();
$totalResult->close();

$totalPages = ceil($totalTasks / $limit);

// Fetch tasks
$stmt = $conn->prepare("SELECT * FROM schedule WHERE user_email=? ORDER BY task_date ASC LIMIT ?, ?");
$stmt->bind_param("sii", $user_email, $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    echo "<div class='grid grid-cols-1 gap-6'>";
    while ($row = $result->fetch_assoc()) {
        $today = date('Y-m-d');
        $taskClass = ($row['task_date'] < $today) ? "bg-red-50 border-l-4 border-red-500" : "bg-white";

        echo "<div class='{$taskClass} p-6 rounded-2xl shadow flex flex-col md:flex-row justify-between items-start md:items-center'>";
        echo "<div class='flex-1'>";
        echo "<h3 class='font-bold text-green-700 text-xl mb-2'>{$row['title']}</h3>";
        echo "<p class='text-gray-700 mb-2'>{$row['description']}</p>";
        echo "<p class='text-gray-500 text-sm'>Date: {$row['task_date']}</p>";
        echo "</div>";

        // Edit & Delete buttons
        echo "<div class='flex space-x-2 mt-4 md:mt-0'>";
        echo "<button onclick=\"openEditModal({$row['id']}, '{$row['title']}', '{$row['task_date']}', '{$row['description']}')\" class='bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition'>Edit</button>";
        echo "<a href='?delete={$row['id']}' onclick=\"return confirm('Are you sure you want to delete this task?');\" class='bg-red-600 text-white px-4 py-2 rounded-xl hover:bg-red-700 transition'>Delete</a>";
        echo "</div>";

        echo "</div>";
    }
    echo "</div>";

    // Pagination links
    echo "<div class='mt-6 flex space-x-2'>";
    for($i=1; $i<=$totalPages; $i++){
        $active = ($i==$page) ? "bg-green-600 text-white" : "bg-gray-200 text-gray-700";
        echo "<a href='?page=$i' class='px-3 py-1 rounded-lg $active'>$i</a>";
    }
    echo "</div>";

} else {
    echo "<p class='text-gray-700 mt-4'>No tasks scheduled yet.</p>";
}
$stmt->close();
?>

</div>

<!-- Edit Task Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md">
        <h3 class="text-2xl font-bold mb-4 text-green-700">Edit Task</h3>
        <form method="POST" id="editForm" class="grid grid-cols-1 gap-4">
            <input type="hidden" name="task_id" id="editTaskId">
            <input type="text" name="title" id="editTitle" placeholder="Task Title" class="p-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400 shadow-sm" required>
            <input type="date" name="task_date" id="editDate" class="p-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400 shadow-sm" required>
            <input type="text" name="description" id="editDescription" placeholder="Task Description" class="p-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400 shadow-sm" required>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-xl bg-gray-300 hover:bg-gray-400 transition">Cancel</button>
                <button type="submit" name="editTask" class="px-4 py-2 rounded-xl bg-green-600 text-white hover:bg-green-700 transition">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, title, date, desc){
    document.getElementById('editTaskId').value = id;
    document.getElementById('editTitle').value = title;
    document.getElementById('editDate').value = date;
    document.getElementById('editDescription').value = desc;
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');
}

function closeEditModal(){
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editModal').classList.remove('flex');
}
</script>

<?php include('../includes/footer.php'); ?>
