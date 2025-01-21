document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("weather-form");
    const weatherInfo = document.getElementById("weather-info");

    form.addEventListener("submit", function (event) {
        event.preventDefault();
        const city = document.getElementById("city").value;

        // Fetch weather data from the server
        fetch(`../controller/weather.php?city=${encodeURIComponent(city)}`)
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    const weather = data.weather;
                    weatherInfo.innerHTML = `
                        <h2>Weather in ${weather.name}:</h2>
                        <p>Temperature: ${weather.main.temp}°C</p>
                        <p>Condition: ${weather.weather[0].description}</p>
                        <p>Humidity: ${weather.main.humidity}%</p>
                        <p>Wind Speed: ${weather.wind.speed} m/s</p>
                    `;
                } else {
                    weatherInfo.innerHTML = `<p>Error: ${data.message}</p>`;
                }
            })
            .catch(() => {
                weatherInfo.innerHTML = "<p>Error fetching weather data.</p>";
            });
    });
});
