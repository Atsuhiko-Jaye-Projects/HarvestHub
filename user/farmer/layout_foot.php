          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
  </body>
</html>

<!-- save product modal js -->
<script>

// Get the modal
var add_product_modal = document.getElementById("ap-modal");

// Get the button that opens the modal
var add_product_btn = document.getElementById("ap-btn");

// Get the <span> element that closes the modal
var close_btn_span = document.getElementsByClassName("close")[0];


// When the user clicks on the button, open the modal
add_product_btn.onclick = function() {
  add_product_modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
close_btn_span.onclick = function() {
  add_product_modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    add_product_modal.style.display = "none";
  }
}

</script>

  <script>
    const apiKey = '15f3130a55362389099d1a136f550885'; // Replace with your actual API key
    const city = 'Mogpog';
    const url = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric`;

    fetch(url)
      .then(response => response.json())
      .then(data => {
        const temp = data.main.temp;
        const desc = data.weather[0].description;
        document.getElementById('desc').textContent= `${desc}`;
        document.getElementById('temperature').textContent = `${temp} °C`;
      })
      .catch(error => {
        console.error('Error fetching temperature:', error);
        document.getElementById('temperature').textContent = 'Error getting temperature';
      });
  </script>