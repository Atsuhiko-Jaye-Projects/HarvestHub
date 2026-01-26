<!DOCTYPE html>
<html>
<head>
  <title>Crop Shelf Life Estimator</title>
</head>
<body>
<h2>Crop Shelf Life Estimator</h2>

<label>Location: <input type="text" id="location" value="Barangay San Isidro, Talisay, Cebu, Philippines"></label><br>
<label>Crop: 
  <select id="crop">
    <option value="leafy">Leafy Greens</option>
    <option value="tomato">Tomato</option>
    <option value="root">Root Crop</option>
  </select>
</label><br>
<button onclick="getWeather()">Get Shelf Life</button>

<div id="result" style="margin-top:20px; font-weight:bold;"></div>

<script>
function getWeather() {
    const location = encodeURIComponent(document.getElementById('location').value);
    const apiKey = 'VTZE7BHR7XAT9XD3GGS4VL3HU';
    const url = `https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/${location}/today?unitGroup=metric&key=${apiKey}`;

    fetch(url)
      .then(response => response.json())
      .then(data => {
          const today = data.days[0]; // today's weather data

          const crop = document.getElementById('crop').value;

          // Simple shelf life model
          let baseline, idealTemp, idealHumidity;

          if(crop === 'leafy') { 
              baseline = 7; idealTemp = 4; idealHumidity = 90; 
          } else if(crop === 'tomato') { 
              baseline = 14; idealTemp = 12; idealHumidity = 85; 
          } else { 
              baseline = 30; idealTemp = 10; idealHumidity = 70; 
          }

          const tempFactor = Math.max(0, 1 - 0.1 * Math.abs(today.temp - idealTemp));
          const humidityFactor = Math.max(0, 1 - 0.05 * Math.abs(today.humidity - idealHumidity) / 10);
          const estimatedShelfLife = Math.round(baseline * tempFactor * humidityFactor);

          // Combine all today's data with shelf life
          const resultJSON = {
              location: decodeURIComponent(location),
              crop: crop,
              estimated_shelf_life_days: estimatedShelfLife,
              weather_today: today // everything returned by Visual Crossing for today
          };

          // Display as JSON
          document.getElementById('result').innerHTML = `<pre>${JSON.stringify(resultJSON, null, 2)}</pre>`;
      })
      .catch(err => {
          console.error(err);
          document.getElementById('result').innerHTML = "Error fetching today's weather data.";
      });
}

</script>
</body>
</html>
