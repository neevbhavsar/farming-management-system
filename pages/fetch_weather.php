<?php
// !!! IMPORTANT: ENSURE THIS API KEY IS VALID AND ACTIVE !!!
// NOTE: A 401 Error means this key is likely invalid or inactive. Please replace it with a working key.
$apiKey = "2d58800202b682f86a955e4af06c03a0";

// Ensure latitude and longitude parameters are present in the URL
if(isset($_GET['lat']) && isset($_GET['lon'])){
    $lat = $_GET['lat'];
    $lon = $_GET['lon'];

    // KEY CHANGE: Switched units=imperial back to units=metric to get Temperature in °C
    // This returns Temperature in °C and Wind Speed in m/s.
    $url = "https://api.openweathermap.org/data/2.5/weather?lat=$lat&lon=$lon&units=metric&appid=$apiKey";

    // Initialize cURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Keeping this false for development, but should be set to true in production
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Check for cURL errors or non-200 HTTP response (e.g., API key invalid leads to 401)
    if(!$response || $http_code != 200){
        // Output a standard error message
        echo "<p class='text-red-500'>Unable to fetch weather. (API Error or Network issue: HTTP Code $http_code)</p>";
        // Terminate execution
        exit;
    }

    $data = json_decode($response, true);

    // Check if the JSON decoded successfully and the OpenWeatherMap status code is 200
    if($data && $data['cod'] == 200){
        
        // --- Wind Speed Conversion (m/s to mph) ---
        $wind_speed_ms = $data['wind']['speed'];
        // Conversion factor: 1 m/s ≈ 2.23694 mph
        $wind_speed_mph = round($wind_speed_ms * 2.23694, 1);
        
        // --- Output Display ---
        echo "<div class='bg-white p-6 rounded-xl shadow'>";
        echo "<p class='font-bold text-green-700 text-xl'>Weather in ".$data['name'].", ".$data['sys']['country']."</p>";
        // Temperature is now in Celsius (°C)
        echo "<p>Temperature: ".$data['main']['temp']."°C</p>"; 
        echo "<p>Humidity: ".$data['main']['humidity']."%</p>";
        echo "<p>Weather: ".ucfirst($data['weather'][0]['description'])."</p>";
        // Wind Speed is manually converted to Miles Per Hour (mph)
        echo "<p>Wind Speed: ".$wind_speed_mph." mph</p>"; 
        echo "</div>";
    } else {
        // Output a generic error if the OpenWeatherMap response has an issue
        echo "<p class='text-red-500'>Unable to fetch weather. (Data processing error)</p>";
    }
} else {
    // Output error if lat/lon were not provided (shouldn't happen if JS works)
    echo "<p class='text-red-500'>Coordinates missing.</p>";
}
?>