document.addEventListener('DOMContentLoaded', function () {
  const temperature_element = document.getElementById('temperature');
  if (!temperature_element) return;
  const apiKey = '15f3130a55362389099d1a136f550885';
  const city = 'Mogpog';
  const url = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric`;



  fetch(url)
    .then(response => response.json())
    .then(data => {
      document.getElementById('desc').textContent = data.weather[0].description;
      document.getElementById('temperature').textContent = `${data.main.temp} °C`;
      document.getElementById('location').textContent = data.name;
    })
    .catch(() => {
      document.getElementById('temperature').textContent = 'Error loading data';
    });
});
