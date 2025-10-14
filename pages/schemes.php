<?php 
include('../includes/header.php'); 
include('../includes/db.php'); 
?>

<h2 class="text-3xl font-extrabold mb-6 text-green-700">🏛️ Government Schemes</h2>

<!-- Latest PM-Kisan Schemes (manual) -->
<div class="bg-green-50 p-6 rounded-2xl shadow mb-8">
    <h3 class="text-xl font-bold text-green-800 mb-3">🌾 Latest PM-Kisan Schemes & Updates</h3>
    <ul class="list-disc ml-6 space-y-2 text-gray-700">
        <li><a href="https://pmkisan.gov.in/" target="_blank" class="text-green-700 hover:underline">PM-Kisan 17th Installment Released – Check Beneficiary Status</a></li>
        <li><a href="https://pmkisan.gov.in/RegistrationFormA.aspx" target="_blank" class="text-green-700 hover:underline">New Farmer Registration Open (Apply Online)</a></li>
        <li><a href="https://pmkisan.gov.in/BeneficiaryStatus_New.aspx" target="_blank" class="text-green-700 hover:underline">Check Your Payment & Aadhaar Link Status</a></li>
        <li><a href="https://pmkisan.gov.in/Rpt_BeneficiaryStatus_pub.aspx" target="_blank" class="text-green-700 hover:underline">District-Wise Beneficiary Report Updated</a></li>
        <li><a href="https://pmkisan.gov.in/Documents/PM-KISAN-Guidelines.pdf" target="_blank" class="text-green-700 hover:underline">PM-Kisan Official Guidelines (PDF)</a></li>
    </ul>
</div>

<!-- Search Form -->
<form method="POST" class="mb-8 flex gap-3 items-center">
    <input type="text" name="state" placeholder="Enter State (optional)" 
           class="flex-1 p-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400 shadow-sm text-gray-700">
    <button type="submit" name="getSchemes" 
            class="bg-green-600 text-white px-6 py-3 rounded-xl hover:bg-green-700 transition font-semibold shadow-md">Fetch Schemes</button>
</form>

<?php
if (isset($_POST['getSchemes'])) {
    $state = !empty(trim($_POST['state'])) ? trim($_POST['state']) : '';

    $sql = "SELECT * FROM schemes";
    if($state != ''){
        $sql .= " WHERE state LIKE ?";
        $stmt = $conn->prepare($sql);
        $state_param = "%$state%";
        $stmt->bind_param("s", $state_param);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $result = $conn->query($sql);
    }

    if($result && $result->num_rows > 0){
        echo "<div class='grid grid-cols-1 md:grid-cols-2 gap-6'>";
        while($scheme = $result->fetch_assoc()){
            $desc = $scheme['description'] ?? 'No description available.';
            $link = $scheme['link'] ?? '';

            // Truncate description to 150 characters
            $shortDesc = strlen($desc) > 150 ? substr($desc, 0, 150) . "..." : $desc;

            echo "<div class='bg-white p-6 rounded-2xl shadow-md flex flex-col justify-between'>";
            echo "<div>";
            echo "<h3 class='font-bold text-green-700 text-xl mb-3'>{$scheme['name']}</h3>";
            echo "<p class='text-gray-700 mb-4'>{$shortDesc}</p>";
            echo "</div>";
            
            if(!empty($link)){
                echo "<a href='{$link}' target='_blank' class='inline-block bg-green-600 text-white px-4 py-2 rounded-xl hover:bg-green-700 transition font-semibold text-center'>Read More</a>";
            }
            
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<p class='text-red-500 font-semibold mt-4'>⚠️ No schemes found for ".($state ?: 'selected state')."</p>";
    }
}
?>

<?php include('../includes/footer.php'); ?>
