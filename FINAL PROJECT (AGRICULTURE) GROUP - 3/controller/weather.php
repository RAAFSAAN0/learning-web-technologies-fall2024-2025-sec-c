<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['city'])) {
    // Replace with your OpenWeatherMap API key
    $apiKey = "58bd74197c40ad116e71c82d0257fe98";
    $city = $_GET['city'];
    $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric";

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

        echo json_encode(['success' => true, 'weather' => $weather]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'City not provided']);
}
?>
