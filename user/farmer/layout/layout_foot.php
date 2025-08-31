          </div>
        </div>
      </div>
    </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/6.0.4/bootbox.min.js"></script>
  </body>

</html>



<script>
  document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
  });
</script>


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
        const location = data.name;
        document.getElementById('desc').textContent= `${desc}`;
        document.getElementById('temperature').textContent = `${temp} °C`;
        document.getElementById('location').textContent = `${location}`;
      })
      .catch(error => {
        console.error('Error fetching temperature:', error);
        document.getElementById('temperature').textContent = 'Error getting temperature';
      });
  </script>


<script>
// JavaScript for deleting product
$(document).on('click', '.delete-object', function(){

    var id = $(this).data('delete-id');

    bootbox.confirm({
        message: "<h4>Are you sure remove this product?</h4>",
        buttons: {
            confirm: {
                label: '<span class="glyphicon glyphicon-ok"></span> Yes',
                className: 'btn-danger'
            },
            cancel: {
                label: '<span class="glyphicon glyphicon-remove"></span> No',
                className: 'btn-primary'
            }
        },
        callback: function (result) {

            if(result==true){
                $.post('/HarvestHub/user/farmer/management/delete_product.php', {
                    object_id: id,
                }, function(data){
                    alert('Product Deleted');
                    location.reload();
                }).fail(function() {
                    alert('Unable to delete.');
                });
            }
        }
    });

    return false;
});
</script>