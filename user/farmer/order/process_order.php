<?php 
$order_id = isset($_GET['pid']) ? $_GET['pid'] : die('ERROR: missing ID.');
include_once '../../../config/core.php';
include_once '../../../config/database.php';
include_once '../../../objects/order.php'; 
include_once '../../../objects/product.php';
include_once '../../../objects/user.php';
include_once '../../../objects/order_status_history.php';

$page_title = "Order Processing | Harvest Hub";
include_once "../layout/layout_head.php";

$require_login = true;
include_once "../../../login_checker.php";

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);
$product = new Product($db);
$customer = new User($db);
$order_status_history = new OrderHistory($db);

// Load Data
$order->id = $order_id;
$order->readOneOrder();
$product->product_id = $order->product_id; 
$product->getProductInfo();
$customer->id = $order->customer_id;
$customer->getShippingAddress();

// Pathing logic
$user_id = $product->user_id;
$raw_product_image = $product->product_image;
$product_type = $product->product_type;
$product_image_path = ($product_type == 'preorder') 
    ? "{$base_url}user/uploads/{$user_id}/posted_crops/{$raw_product_image}" 
    : "{$base_url}user/uploads/{$user_id}/products/{$raw_product_image}";

// Financials
$unit = strtolower($order->unit);
$quantity_in_kg = ($unit === 'kg') ? $order->quantity : $order->quantity / 1000;
$subtotal = $product->price_per_unit * $quantity_in_kg;
$service_fee = $subtotal * 0.0225;
$grand_total = $subtotal - $service_fee;

// Form Processing
if ($_POST) {
    if (!empty($_POST['action'])) {
        $order->id = $_POST['order_id'];
        $order->status = $_POST['action'];

        if ($order->processOrder($_POST['action'])) {
            $product->sold_count = $_POST['product_quantity'];
            $product->quantity = $_POST['product_quantity'];
            $product->product_id = $_POST['product_id'];
            $product->deductStock();

            $order_status_history->product_id = $order->product_id;
            $order_status_history->status = $_POST['action'];
            $order_status_history->invoice_number = $order->invoice_number;
            $order_status_history->timestamp = date("Y-m-d H:i:s");
            $order_status_history->recordStatus();

            echo "<script>window.location.href='process_order.php?pid=$order_id&msg=success';</script>";
        }
    }
}
?>

