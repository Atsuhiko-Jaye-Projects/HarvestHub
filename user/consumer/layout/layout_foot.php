    </div> <!-- end p-3 -->
  </div> <!-- end col -->
</div> <!-- end row -->
</div> <!-- end container-fluid -->

<!-- Core JS Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/6.0.4/bootbox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
setInterval(() => {
    $.get("../../../js/user/farmer/cron/poll_accept_order.php");
}, 1); // every 60 seconds
</script>
<script>
setInterval(() => {
    $.get("../../../js/user/farmer/cron/poll_cancel_order.php");
}, 1); // every 60 seconds
</script>

<!-- Enable Bootstrap Tooltips -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
  tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el));
});
</script>

<!-- Product Modal Control -->
<script>
const modal = document.getElementById("ap-modal");
const btn = document.getElementById("ap-btn");
const span = document.querySelector(".close");

if (btn && modal && span) {
  btn.onclick = () => modal.style.display = "block";
  span.onclick = () => modal.style.display = "none";
  window.onclick = (e) => { if (e.target === modal) modal.style.display = "none"; };
}
</script>

<!-- Weather Widget -->
<script>
const apiKey = '15f3130a55362389099d1a136f550885';
const city = 'Mogpog';
const url = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric`;

fetch(url)
  .then(res => res.json())
  .then(data => {
    document.getElementById('desc').textContent = data.weather[0].description;
    document.getElementById('temperature').textContent = `${data.main.temp} °C`;
    document.getElementById('location').textContent = data.name;
  })
  .catch(() => {
    document.getElementById('temperature').textContent = 'Error getting temperature';
  });
</script>

<!-- Delete Product -->
<script>
$(document).on('click', '.delete-object', function() {
  const id = $(this).data('delete-id');

  bootbox.confirm({
    message: "<h4>Are you sure you want to remove this product?</h4>",
    buttons: {
      confirm: { label: 'Yes', className: 'btn-danger' },
      cancel: { label: 'No', className: 'btn-primary' }
    },
    callback: result => {
      if (result) {
        $.post('/HarvestHub/user/farmer/management/delete_product.php', { object_id: id })
          .done(() => {
            alert('Product deleted');
            location.reload();
          })
          .fail(() => alert('Unable to delete.'));
      }
    }
  });
});
</script>

<!-- Product Quantity and Summary -->
<script>
$(function() {
  function updateItemTotal(card) {
    const qtyInput = card.find('.quantity-input');
    const unitPrice = parseFloat(card.find('input[name^="unit_price"]').val());
    const qty = parseInt(qtyInput.val());
    const total = unitPrice * qty;

    card.find('.text-success').text('₱' + total.toLocaleString(undefined, { minimumFractionDigits: 2 }));

    const checkbox = card.find('.product-checkbox');
    checkbox.data('qty', qty);
    checkbox.data('price', total);

    card.find('input[type="hidden"][name^="quantity"]').val(qty);

    updateSummary();
  }

  function updateSummary() {
    let totalPrice = 0, itemCount = 0;
    const shippingFee = 50;

    $('.product-checkbox:checked').each(function() {
      totalPrice += parseFloat($(this).data('price')) || 0;
      itemCount++;
    });

    const grandTotal = totalPrice > 0 ? totalPrice + shippingFee : 0;

    $('#items-count').text(itemCount);
    $('#total-price').text('₱' + totalPrice.toLocaleString(undefined, { minimumFractionDigits: 2 }));
    $('#grand-total').text('₱' + grandTotal.toLocaleString(undefined, { minimumFractionDigits: 2 }));
  }

$(document)
  .on('click', '.increase-qty', function () {
    const card = $(this).closest('.card');
    const input = card.find('.quantity-input');

    const step = 5;
    const max = parseInt(input.attr('max')) || Infinity;
    let val = parseInt(input.val()) || step;

    val = Math.min(val + step, max);
    input.val(val);

    updateItemTotal(card);
  })

  .on('click', '.decrease-qty', function () {
    const card = $(this).closest('.card');
    const input = card.find('.quantity-input');

    const step = 5;
    let val = parseInt(input.val()) || step;

    val = Math.max(val - step, step);
    input.val(val);

    updateItemTotal(card);
  })

  .on('input', '.quantity-input', function () {
    const card = $(this).closest('.card');
    const input = $(this);

    const step = 5;
    const max = parseInt(input.attr('max')) || Infinity;
    let val = parseInt(input.val());

    if (isNaN(val) || val < step) val = step;
    if (val > max) val = max;

    input.val(val);
    updateItemTotal(card);
  })

  .on('change', '.product-checkbox', updateSummary);

});
</script>


<script>

$("#confirmCancelOrder").on("click", function () {

    let reason = $("input[name='cancelReason']:checked").val(); // GET SELECTED RADIO
    let order_id = $("input[name='order_id']").val();
    let invoice_number = $("input[name='invoice_number']").val();
    let product_id = $("input[name='product_id']").val();
    let action = "cancel order"

    if (!reason) {
        Swal.fire({
            icon: "warning",
            title: "Please select a reason!"
        });
        return;
    }

    $.ajax({
        url: "/HarvestHub/user/consumer/order/order_action.php",
        type: "POST",
        data: { 
          reason: reason,
          order_id: order_id,
          invoice_number: invoice_number,
          action: action,
          product_id: product_id
          
         },     // ← POST VALUE SENT HERE
        success: function (res) {
            if (res.trim() === "success") {
                Swal.fire({
                    icon: "success",
                    title: "Order Cancelled!"
                });

                // Close modal
                $("#cancelOrderModal").modal("hide");

            } else {
                Swal.fire({
                    icon: "error",
                    title: "Failed to cancel, try again!"
                });
            }
            console.log(res);
        }
    });
});
</script>

<script>

$("#confirmOrder").on("click", function () {

    let order_id = $("input[name='order_id']").val();
    let invoice_number = $("input[name='invoice_number']").val();
    let product_id = $("input[name='product_id']").val();
    let action = "confirmed";

    $.ajax({
        url: "/HarvestHub/user/consumer/order/order_action.php",
        type: "POST",
        data: { 
          order_id: order_id,
          action: action,
          invoice_number: invoice_number,
          product_id: product_id
          
         },     // ← POST VALUE SENT HERE
        success: function (res) {
            if (res.trim() === "success") {
                Swal.fire({
                    icon: "success",
                    title: "Order Confirmed!",
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });

            } else {
                Swal.fire({
                    icon: "error",
                    title: "Failed to cancel, try again!"
                });
            }
            console.log(res);
        }
    });
});
</script>


<script>

$("#confirmPreOrder").on("click", function () {

    let order_id = $("input[name='order_id']").val();
    let invoice_number = $("input[name='invoice_number']").val();
    let product_id = $("input[name='product_id']").val();
    let action = "received order";

    $.ajax({
        url: "/HarvestHub/user/consumer/order/order_action.php",
        type: "POST",
        data: { 
          order_id: order_id,
          action: action,
          invoice_number: invoice_number,
          product_id: product_id
          
         },     // ← POST VALUE SENT HERE
        success: function (res) {
            if (res.trim() === "success") {
                Swal.fire({
                    icon: "success",
                    title: "Order Recieved!",
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });

            } else {
                Swal.fire({
                    icon: "error",
                    title: "Failed to recieve, try again!"

                });
            }
            console.log(res);
        }
    });
});
</script>

<script>

$("#confirmOrderProduct").on("click", function () {

    let order_id = $("input[name='order_id']").val();
    let invoice_number = $("input[name='invoice_number']").val();
    let product_id = $("input[name='product_id']").val();
    let action = "received order";

    $.ajax({
        url: "/HarvestHub/user/consumer/order/order_action.php",
        type: "POST",
        data: { 
          order_id: order_id,
          action: action,
          invoice_number: invoice_number,
          product_id: product_id
          
         },     // ← POST VALUE SENT HERE
        success: function (res) {
            if (res.trim() === "success") {
                Swal.fire({
                    icon: "success",
                    title: "Order Recieved!",
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });

            } else {
                Swal.fire({
                    icon: "error",
                    title: "Failed to recieve, try again!"

                });
            }
            console.log(res);
        }
    });
});
</script>

</body>
</html>
