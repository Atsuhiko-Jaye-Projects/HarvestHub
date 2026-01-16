document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('salesChart');

    fetch('../../js/user/farmer/api/fetch_farm_sale.php')
        .then(res => res.json())
        .then(data => {
            if (data.status !== 'success') throw new Error('Failed to fetch sales data');

            const results = data.expense.result; // array of objects

            // Map the results to arrays for Chart.js
            const labels = results.map(r => r.date_sales);
            const sales = results.map(r => parseFloat(r.total_sales));

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Sales',
                        data: sales,
                        borderColor: '#3d976a',
                        backgroundColor: 'rgba(22,163,74,0.2)',
                        tension: 0.4,
                        fill: true,

                        // 🔴 DOT SETTINGS
                        pointRadius: 6,          // default is 3
                        pointHoverRadius: 9,     // when hovered
                        pointBackgroundColor: '#181a19',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2
                    }]

                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'bottom' } },
                    scales: {
                        y: { beginAtZero: false },
                        x: { grid: { display: false }, ticks: { display:false } }
                    }
                }
            });
        })
        .catch(err => console.error('Error fetching sales data:', err));
});



document.addEventListener('DOMContentLoaded', function () {
    fetch('../../js/user/farmer/api/fetch_product_stock.php')
    .then(response => response.json())
    .then(data => {

        const products = data.product_stock.records;
        
        const labels = products.map(item => item.product_name);
        const values = products.map(item => parseInt(item.available_stocks));

        const ctx2 = document.getElementById('salesChart2').getContext('2d');

        // 🔥 Modern gradient color (no new variable name, directly inside ctx2)
        const gradientFill = ctx2.createLinearGradient(0, 0, 0, 350);
        gradientFill.addColorStop(0, 'rgba(34, 197, 94, 0.9)');   // Bright green
        gradientFill.addColorStop(1, 'rgba(16, 185, 129, 0.4)');  // Soft teal

        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Available Stocks (kg)',
                    data: values,
                    backgroundColor: gradientFill,
                    borderColor: 'rgba(34, 197, 94, 1)',
                    borderWidth: 2,
                    borderRadius: 14,   // Modern rounded bars
                    barThickness: 32,
                    hoverBackgroundColor: 'rgba(22, 163, 74, 1)' // darker green hover
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },

                    // 🔥 Modern title
                    title: {
                        display: true,
                        text: 'Product Stock Overview',
                        font: {
                            size: 18,
                            weight: 'bold',
                            family: 'Poppins'
                        },
                        padding: { top: 10, bottom: 20 }
                    },

                    // 🔥 Clean tooltip
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        padding: 12,
                        titleFont: { size: 14, weight: 'bold', family: 'Poppins' },
                        bodyFont: { size: 13, family: 'Poppins' },
                        callbacks: {
                            label: function (context) {
                                return `Available Stocks: ${context.raw} kg`;
                            }
                        }
                    }
                },

                // 🔥 Modern minimalistic axes
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { family: 'Poppins' },
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: { family: 'Poppins' }
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.05)' // light grid
                        }
                    }
                }
            }
        });

    })
    .catch(error => console.log("Fetch error: ", error));
});

function loadMostPlanted() {
  $.ajax({
    url: "../../js/user/farmer/api/fetch_most_planted.php",
    type: "GET",
    dataType: "json",
    success: function(response) {
      if (!response.records || response.records.length === 0) {
        $("#mostPlantedCropTable").html(`
          <tr><td colspan="3" class="text-center">No data found</td></tr>
        `);
        return;
      }

      let rows = "";
      let rank = 1;

      response.records.forEach(row => {
        rows += `
          <tr>
            <td>${rank}</td>

            <td style="text-transform: capitalize;">${row.crop_name}</td>
            <td>${Number(row.total_planted).toLocaleString()}</td>
          </tr>
        `;
        rank++;
      });

      $("#mostPlantedCropTable").html(rows);
    }
  });
}
document.addEventListener("DOMContentLoaded", loadMostPlanted);



document.addEventListener("DOMContentLoaded", function(){
  
  function fetchNotifications(){
      fetch('/HarvestHub/js/user/farmer/api/fetch_stock_notification.php')
      .then(result => result.json())
      .then(data =>{

        const products = data.product_status.records;
        const listBox = document.getElementById('notificationList'); // <ul id="notificationList">
        listBox.innerHTML = ''; // clear old items
        
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        const formattedToday = `${yyyy}-${mm}-${dd}`;
        const low_stock_treshhold = 50;

        const low_stock_product = products.filter(note => note.available_stocks < low_stock_treshhold);

        if (low_stock_product.length === 0) {
            const li = document.createElement('li');
            li.classList.add('list-group-item', 'text-center', 'text-success');
            li.innerHTML = `<small class="text-muted">All Products are Available</small>`;
            listBox.appendChild(li);
        } else {
            // Limit to first 5 low-stock products
            low_stock_product.slice(0, 3).forEach(note => {
                const li = document.createElement('li');
                li.classList.add('list-group-item');
                li.innerHTML = `
                    <small class="text-muted">${formattedToday}</small><br>
                    <strong>${note.product_name}</strong> only <strong>${note.available_stocks}</strong> kg remaining ⚠️<span class="badge bg-warning ms-2">Low Stock Alert </span>
                `;
                listBox.appendChild(li);
            });
        }
      });
  }
    fetchNotifications();

  // fetch every 30 seconds
  setInterval(fetchNotifications, 5000);

});


document.addEventListener("DOMContentLoaded", function () {

  function fetchOrderNotifications() {
    fetch('/HarvestHub/js/user/farmer/api/fetch_order_notification.php')
      .then(result => result.json())
      .then(data => {

        const customerOrder = data.customer_order; // correct variable
        const listBox = document.getElementById('orderNotification');
        listBox.innerHTML = '';

        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        const formattedToday = `${yyyy}-${mm}-${dd}`;

        customerOrder.slice(0, 3).forEach(note => {
          const li = document.createElement('li');
          li.classList.add('list-group-item');
          li.innerHTML = `
            <small class="text-muted">${note.created_at}</small><br>
            <strong>${note.customer_name}</strong> ${note.status} 
            <strong>${note.quantity}</strong> kg of <strong>${note.product_name}</strong> 📦<span class="badge bg-success ms-2">New Order</span> 
          `;
          listBox.appendChild(li);
        });

        // If no orders
        if (customerOrder.length === 0) {
          listBox.innerHTML = `
            <li class="list-group-item text-muted">
              No new order notifications
            </li>
          `;
        }

      });
  }

  fetchOrderNotifications();

  // Auto-refresh every 5 seconds
  setInterval(fetchOrderNotifications, 5000);
});