<style>
    :root {
        --harvest-green: #2dce89;
        --glass-bg: rgba(255, 255, 255, 0.9);
    }

    body { background-color: #f0f2f5; font-family: 'Plus Jakarta Sans', sans-serif; }

    .main-card {
        background: var(--glass-bg);
        border-radius: 24px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        overflow: hidden;
    }

    .status-banner {
        background: linear-gradient(90deg, #11cdef 0%, #1171ef 100%);
        color: white;
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 25px;
    }

    .info-box {
        background: #ffffff;
        border: 1px solid #e9ecef;
        border-radius: 16px;
        padding: 20px;
        height: 100%;
    }

    /* WAYBILL DESIGN */
    .waybill-card {
        width: 100%;
        max-width: 500px;
        margin: 0 auto;
        color: #000;
        background: #fff;
        border: 2px solid #000;
        font-family: Arial, sans-serif;
    }

    .wb-header { border-bottom: 2px solid #000; padding: 15px; display: flex; justify-content: space-between; align-items: center; }
    .wb-section { border-bottom: 1px solid #000; padding: 15px; }
    .wb-grid { display: flex; width: 100%; }
    .wb-col { flex: 1; padding: 15px; border-right: 1px solid #000; }
    .wb-col:last-child { border-right: none; }
    
    .text-bold { font-weight: bold; }
    .text-large { font-size: 1.4rem; line-height: 1.2; }
    .address-box { font-size: 1rem; line-height: 1.3; margin-top: 5px; }

    @media print {
        body * { visibility: hidden; }
        #waybill-area, #waybill-area * { visibility: visible; }
        #waybill-area { position: absolute; left: 0; top: 0; width: 100%; border: none; }
        .no-print { display: none !important; }
    }
</style>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <div>
            <h3 class="fw-bold mb-0">Process Order</h3>
            <p class="text-muted small">Update fulfillment and print logistics labels</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-dark px-4 rounded-pill" onclick="location.href='order.php'">Back</button>
            <button class="btn btn-dark px-4 rounded-pill shadow" data-bs-toggle="modal" data-bs-target="#waybillModal">
                <i class="bi bi-printer me-2"></i> Print Waybill
            </button>
        </div>
    </div>

    <div class="row g-4 no-print">
        <div class="col-lg-8">
            <div class="main-card p-4">
                <div class="status-banner d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white-50 small text-uppercase fw-bold">Current Status</span>
                        <h4 class="mb-0 fw-bold"><?php echo strtoupper($order->status); ?></h4>
                    </div>
                    <i class="bi bi-box-seam fs-1 opacity-50"></i>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <img src="<?php echo $product_image_path; ?>" class="img-fluid rounded-4 border shadow-sm" style="width: 100%; height: 200px; object-fit: cover;">
                    </div>
                    <div class="col-md-8">
                        <span class="badge bg-soft-success text-success mb-2 px-3 py-2 rounded-pill"><?php echo strtoupper($product_type); ?></span>
                        <h3 class="fw-bold text-dark"><?php echo $product->product_name; ?></h3>
                        <div class="d-flex gap-4 mt-3">
                            <div>
                                <p class="text-muted small mb-0 text-uppercase">Quantity</p>
                                <h5 class="fw-bold"><?php echo $order->quantity . ' ' . $order->unit; ?></h5>
                            </div>
                            <div>
                                <p class="text-muted small mb-0 text-uppercase">Invoice</p>
                                <h5 class="fw-bold text-primary">#<?php echo $order->invoice_number; ?></h5>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4 opacity-5">

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="info-box">
                            <h6 class="fw-bold mb-3"><i class="bi bi-person-circle me-2 text-primary"></i> Buyer Information</h6>
                            <p class="mb-1 fw-bold"><?php echo $customer->firstname ." ". $customer->lastname; ?></p>
                            <p class="mb-1 text-muted small"><i class="bi bi-telephone me-1"></i> <?php echo $customer->contact_number; ?></p>
                            <p class="mb-0 small text-muted"><i class="bi bi-geo-alt me-1"></i> <?php echo $customer->address . ', ' . $customer->barangay . ', ' . $customer->municipality; ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box">
                            <h6 class="fw-bold mb-3"><i class="bi bi-credit-card me-2 text-primary"></i> Payment Method</h6>
                            <h5 class="text-success fw-bold mb-1"><?php echo $order->mode_of_payment; ?></h5>
                            <p class="small text-muted mb-0">Verified via Harvest Hub Gateway</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="main-card p-4 mb-4">
                <h5 class="fw-bold mb-4">Earnings</h5>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Gross Subtotal</span>
                    <span class="fw-bold">₱<?php echo number_format($subtotal, 2); ?></span>
                </div>
                <div class="d-flex justify-content-between mb-3 text-danger">
                    <span class="small">System Fee (2.25%)</span>
                    <span class="fw-bold">- ₱<?php echo number_format($service_fee, 2); ?></span>
                </div>


                <div class="border-top pt-3 d-flex justify-content-between align-items-center">
                    <span class="fw-bold fs-5">Net Payout</span>
                    <span class="text-success fw-bold fs-3">₱<?php echo number_format($grand_total, 2); ?></span>
                </div>
            </div>

            <div class="main-card p-4">
                <h5 class="fw-bold mb-3 small text-uppercase text-muted">Order Controls</h5>
                <form method="POST" id="actionForm">
                    <input type="hidden" name="product_id" value="<?php echo $order->product_id; ?>">
                    <input type="hidden" name="order_id" value="<?php echo $order->id; ?>">
                    <input type="hidden" name="product_quantity" value="<?php echo $order->quantity; ?>">
                    <input type="hidden" name="action" id="actionInput">

                    <?php
                    $status = $order->status;
                    $type = $product->product_type;
                    $estimated_harvest = $product->estimated_harvest_date; // Dynamic date from DB
                    $today = date("Y-m-d");
                    $isNotHarvestDate = ($today < $estimated_harvest);

                    if ($status == "order placed") {
                        $btnVal = ($type == "preorder") ? "accept pre-order" : "accept";
                        echo "<button type='button' onclick='confirmSubmit(\"$btnVal\")' class='btn btn-success w-100 py-3 rounded-4 fw-bold mb-2'>ACCEPT ORDER</button>";
                    } 
                    elseif ($status == "accept" || $status == "accept pre-order") {
                        $btnVal = ($type == "preorder") ? "pre-order shipout" : "order shipout";
                        
                        // HARVEST DATE CHECK
                        $disabled = ($type == "preorder" && $isNotHarvestDate) ? "disabled" : "";
                        
                        echo "<button type='button' $disabled onclick='confirmSubmit(\"$btnVal\")' class='btn btn-primary w-100 py-3 rounded-4 fw-bold mb-2'>READY TO SHIP</button>";
                        
                        if($type == "preorder" && $isNotHarvestDate) {
                            echo "<div class='alert alert-warning border-0 small mt-2 text-center fw-bold text-dark'>
                                    <i class='bi bi-clock-history'></i> Wait for harvest date: $estimated_harvest
                                  </div>";
                        }
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="waybillModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header no-print">
                <h5 class="fw-bold">Logistics Waybill Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <div id="waybill-area" class="waybill-card">
                    <div class="wb-header">
                        <div>
                            <h4 class="m-0 fw-bold">HARVEST HUB</h4>
                            <p class="m-0 small text-bold">STANDARD DELIVERY</p>
                        </div>
                        <div class="text-end">
                            <span class="border border-dark px-2 py-1 text-bold">DOM</span>
                        </div>
                    </div>

                    <div class="wb-section text-center py-4">
                        <h2 class="fw-bold mb-0"># <?php echo $order->invoice_number; ?></h2>
                        <p class="small text-muted">ORDER REF: HH-<?php echo time(); ?></p>
                    </div>

                    <div class="wb-grid">
                        <div class="wb-col" style="flex: 2;">
                            <p class="text-bold mb-1 small">RECEIVER (TO):</p>
                            <p class="text-large text-bold mb-0"><?php echo strtoupper($customer->firstname ." ". $customer->lastname); ?></p>
                            <p class="mb-1 text-bold"><?php echo $customer->contact_number; ?></p>
                            <div class="address-box">
                                <?php echo $customer->address . ', ' . $customer->barangay . ', ' . $customer->municipality; ?>
                            </div>
                        </div>
                        <div class="wb-col text-center" style="flex: 1;">
                            <p class="small mb-1">MUNICIPALITY</p>
                            <h5 class="text-bold"><?php echo strtoupper($customer->municipality); ?></h5>
                        </div>
                    </div>

                    <div class="wb-grid" style="border-top: 1px solid #000;">
                        <div class="wb-col" style="flex: 2;">
                            <p class="text-bold mb-1 small">PRODUCT NAME</p>
                            <p class="mb-0 small"><?php echo $product->product_name; ?> x <?php echo $order->quantity; ?> <?php echo $order->unit; ?></p>
                        </div>
                        <div class="wb-col text-center" style="flex: 1;">
                            <p class="text-bold mb-1 small">COD AMOUNT</p>
                            <h5 class="text-bold">₱<?php echo number_format($subtotal, 0); ?></h5>
                        </div>
                    </div>

                    <div class="wb-section py-4 text-center">
                         <h4 class="text-bold mb-0"><?php echo strtoupper($order->mode_of_payment); ?></h4>
                         <p class="small mb-0">Verified Logistics Partner</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer no-print">
                <button class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary px-4" onclick="window.print()">Print Label</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmSubmit(action) {
    document.getElementById('actionInput').value = action;
    Swal.fire({
        title: 'Confirm',
        text: "Update status to: " + action.toUpperCase() + "?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#2dce89',
        confirmButtonText: 'Yes, Proceed'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('actionForm').submit();
        }
    });
}
</script>

<?php include_once "../layout/layout_foot.php"; ?>