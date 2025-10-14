<?php include('../includes/header.php'); ?>

<div class="max-w-7xl mx-auto mt-6 flex flex-col items-start">

    <h2 class="text-3xl font-extrabold mb-6 text-green-700">🌱 Soil Quality Checker</h2>

    <!-- Soil Form -->
    <form method="POST" class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-4 w-full bg-white p-6 rounded-2xl shadow-md">
        <input type="number" step="0.1" name="ph" placeholder="pH Value" class="p-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400 shadow-sm" required>
        <input type="number" name="nitrogen" placeholder="Nitrogen (N) ppm" class="p-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400 shadow-sm" required>
        <input type="number" name="phosphorus" placeholder="Phosphorus (P) ppm" class="p-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400 shadow-sm" required>
        <input type="number" name="potassium" placeholder="Potassium (K) ppm" class="p-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400 shadow-sm" required>
        <input type="number" step="0.1" name="moisture" placeholder="Moisture (%)" class="p-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400 shadow-sm" required>
        <button type="submit" name="checkSoil" class="bg-green-600 text-white px-6 py-3 rounded-xl hover:bg-green-700 transition font-semibold shadow-md">Check Soil</button>
    </form>

    <!-- Result & Suggestions -->
    <?php
    if (isset($_POST['checkSoil'])) {
        $ph = $_POST['ph'];
        $n = $_POST['nitrogen'];
        $p = $_POST['phosphorus'];
        $k = $_POST['potassium'];
        $moisture = $_POST['moisture'];

        // Basic logic
        $score = 0;
        $score += ($ph >= 6 && $ph <= 7) ? 1 : 0;
        $score += ($n >= 20 && $n <= 50) ? 1 : 0;
        $score += ($p >= 15 && $p <= 40) ? 1 : 0;
        $score += ($k >= 100 && $k <= 200) ? 1 : 0;
        $score += ($moisture >= 20 && $moisture <= 60) ? 1 : 0;

        if ($score >= 4) $result = "Good Soil 👍";
        elseif ($score >= 2) $result = "Moderate Soil ⚠️";
        else $result = "Poor Soil ❌";

        // Suggestions based on parameters
        $suggestions = [];
        if($ph < 6) $suggestions[] = "Increase pH: add lime to reduce acidity.";
        if($ph > 7) $suggestions[] = "Decrease pH: add sulfur or organic matter.";
        if($n < 20) $suggestions[] = "Increase Nitrogen: use nitrogen-rich fertilizers.";
        if($p < 15) $suggestions[] = "Increase Phosphorus: add bone meal or rock phosphate.";
        if($k < 100) $suggestions[] = "Increase Potassium: use potash fertilizers.";
        if($moisture < 20) $suggestions[] = "Increase moisture: water your crops regularly.";
        if($moisture > 60) $suggestions[] = "Reduce moisture: ensure proper drainage.";

        echo "<div class='bg-white p-8 rounded-2xl shadow-xl w-full max-w-md mt-6'>";
        echo "<p class='font-bold text-2xl text-green-700 mb-4'>Soil Result: $result</p>";
        echo "<div class='space-y-1 text-gray-700 mb-4'>
                <p><span class='font-semibold'>pH Value:</span> $ph</p>
                <p><span class='font-semibold'>Nitrogen (N):</span> $n ppm</p>
                <p><span class='font-semibold'>Phosphorus (P):</span> $p ppm</p>
                <p><span class='font-semibold'>Potassium (K):</span> $k ppm</p>
                <p><span class='font-semibold'>Moisture:</span> $moisture%</p>
              </div>";

        // Show suggestions if any
        if(!empty($suggestions)){
            echo "<div class='bg-green-50 p-4 rounded-xl border-l-4 border-green-600'>";
            echo "<p class='font-semibold text-green-700 mb-2'>Suggestions to Improve Soil:</p>";
            echo "<ul class='list-disc pl-5 text-gray-700'>";
            foreach($suggestions as $s) {
                echo "<li>$s</li>";
            }
            echo "</ul>";
            echo "</div>";
        }

        echo "</div>";
    }
    ?>

</div>

<?php include('../includes/footer.php'); ?>
