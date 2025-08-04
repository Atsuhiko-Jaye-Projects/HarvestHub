<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Weather in Manila</title>
</head>
<body>
  <h1>Current Temperature</h1>
  <p id="temperature">Loading...</p>

  <script>
    const apiKey = '15f3130a55362389099d1a136f550885'; // Replace with your actual API key
    const city = 'Baguio';
    const url = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric`;

    fetch(url)
      .then(response => response.json())
      .then(data => {
        const temp = data.main.temp;
        document.getElementById('temperature').textContent = `Temperature in ${city}: ${temp} °C`;
      })
      .catch(error => {
        console.error('Error fetching temperature:', error);
        document.getElementById('temperature').textContent = 'Error getting temperature';
      });
  </script>
</body>
</html>
