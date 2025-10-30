document.addEventListener('DOMContentLoaded', function(){
const ctx = document.getElementById('salesChart');

  new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
      datasets: [
        {
          label: 'This Week',
          data: [300, 250, 400, 320, 500, 450, 600],
          borderColor: '#16a34a',
          backgroundColor: 'rgba(22,163,74,0.1)',
          tension: 0.4,
          fill: true
        },
        {
          label: 'Last Week',
          data: [400, 300, 350, 420, 480, 400, 550],
          borderColor: '#b45309',
          backgroundColor: 'rgba(180,83,9,0.1)',
          tension: 0.4,
          fill: true
        }
      ]
    },
    options: {
      responsive: true,
      plugins: { legend: { position: 'bottom' } },
      scales: {
        y: { beginAtZero: true },
        x: { grid: { display: false } }
      }
    }
  });
});

document.addEventListener('DOMContentLoaded', function () {
  const ctx2 = document.getElementById('salesChart2').getContext('2d');
  const salesChart = new Chart(ctx2, {
    type: 'bar',
    data: {
      labels: ['Carrot', 'Eggplant', 'Potato', 'Cabbage'], // X-axis labels
      datasets: [{
        label: 'Total Sold (kg)',
        data: [20, 15, 10, 5], // Y-axis values
        backgroundColor: [
          'rgba(75, 192, 192, 0.6)',
          'rgba(153, 102, 255, 0.6)',
          'rgba(255, 159, 64, 0.6)',
          'rgba(255, 99, 132, 0.6)'
        ],
        borderColor: [
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)',
          'rgba(255, 99, 132, 1)'
        ],
        borderRadius: 5,        // rounded corners
        barThickness: 30,        // makes bars thinner (try 20–40)
        maxBarThickness: 40,     // prevent it from stretching
        borderWidth: 1,
        borderColor: '#fff'
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: false
        },
        title: {
          display: true,
          text: 'Top Products Sold'
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1
          }
        }
      }
    }
  });
});