<?php include('../includes/header.php'); ?>

<div class="max-w-7xl mx-auto mt-6 flex flex-col items-start">

    <h2 class="text-3xl font-extrabold mb-6 text-green-700">💧 Fertilizer Quality Checker</h2>

    <!-- Fertilizer Form -->
    <form method="POST" class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-4 w-full bg-white p-6 rounded-2xl shadow-md">
        <input type="text" name="fertilizer" placeholder="Fertilizer Name" 
               class="p-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400 shadow-sm" required>
        <input type="text" name="npk" placeholder="NPK Ratio (e.g., 10-26-26)" 
               class="p-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400 shadow-sm" required>
        <input type="date" name="expiry" placeholder="Expiry Date" 
               class="p-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400 shadow-sm" required>
        <button type="submit" name="checkFertilizer" 
                class="bg-green-600 text-white px-6 py-3 rounded-xl hover:bg-green-700 transition font-semibold shadow-md">Check Fertilizer</button>
    </form>

    <!-- Result -->
    <?php
    if (isset($_POST['checkFertilizer'])) {
        $fertilizer = htmlspecialchars($_POST['fertilizer']);
        $npk = htmlspecialchars($_POST['npk']);
        $expiry = $_POST['expiry'];
        $today = date('Y-m-d');

        if ($expiry < $today) {
            $quality = "Expired ❌";
            $qualityColor = "text-red-500";
        } else {
            $quality = "Good Quality ✅";
            $qualityColor = "text-green-600";
        }

        // Insert into database
        $user_email = $_SESSION['user']; // Logged-in user email
        $stmt = $conn->prepare("INSERT INTO fertilizer_checks (user_email, fertilizer_name, npk, expiry_date, quality) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $user_email, $fertilizer, $npk, $expiry, $quality);
        $stmt->execute();
        $stmt->close();

        // Display result
        echo "<div class='bg-white p-8 rounded-2xl shadow-xl w-full max-w-md mt-6'>";
        echo "<h3 class='font-bold text-2xl mb-4 {$qualityColor}'>{$fertilizer} - {$quality}</h3>";
        echo "<div class='space-y-2 text-gray-700'>
                <p><span class='font-semibold'>NPK Ratio:</span> {$npk}</p>
                <p><span class='font-semibold'>Expiry Date:</span> {$expiry}</p>
              </div>";
        
        // Suggestions
        echo "<div class='mt-4 bg-green-50 p-4 rounded-xl border-l-4 border-green-600'>";
        echo "<p class='font-semibold text-green-700 mb-2'>Suggestions:</p>";
        echo "<ul class='list-disc pl-5 text-gray-700'>";
        if ($expiry < $today) {
            echo "<li>Do not use expired fertilizer. Dispose safely.</li>";
        } else {
            echo "<li>Store fertilizer in a cool, dry place.</li>";
            echo "<li>Use according to recommended dosage for best results.</li>";
        }
        echo "</ul></div>";
        
        echo "</div>";
    }
    ?>

</div>

<?php include('../includes/footer.php'); ?>
