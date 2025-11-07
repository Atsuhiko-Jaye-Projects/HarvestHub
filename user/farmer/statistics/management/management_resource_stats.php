<div class="container-xl mt-3">
    <div class="d-flex gap-3">
  <!-- Card 1 -->
  <div class="card text-white bg-success flex-fill shadow mb-3">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <h6 id="location"></h6>
          <h2 id="temperature"></h2>
          <small id="desc"></small>
        </div>
        <div>
          <i class="bi bi-clipboard" style="font-size: 1.5rem;"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Card 2 -->
  <div class="card flex-fill shadow mb-3">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <h6>Farm Expense</h6>
          <h2>PHP <?php echo number_format($total); ?></h2>
          <small>Orders</small>
        </div>
        <div>
          <i class="bi bi-bag" style="font-size: 1.5rem;"></i>
        </div>
      </div>
      <small class="text-success">+3.16% Froms last month</small>
    </div>
  </div>

  <!-- Card 3 -->
  <div class="card flex-fill shadow mb-3">
    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">Top Products</div>
        <div class="card-body p-0">
          <table class="table mb-0">
            <thead class="table-light">
              <tr>
                <th>Rank</th>
                <th>Product Name</th>
                <th>Total Sold</th>
              </tr>
            </thead>
            <tbody>
              <tr class="bg-success bg-opacity-10">
                <td>1</td>
                <td>Carrot</td>
                <td>20</td>
              </tr>
              <tr class="bg-secondary bg-opacity-10">
                <td>2</td>
                <td>Eggplant</td>
                <td>15</td>
              </tr>
              <tr>
                <td>3</td>
                <td>Potato</td>
                <td>10</td>
              </tr>
              <tr>
                <td>4</td>
                <td>Cabbage</td>
                <td>5</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
  </div>
</div>
</div>


<div class="container mt-4">

</div>
