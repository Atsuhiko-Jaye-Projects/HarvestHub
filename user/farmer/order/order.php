<?php 
include_once '../../../config/core.php';
include_once '../../../config/database.php';
include_once '../../../objects/order.php'; 

$page_title = "Order Management";
include_once "../layout/layout_head.php";

$require_login = true;
include_once "../../../login_checker.php";

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);

$page_url = "{$home_url}user/farmer/order/order.php?";
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 5;
$from_record_num = ($records_per_page * $page) - $records_per_page;

$order->farmer_id = $_SESSION['user_id'];

// --- FUNCTIONAL FILTER LOGIC START ---
$action = isset($_GET['action']) ? $_GET['action'] : 'view_all';

// Dito natin i-aadjust yung query base sa pinindot na filter
if ($action == 'shipped_out') {
    // Note: Siguraduhin na ang status string ay tugma sa database values mo
    $query = "SELECT * FROM orders WHERE farmer_id = ? AND status LIKE '%shipout%' ORDER BY created_at DESC LIMIT ?, ?";
    $stmt = $db->prepare($query);
    $stmt->bindParam(1, $order->farmer_id);
    $stmt->bindParam(2, $from_record_num, PDO::PARAM_INT);
    $stmt->bindParam(3, $records_per_page, PDO::PARAM_INT);
    $stmt->execute();
} elseif ($action == 'completed') {
    $query = "SELECT * FROM orders WHERE farmer_id = ? AND status LIKE '%complete%' ORDER BY created_at DESC LIMIT ?, ?";
    $stmt = $db->prepare($query);
    $stmt->bindParam(1, $order->farmer_id);
    $stmt->bindParam(2, $from_record_num, PDO::PARAM_INT);
    $stmt->bindParam(3, $records_per_page, PDO::PARAM_INT);
    $stmt->execute();
} elseif ($action == 'cancelled') {
    $query = "SELECT * FROM orders WHERE farmer_id = ? AND status LIKE '%cancel%' ORDER BY created_at DESC LIMIT ?, ?";
    $stmt = $db->prepare($query);
    $stmt->bindParam(1, $order->farmer_id);
    $stmt->bindParam(2, $from_record_num, PDO::PARAM_INT);
    $stmt->bindParam(3, $records_per_page, PDO::PARAM_INT);
    $stmt->execute();
} else {
    // Default: View All
    $stmt = $order->readOrders($from_record_num, $records_per_page);
}
// --- FUNCTIONAL FILTER LOGIC END ---

$num = $stmt->rowCount();
$total_rows = $order->countAll();
?>

