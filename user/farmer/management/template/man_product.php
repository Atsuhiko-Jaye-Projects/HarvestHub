<div class="container py-4">

  <div class="row g-3 mb-4">
    <div class="col-md-3">
      <div class="card border-0 shadow-sm h-100 rounded-4">
        <div class="card-body text-center">
          <i class="bi bi-box-seam text-success fs-2 mb-2"></i>
          <h6 class="text-muted">Total Products</h6>
          <h4 id="totalProducts"><?php echo $num; ?></h4>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-0 shadow-sm h-100 rounded-4">
        <div class="card-body text-center">
          <i class="bi bi-cart-check text-primary fs-2 mb-2"></i>
          <h6 class="text-muted">Posted Products</h6>
          <h4 id="postedProducts">0</h4>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-0 shadow-sm h-100 rounded-4">
        <div class="card-body text-center">
          <i class="bi bi-hourglass-split text-warning fs-2 mb-2"></i>
          <h6 class="text-muted">Pending</h6>
          <h4 id="pendingProducts">0</h4>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-0 shadow-sm h-100 rounded-4">
        <div class="card-body text-center">
          <i class="bi bi-cash-stack text-danger fs-2 mb-2"></i>
          <h6 class="text-muted">Avg. Price</h6>
          <h4 id="avgPrice">₱0.00</h4>
        </div>
      </div>
    </div>
  </div>

  <!-- Search & Filter Navbar -->
  <nav class="navbar bg-body-tertiary rounded-4 shadow-sm mb-3 p-3">
    <div class="container-fluid d-flex flex-wrap justify-content-between align-items-center">
      <div class="d-flex w-50 align-items-center mb-2 mb-md-0">
        <div class="input-group shadow-sm rounded-pill overflow-hidden w-100">
          <span class="input-group-text bg-white border-0" id="search-icon">
            <i class="bi bi-search text-success"></i>
          </span>
          <input 
            class="form-control border-0"
            type="text"
            id="searchInput"
            placeholder="Search products..."
            aria-label="Search"
            aria-describedby="search-icon"
          />
        </div>
      </div>

      <div class="d-flex align-items-center gap-2">
        <select id="statusFilter" class="form-select w-auto rounded-pill shadow-sm">
          <option value="">All Status</option>
          <option value="Posted">Posted</option>
          <option value="Pending">Pending</option>
        </select>
        <!-- <button class="btn btn-success px-4 rounded-pill" data-bs-toggle="modal" data-bs-target="#new-product-modal">
          <i class="bi bi-plus-circle me-2"></i> Add Product
        </button> -->
      </div>
    </div>
  </nav>

  <?php
    if ($num > 0) {
  ?>
  <div class="table-responsive shadow-sm rounded-4">
    <table class="table table-hover align-middle mb-0" id="productTable">
      <thead class="table-success text-uppercase">
        <tr>
          <th>Product Name</th>
          <th>Category</th>
          <th>Price</th>
          <th>Unit</th>
          <th>Lot Size</th>
          <th>Date</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
      <?php
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          extract($row);
          echo "<tr class='align-middle'>";
            echo "<td>{$product_name}</td>";
            echo "<td>{$category}</td>";
            echo "<td>₱{$price_per_unit}</td>";
            echo "<td>{$unit}</td>";
            echo "<td>{$lot_size}</td>";
            echo "<td>{$created_at}</td>";
            echo "<td class='text-center'>";
              echo "<div class='btn-group' role='group'>";
              echo "<button class='btn btn-outline-primary btn-sm rounded-pill me-2' data-bs-toggle='modal' data-bs-target='#edit-product-modal-$id' title='Edit'>
                      <i class='bi bi-pencil-square'></i>
                    </button>";
              echo "<a href='#' data-delete-id='{$id}' class='btn btn-outline-danger btn-sm rounded-pill delete-object' title='Remove'>
                      <i class='bi bi-trash'></i>
                    </a>";
              echo "</div>";
            echo "</td>";
          echo "</tr>";
        }
      ?>
      </tbody>
    </table>
  </div>

  <?php
      include_once "paging.php";
    } else {
      echo "<div class='alert alert-danger shadow-sm rounded-4 mt-3 text-center'>
              <i class='bi bi-exclamation-triangle me-2'></i> No products found
            </div>";
    }
  ?>

</div>

<!-- JS for Live Search & Status Filter -->
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("searchInput");
    const statusSelect = document.getElementById("statusFilter");
    const table = document.getElementById("productTable");
    const rows = table.querySelectorAll("tbody tr");

    const filterTable = () => {
      const search = searchInput.value.toLowerCase();
      const status = statusSelect.value.toLowerCase();

      rows.forEach(row => {
        const cells = row.getElementsByTagName("td");
        const text = Array.from(cells).map(td => td.innerText.toLowerCase()).join(" ");
        const rowStatus = cells[6]?.innerText.toLowerCase(); // status in last cell if applicable

        const matchesSearch = text.includes(search);
        const matchesStatus = !status || rowStatus.includes(status);

        row.style.display = matchesSearch && matchesStatus ? "" : "none";
      });
    };

    searchInput.addEventListener("input", filterTable);
    statusSelect.addEventListener("change", filterTable);
  });
</script>

<style>
  .table-hover tbody tr:hover {
    background-color: #e9f7ef;
    transition: background-color 0.3s ease;
  }
  .btn-group .btn:hover {
    transform: translateY(-2px);
    transition: transform 0.2s ease;
  }
</style>
