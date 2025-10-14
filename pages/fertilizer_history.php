<?php include('../includes/header.php'); ?>

<div class="max-w-7xl mx-auto mt-4">

    <h2 class="text-3xl font-extrabold mb-6 text-green-700">📝 Recently Checked Fertilizers</h2>

    <?php
    $user_email = $_SESSION['user'];

    // Fetch recent fertilizer checks for logged-in user
    $stmt = $conn->prepare("SELECT * FROM fertilizer_checks WHERE user_email=? ORDER BY created_at DESC");
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<div class='overflow-x-auto bg-white rounded-2xl shadow-md'>";
        echo "<table class='min-w-full divide-y divide-gray-200'>";
        echo "<thead class='bg-green-100'>
                <tr>
                    <th class='px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider'>#</th>
                    <th class='px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider'>Fertilizer Name</th>
                    <th class='px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider'>NPK Ratio</th>
                    <th class='px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider'>Expiry Date</th>
                    <th class='px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider'>Quality</th>
                    <th class='px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider'>Checked On</th>
                </tr>
              </thead>";
        echo "<tbody class='divide-y divide-gray-200'>";
        $i = 1;
        while($row = $result->fetch_assoc()) {
            $qualityColor = strpos($row['quality'], 'Expired') !== false ? "text-red-500" : "text-green-600";
            echo "<tr class='hover:bg-gray-50'>
                    <td class='px-6 py-4 whitespace-nowrap'>$i</td>
                    <td class='px-6 py-4 whitespace-nowrap'>{$row['fertilizer_name']}</td>
                    <td class='px-6 py-4 whitespace-nowrap'>{$row['npk']}</td>
                    <td class='px-6 py-4 whitespace-nowrap'>{$row['expiry_date']}</td>
                    <td class='px-6 py-4 whitespace-nowrap font-semibold {$qualityColor}'>{$row['quality']}</td>
                    <td class='px-6 py-4 whitespace-nowrap text-gray-500'>{$row['created_at']}</td>
                  </tr>";
            $i++;
        }
        echo "</tbody></table></div>";
    } else {
        echo "<p class='text-gray-500 mt-4'>No fertilizer checks yet. Try checking some fertilizers!</p>";
    }

    $stmt->close();
    ?>

</div>

<?php include('../includes/footer.php'); ?>