<style>
    :root {
        --glass-bg: rgba(255, 255, 255, 0.9);
        --primary-green: #10b981;
        --deep-green: #059669;
    }

    body { background-color: #f8fafc; font-family: 'Inter', sans-serif; }

    /* Header Styling */
    .page-header {
        background: linear-gradient(135deg, var(--deep-green) 0%, var(--primary-green) 100%);
        border-radius: 20px;
        padding: 2rem;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.1);
    }

    /* Search Bar Modernization */
    .search-container {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .form-control-modern {
        border-radius: 10px;
        padding: 0.6rem 1.2rem;
        border: 1px solid #e2e8f0;
        background: #f1f5f9;
    }

    .form-control-modern:focus {
        background: white;
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

    /* Table Styling */
    .order-table-container {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }

    .table thead {
        background: #f8fafc;
        border-bottom: 2px solid #f1f5f9;
    }

    .table thead th {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 700;
        color: #64748b;
        padding: 1.2rem;
    }

    .table tbody tr { transition: all 0.2s; border-bottom: 1px solid #f1f5f9; }
    .table tbody tr:hover { background-color: #f1f5f9; }

    /* Badge Customization */
    .status-pill {
        font-size: 0.7rem;
        font-weight: 700;
        padding: 6px 12px;
        border-radius: 8px;
        text-transform: uppercase;
    }

    .btn-view {
        background: white;
        border: 1px solid #e2e8f0;
        color: #1e293b;
        font-weight: 600;
        border-radius: 10px;
        padding: 6px 16px;
        transition: all 0.2s;
    }

    .btn-view:hover {
        background: var(--primary-green);
        color: white;
        border-color: var(--primary-green);
        transform: translateY(-1px);
    }

    .invoice-id {
        color: var(--deep-green);
        font-family: 'Monaco', 'Consolas', monospace;
        font-weight: 700;
    }
</style>

<div class="container py-5">
    <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
        <div>
            <h2 class="fw-bold m-0"><i class="bi bi-receipt-cutoff me-2"></i>Order Information</h2>
            <p class="m-0 opacity-75 small">Manage and track your customer orders and transactions.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-white text-success px-3 py-2 rounded-pill fw-bold">
                <?php echo $num; ?> Results
            </span>
        </div>
    </div>

    <div class="search-container mb-4">
        <form class="row g-3 align-items-center" role="search" method="GET" action="order.php">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="search" id="orderSearch" name="search" class="form-control form-control-modern border-start-0" placeholder="Live search in current view...">
                </div>
            </div>
            
            <div class="col-md-7 d-flex justify-content-md-end gap-2">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle fw-600 border" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-filter-right me-1"></i> 
                        <?php 
                            // Display active filter name
                            echo ($action == 'view_all') ? 'All Orders' : ucwords(str_replace('_', ' ', $action)); 
                        ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2">
                        <li><a class="dropdown-item rounded-2 <?php echo $action=='view_all'?'active bg-success':''; ?>" href="order.php?action=view_all">View All</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item rounded-2 <?php echo $action=='shipped_out'?'active bg-success':''; ?>" href="order.php?action=shipped_out">In Transit</a></li>
                        <li><a class="dropdown-item rounded-2 <?php echo $action=='completed'?'active bg-success':''; ?>" href="order.php?action=completed">Completed</a></li>
                        <li><a class="dropdown-item rounded-2 text-danger <?php echo $action=='cancelled'?'active bg-danger text-white':''; ?>" href="order.php?action=cancelled">Cancelled</a></li>
                    </ul>
                </div>
                <a href="order.php" class="btn btn-success px-4 fw-bold shadow-sm" style="border-radius: 10px;">
                    <i class="bi bi-arrow-clockwise"></i>
                </a>
            </div>
        </form>
    </div>

    <?php if ($num > 0) { ?>
        <div class="order-table-container">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Invoice No.</th>
                            <th>Payment Mode</th>
                            <th>Quantity</th>
                            <th>Order Date</th>
                            <th class="text-center">Status</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody id="orderTableBody">
                        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);
                            $status = $row['status'] ?? 'N/A';

                            $status_clean = strtolower($status);
                            $statusClass = match (true) {
                                str_contains($status_clean, 'placed') => 'bg-warning-subtle text-warning border border-warning-subtle',
                                str_contains($status_clean, 'confirmed'), str_contains($status_clean, 'complete'), str_contains($status_clean, 'received') => 'bg-success-subtle text-success border border-success-subtle',
                                str_contains($status_clean, 'decline'), str_contains($status_clean, 'cancel') => 'bg-danger-subtle text-danger border border-danger-subtle',
                                str_contains($status_clean, 'shipout'), str_contains($status_clean, 'accept') => 'bg-primary-subtle text-primary border border-primary-subtle',
                                default => 'bg-secondary-subtle text-secondary'
                            };
                        ?>
                        <tr>
                            <td class="ps-4">
                                <span class="invoice-id"><?php echo $row['invoice_number']; ?></span>
                                <div class="mt-1">
                                    <?php if ($row['product_type'] === 'preorder'): ?>
                                        <span class="badge bg-info-subtle text-info small" style="font-size: 0.6rem;">PRE-ORDER</span>
                                    <?php else: ?>
                                        <span class="badge bg-success-subtle text-success small" style="font-size: 0.6rem;">HARVEST</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-wallet2 me-2 text-muted"></i>
                                    <span class="small fw-600"><?php echo $row['mode_of_payment']; ?></span>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold text-dark"><?php echo $row['quantity']; ?></span>
                                <span class="text-muted small"><?php echo $row['unit']; ?></span>
                            </td>
                            <td>
                                <div class="small text-muted">
                                    <i class="bi bi-calendar3 me-1"></i> <?php echo date("M d, Y", strtotime($row['created_at'])); ?>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="status-pill <?php echo $statusClass; ?>">
                                    <?php echo $status; ?>
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="process_order.php?pid=<?php echo $id;?>" class="btn btn-view btn-sm">
                                    <i class="bi bi-eye-fill me-1"></i> Details
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
            <?php include_once "../paging.php"; ?>
        </div>

    <?php } else { ?>
        <div class="text-center py-5 bg-white rounded-4 border">
            <img src="https://cdn-icons-png.flaticon.com/512/11329/11329060.png" style="width: 80px; opacity: 0.5;" alt="Empty">
            <h5 class="mt-3 text-muted">No orders found.</h5>
            <p class="text-muted small">Try changing your filter or search keywords.</p>
        </div>
    <?php } ?>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("orderSearch");
    const rows = document.querySelectorAll("#orderTableBody tr");

    searchInput.addEventListener("input", function() {
        const filter = this.value. toLowerCase();
        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
});
</script>

<?php include_once "../layout/layout_foot.php"; ?>