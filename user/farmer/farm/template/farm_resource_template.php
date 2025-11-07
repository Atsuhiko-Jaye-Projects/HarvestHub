<div class="container py-4">

  <!-- ✅ Summary Cards -->
  <div class="row g-3 mb-4">
    <div class="col-md-3">
      <div class="card border-0 shadow-sm h-100 rounded-4">
        <div class="card-body text-center">
          <i class="bi bi-journal-text text-success fs-2 mb-2"></i>
          <h6 class="text-muted">Total Resources</h6>
          <h4 id="totalResources"><?php echo $num; ?></h4>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-0 shadow-sm h-100 rounded-4">
        <div class="card-body text-center">
          <i class="bi bi-cash-stack text-primary fs-2 mb-2"></i>
          <h6 class="text-muted">Total Cost</h6>
          <h4 id="totalCost">₱ <?php echo number_format($total); ?></h4>
        </div>
      </div>
    </div>
  </div>

  <?php include_once "../modal-forms/resource/add_resource.php"; ?>

  <!-- Page Header -->
  <div class="p-3 bg-light rounded shadow-sm d-flex justify-content-between align-items-center mb-3">
    <div>
      <h5 class="mb-0"><i class="bi bi-journal-text text-success me-2"></i> <?php echo $page_title; ?></h5>
      <small class="text-muted">Update and manage your farm supplies and resources</small>
    </div>
    <button class="btn btn-success px-4 rounded-pill" data-bs-toggle="modal" data-bs-target="#exampleModal">
      <i class="bi bi-plus-circle me-2"></i> Add Resource
    </button>
  </div>

  <!-- Search and Filter -->
  <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
    <input type="text" id="searchResource" class="form-control w-50 mb-2 mb-md-0" placeholder="Search resources...">
    <!-- Optional: Add status filter here if needed -->
  </div>

  <?php if($num > 0): ?>
    <div class="table-responsive shadow-sm rounded-4">
      <table class="table table-hover align-middle mb-0" id="resourceTable">
        <thead class="table-success text-uppercase">
          <tr>
            <th>Type</th>
            <th>Name</th>
            <th>Cost</th>
            <th>Date</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
            extract($row); ?>
            <tr>
              <td><?php echo $type; ?></td>
              <td><?php echo $item_name; ?></td>
              <td>₱<?php echo $cost; ?></td>
              <td><?php echo $date; ?></td>
              <td class="text-center">
                <div class="btn-group" role="group">
                  <button class="btn btn-outline-primary btn-sm rounded-pill me-2" data-bs-toggle="modal" data-bs-target="#edit-farm-resource-modal-<?php echo $id; ?>" title="Edit">
                    <i class="bi bi-pencil-square"></i>
                  </button>
                  <button class="btn btn-outline-warning btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#view-farm-resource-modal-<?php echo $id; ?>" title="View">
                    <i class="bi bi-eye-fill"></i>
                  </button>
                </div>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <?php include_once "../paging.php"; ?>

  <?php else: ?>
    <div class="alert alert-danger shadow-sm rounded-4 mt-3 text-center">
      <i class="bi bi-exclamation-triangle me-2"></i> No resources found
    </div>
  <?php endif; ?>

</div>

<!-- JS for Live Search -->
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("searchResource");
    const table = document.getElementById("resourceTable");
    if (!table) return;
    const rows = table.querySelectorAll("tbody tr");

    searchInput.addEventListener("input", () => {
      const filter = searchInput.value.toLowerCase();
      rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? "" : "none";
      });
    });
  });
</script>

<!-- Optional CSS -->
<style>
  .table-hover tbody tr:hover {
    background-color: #fff7e6;
    transition: background-color 0.3s ease;
  }
  .btn-group .btn:hover {
    transform: translateY(-2px);
    transition: transform 0.2s ease;
  }
</style>
