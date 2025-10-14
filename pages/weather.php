<?php include('../includes/header.php'); ?>

<div class="max-w-full mx-auto mt-6 flex flex-col items-start">

    <h2 class="text-4xl font-extrabold mb-8 text-gray-800 self-start">🌦️ Weather Forecast</h2>

    <!-- Weather Form -->
    <form method="POST" class="mb-8 flex flex-col md:flex-row gap-4 bg-white p-6 rounded-2xl shadow-md w-full max-w-lg">
        <input type="text" name="city" placeholder="Enter City (optional)" 
               class="flex-1 p-4 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400 shadow-sm text-gray-800 placeholder-gray-400">
        <button type="submit" name="getWeather" 
                class="bg-green-600 text-white px-6 py-4 rounded-xl hover:bg-green-700 transition font-semibold shadow-md">Check</button>
    </form>

    <!-- Weather Result -->
    <div id="weatherResult" class="text-gray-800 font-medium text-lg w-full max-w-lg">
        <p class="text-gray-400">Fetching weather data...</p>
    </div>

    <?php
    $apiKey = "YOUR_API_KEY";

    function getWeather($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if(!$response || $http_code != 200) return false;
        return json_decode($response, true);
    }

    if(isset($_POST['getWeather']) && !empty(trim($_POST['city']))){
        $city = trim($_POST['city']);
        $url = "https://api.openweathermap.org/data/2.5/weather?q=".urlencode($city)."&units=metric&appid=$apiKey";
        $data = getWeather($url);

        if($data && $data['cod'] == 200){
            $wind_speed_mph = round($data['wind']['speed'] * 2.23694, 1);

            echo "<div class='bg-white p-8 rounded-2xl shadow-xl mt-6 w-full max-w-lg text-gray-800'>
                    <h3 class='font-bold text-2xl mb-4'>{$data['name']}, {$data['sys']['country']}</h3>
                    <div class='space-y-2'>
                        <p><span class='font-semibold'>Temperature:</span> {$data['main']['temp']}°C</p>
                        <p><span class='font-semibold'>Humidity:</span> {$data['main']['humidity']}%</p>
                        <p><span class='font-semibold'>Weather:</span> ".ucfirst($data['weather'][0]['description'])."</p>
                        <p><span class='font-semibold'>Wind Speed:</span> {$wind_speed_mph} mph</p>
                    </div>
                  </div>";
        } else {
            echo "<p class='text-red-500 mt-4 font-semibold'>City not found or unable to fetch weather.</p>";
        }
    }
    ?>

</div>

<script>
// Auto-fetch weather via geolocation
window.addEventListener('load', () => {
    const weatherDiv = document.getElementById('weatherResult');

    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(position => {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;

            fetch(`fetch_weather.php?lat=${lat}&lon=${lon}`)
            .then(res => res.text())
            .then(html => weatherDiv.innerHTML = html)
            .catch(() => weatherDiv.innerHTML = "<p class='text-red-500'>Unable to fetch weather.</p>");
        }, () => {
            weatherDiv.innerHTML = "<p class='text-red-500'>Geolocation denied. Please enter city manually.</p>";
        });
    } else {
        weatherDiv.innerHTML = "<p class='text-red-500'>Geolocation not supported. Please enter city manually.</p>";
    }
});
</script>

<?php include('../includes/footer.php'); ?>
