<?php
// Replace with your OpenWeatherMap API key
$apiKey = "58bd74197c40ad116e71c82d0257fe98";
$city = isset($_GET['city']) ? $_GET['city'] : 'Dhaka';
$apiUrl = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric";

$weather = null;
$error = null;

try {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $weatherData = curl_exec($ch);

    if (curl_errno($ch)) {
        throw new Exception("cURL Error: " . curl_error($ch));
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($httpCode !== 200) {
        throw new Exception("API responded with HTTP code: $httpCode");
    }

    $weather = json_decode($weatherData, true);
    curl_close($ch);

    if (!isset($weather['cod']) || $weather['cod'] != 200) {
        throw new Exception("Invalid response from the weather API: " . $weather['message']);
    }
} catch (Exception $e) {
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Weather Update</title>
</head>
<body>
    <form method="GET" action="">
        <fieldset style="width: 35%;">
            <legend>Weather Update</legend>
            <label for="city">Enter City:</label>
            <input type="text" id="city" name="city" value="<?= htmlspecialchars($city) ?>" required>
            <button type="submit">Get Weather</button>
            <br><br>
            <?php if ($error): ?>
                <p>Error: <?= htmlspecialchars($error) ?></p>
            <?php elseif ($weather): ?>
                <h2>Weather in <?= htmlspecialchars($weather['name']) ?>:</h2>
                <p>Temperature: <?= $weather['main']['temp'] ?>°C</p>
                <p>Condition: <?= $weather['weather'][0]['description'] ?></p>
                <p>Humidity: <?= $weather['main']['humidity'] ?>%</p>
                <p>Wind Speed: <?= $weather['wind']['speed'] ?> m/s</p>
            <?php endif; ?>
            <br>
            <button type="button" onclick="window.location.href='farmer_menu.php';">Back</button>
        </fieldset>
    </form>
</body>
</html>
