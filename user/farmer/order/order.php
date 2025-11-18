<?php 
include_once '../../../config/core.php';
include_once '../../../config/database.php';
include_once '../../../objects/order.php'; 

$page_title = "Order Info";
include_once "../layout/layout_head.php";

$require_login = true;
include_once "../../../login_checker.php";

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);

$page_url = "{$home_url}user/farmer/order.php?";
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 5;
$from_record_num = ($records_per_page * $page) - $records_per_page;

$order->farmer_id = $_SESSION['user_id'];
$stmt = $order->readOrders($from_record_num, $records_per_page);
$num = $stmt->rowCount();
$total_rows = $order->countAll();
?>

<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-success m-0">
            <i class="bi bi-cart-check me-2"></i> <?php echo $page_title; ?>
        </h2>
        <span class="badge bg-success-subtle text-success border border-success">
            <?php echo $num; ?> Orders Found
        </span>
    </div>

    <!-- Search & Sort Section -->
    <div class="card shadow-sm mb-4 border-0 rounded-4">
        <div class="card-body">
            <form class="d-flex flex-wrap align-items-center gap-3" role="search">
                <div class="input-group flex-grow-1">
                    <span class="input-group-text bg-success text-white">
                        <i class="bi bi-search"></i>
                    </span>
                    <input 
                        class="form-control form-control-lg border-success-subtle"
                        type="search"
                        placeholder="Search orders..."
                        aria-label="Search"
                    />
                </div>

                <button class="btn btn-success px-4" type="submit">
                    <i class="bi bi-funnel me-1"></i> Search
                </button>

                <!-- Sort Dropdown -->
                <div class="dropdown">
                    <button 
                        class="btn btn-outline-success px-4 py-2 dropdown-toggle"
                        type="button" 
                        id="dropdownMenuButton" 
                        data-bs-toggle="dropdown" 
                        aria-expanded="false">
                        <i class="bi bi-sort-down"></i> Sort
                    </button>
                    <ul class="dropdown-menu shadow-sm border-0" aria-labelledby="dropdownMenuButton">
                        <li><a href="order.php?order_type=pending" class="dropdown-item"><i class="bi bi-hourglass-split text-warning me-2"></i>Pending</a></li>
                        <li><a href="manage_harvest.php" class="dropdown-item"><i class="bi bi-x-circle text-danger me-2"></i>Cancelled</a></li>
                        <li><a href="farm_resource.php" class="dropdown-item"><i class="bi bi-check-circle text-success me-2"></i>Completed</a></li>
                    </ul>
                </div>
            </form>
        </div>
    </div>

    <!-- Orders Table -->
    <?php if ($num > 0) { ?>
        <div class="table-responsive shadow-sm rounded-4">
            <table class="table table-hover align-middle text-center">
                <thead class="table-success text-uppercase">
                    <tr>
                        <th>INVOICE NO.</th>
                        <th>MODE OF PAYMENT</th>
                        <th>QTY</th>
                        <th>Date of Order</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        $status = $row['status'] ?? 'N/A';

                        // Status badge color
                        $statusClass = match (strtolower($status)) {
                            'order placed' => 'bg-warning text-dark',
                            'completed' => 'bg-success',
                            'cancelled' => 'bg-danger',
                            default => 'bg-secondary'
                        };
                    ?>
                    <tr class="align-middle">
                        <td class="fw-bold text-success"><?php echo $row['invoice_number']; ?></td>
                        <td><?php echo $row['mode_of_payment']; ?></td>
                        <td class="text-truncate" style="max-width: 150px;"><?php echo $row['quantity']; ?> KG</td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td>
                            <span class="badge <?php echo $statusClass; ?> px-3 py-2 text-uppercase">
                                <?php echo $status; ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?php echo $base_url?>user/farmer/order/process_order.php?pid=<?php echo $id;?>" class="btn btn-outline-success btn-sm rounded-pill px-3">
                                <i class="bi bi-eye me-1"></i> View
                            </button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            <?php include_once "../paging.php"; ?>
        </div>

    <?php } else { ?>
        <div class="alert alert-danger text-center rounded-4 py-3 shadow-sm">
            <i class="bi bi-exclamation-triangle me-2"></i> No orders found.
        </div>
    <?php } ?>
</div>

<?php include_once "../layout/layout_foot.php"; ?>
