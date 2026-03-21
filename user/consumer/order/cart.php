<?php
ob_start();
include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/cart_item.php";
include_once "../../../objects/product.php";
include_once "../../../objects/order.php";
include_once "../../../objects/user.php";
include_once "../../../objects/order_status_history.php";

$database = new Database();
$db = $database->getConnection();

$cart_item = new CartItem($db);
$product = new Product($db);
$order = new Order($db);
$user = new User($db);
$order_history = new OrderHistory($db);

$cart_item->user_id = $_SESSION['user_id'];
$stmt = $cart_item->countCartItem();
$num = $stmt->rowCount();

$user->id = $_SESSION['user_id'];
$row = $user->checkUserAddress();
$complete_address = trim(($row['address'] ?? '') . ' ' . ($row['barangay'] ?? '') . ' ' . ($row['municipality'] ?? '') . ' ' . ($row['province'] ?? ''));

$page_title = "Finalize Order";
include_once "../layout/layout_head.php";
$require_login = true;
include_once "../../../login_checker.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['product_id'])) {
    $date = date("Y-m-d H:i:s");
    $user_id = $_SESSION['user_id'];
    foreach($_POST['product_id'] as $pid){
        $invoice_no = 'INV-' . strtoupper(uniqid());
        $order->product_id = $pid;
        $order->invoice_number = $invoice_no;
        $order->customer_id = $user_id;
        $order->unit = $_POST['unit'][$pid] ?? 'kg';
        $order->mode_of_payment = $_POST['payment_method'];
        $order->quantity = (float)$_POST['quantity'][$pid];
        $order->farmer_id = (int)$_POST['farmer_id'][$pid];
        $order->status = "order placed";
        $order->created_at = $date;
        $order->product_type = $_POST['product_type'][$pid] ?? 'unknown';

        if($order->placeOrder()){
            $order_history->product_id = $pid;
            $order_history->invoice_number = $invoice_no;
            $order_history->status = "order placed";
            $order_history->timestamp = $date;
            $order_history->recordStatus();
            $cart_item->product_id = $pid;
            $cart_item->status = "ordered";
            $cart_item->markCartItemsAsOrdered();
        }
    }
    header("Location: checkout.php?invoice=$invoice_no");
    exit;
}
?>

<style>
    :root {
        --glass-bg: rgba(255, 255, 255, 0.9);
        --primary-accent: #27ae60;
    }
    body { background: #f9fafb; font-family: 'Plus Jakarta Sans', sans-serif; }

    /* Layout & Cards */
    .checkout-wrapper { max-width: 1400px; margin: 0 auto; }
    .main-content-card { background: var(--glass-bg); border-radius: 24px; border: 1px solid #edf2f7; overflow: hidden; }
    .item-row { transition: all 0.3s ease; border-bottom: 1px solid #f1f5f9; padding: 25px; }
    .product-img-v2 { width: 120px; height: 120px; object-fit: cover; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }

    /* Interactive UI */
    .payment-option { border: 2px solid #f1f5f9; border-radius: 16px; padding: 15px; cursor: pointer; transition: 0.2s; text-align: center; display: block; }
    .btn-check:checked + .payment-option { border-color: var(--primary-accent); background: #f0fff4; color: var(--primary-accent); }
    
    .qty-control-v2 { background: #f8fafc; border-radius: 12px; padding: 5px; display: inline-flex; align-items: center; border: 1px solid #e2e8f0; }
    .qty-input-v2 { width: 60px; border: none; background: transparent; text-align: center; font-weight: 700; outline: none; }
    .btn-action-v2 { width: 32px; height: 32px; border-radius: 8px; border: none; background: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }

    /* Terms Section */
    .terms-box { background: #fffbeb; border: 1px solid #fef3c7; border-radius: 12px; padding: 15px; font-size: 0.85rem; }
    .form-check-label a { color: var(--primary-accent); text-decoration: none; font-weight: 600; }
</style>

<div class="container-fluid checkout-wrapper py-5">
    
    <div class="d-flex justify-content-center gap-4 mb-5">
        <div class="d-flex align-items-center gap-2 text-muted small fw-bold"><i class="bi bi-1-circle"></i> Cart</div>
        <div class="d-flex align-items-center gap-2 text-success small fw-bold"><i class="bi bi-2-circle-fill"></i> Checkout</div>
        <div class="d-flex align-items-center gap-2 text-muted small fw-bold"><i class="bi bi-3-circle"></i> Finished</div>
    </div>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" id="checkoutForm">
        <div class="row g-5">
            
            <div class="col-xl-8">
                <div class="main-content-card shadow-sm">
                    <div class="p-4 bg-white border-bottom">
                        <h4 class="fw-bold mb-0">Review Your Items</h4>
                    </div>

                    <?php if ($num > 0): while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
                        $product->product_id = $row['product_id'];
                        $product->readProductName();
                        $available_kg = $product->available_stocks;
                        $image_folder = ($row['product_type'] == "harvest") ? "products" : "posted_crops";
                        $image_path = "{$base_url}user/uploads/{$product->user_id}/{$image_folder}/{$product->product_image}";
                    ?>
                    <div class="item-row d-flex align-items-center gap-4">
                        <input type="checkbox" class="form-check-input product-checkbox" name="product_id[]" value="<?php echo $row['product_id']; ?>" style="width:22px; height:22px;">
                        <img src="<?php echo $image_path; ?>" class="product-img-v2">

                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="badge bg-success-subtle text-success border-0 rounded-pill px-3 py-1 mb-2 small fw-bold">
                                        <?php echo strtoupper($row['product_type']); ?>
                                    </span>
                                    <h5 class="fw-bold text-dark mb-1 text-capitalize"><?php echo htmlspecialchars($product->product_name); ?></h5>
                                    <p class="text-muted small mb-0">Farmer ID: <?php echo $product->user_id; ?> | Stock: <?php echo $available_kg; ?>kg</p>
                                </div>
                                <h4 class="fw-bold text-success item-total-price">₱0.00</h4>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="qty-control-v2 shadow-sm">
                                        <button type="button" class="btn-action-v2 decrease-qty"><i class="bi bi-dash"></i></button>
                                        <input type="number" step="any" name="quantity[<?php echo $row['product_id']; ?>]" 
                                               class="qty-input-v2 quantity-input" 
                                               value="<?php echo $row['quantity']; ?>" 
                                               data-stock-kg="<?php echo $available_kg; ?>">
                                        <button type="button" class="btn-action-v2 increase-qty"><i class="bi bi-plus"></i></button>
                                    </div>
                                    <select name="unit[<?php echo $row['product_id']; ?>]" class="form-select border-0 bg-light rounded-3 unit-selector" style="width: 110px;">
                                        <option value="kg" <?php echo ($row['unit']=='kg')?'selected':''; ?>>KG</option>
                                        <option value="gram" <?php echo ($row['unit']=='gram')?'selected':''; ?>>Gram</option>
                                    </select>
                                </div>
                                <button type="button" class="btn btn-sm text-danger fw-bold delete_cart_item" data-id="<?php echo $row['product_id']; ?>">Remove Item</button>
                            </div>
                        </div>
                        <input type="hidden" class="base-price" value="<?php echo $row['amount']; ?>">
                        <input type="hidden" name="farmer_id[<?php echo $row['product_id']; ?>]" value="<?php echo $product->user_id; ?>">
                        <input type="hidden" name="product_type[<?php echo $row['product_id']; ?>]" value="<?php echo $row['product_type']; ?>">
                    </div>
                    <?php endwhile; endif; ?>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="p-4 bg-white rounded-4 shadow-sm border border-light position-sticky" style="top: 20px;">
                    <h5 class="fw-bold mb-4">Order Summary</h5>
                    
                    <div class="d-flex justify-content-between mb-3 text-muted">
                        <span>Items Count</span>
                        <span class="fw-bold text-dark" id="items-count">0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 text-muted">
                        <span>Subtotal</span>
                        <span class="fw-bold text-dark" id="subtotal-price">₱0.00</span>
                    </div>

                    <div class="d-flex justify-content-between mb-4 text-muted" id="shipping-row">
                        <span>Shipping Fee</span>
                        <span class="fw-bold text-success">₱50.00</span>
                    </div>
                    
                    <div class="bg-light rounded-4 p-4 mb-4 border border-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-dark">Grand Total</span>
                            <h2 class="fw-bold text-primary mb-0" id="grand-total">₱0.00</h2>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold small mb-3">PAYMENT METHOD</h6>
                        <div class="row g-3">
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="payment_method" id="COP" value="COP" required>
                                <label class="payment-option shadow-sm fw-bold small" for="COP">CASH ON PICK-UP</label>
                            </div>
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="payment_method" id="COD" value="COD">
                                <label class="payment-option shadow-sm fw-bold small" for="COD">CASH ON DELIVERY</label>
                            </div>
                        </div>
                    </div>

                    <div class="terms-box mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="termsCheckbox" required>
                            <label class="form-check-label" for="termsCheckbox">
                                I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms & Conditions</a>. 
                                <br><span class="text-warning fw-bold"><i class="bi bi-clock-history"></i> Free cancellation within 2 hours.</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" id="mainSubmitBtn" class="btn btn-success btn-lg w-100 py-3 rounded-4 fw-bold shadow-lg disabled">
                        COMPLETE ORDER
                    </button>
                    <p class="text-center text-muted small mt-3 mb-0">Secure checkout process powered by HarvestHub.</p>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="termsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="fw-bold">Terms & Conditions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <h6 class="fw-bold">1. Cancellation Policy</h6>
                <p class="text-muted small">Orders can be cancelled free of charge within **two (2) hours** from the time the order was placed. After this window, the farmer may have already prepared the harvest.</p>
                <h6 class="fw-bold">2. Payment</h6>
                <p class="text-muted small">For COP/COD, please ensure the exact amount is ready. Fraudulent orders will result in account suspension.</p>
                <h6 class="fw-bold">3. Product Quality</h6>
                <p class="text-muted small">As these are agricultural products, slight variations in appearance may occur compared to listing photos.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-dark w-100 py-2 rounded-pill" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="limitModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-body text-center p-5">
                <i class="bi bi-exclamation-triangle-fill text-warning fs-1"></i>
                <h4 class="fw-bold mt-3">Maximum Limit!</h4>
                <p class="text-muted">You have reached the maximum available stocks for this specific product.</p>
                <button type="button" class="btn btn-dark w-100 mt-3 rounded-pill" data-bs-dismiss="modal">Got it</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const limitModal = new bootstrap.Modal(document.getElementById('limitModal'));
    const termsCheck = document.getElementById('termsCheckbox');
    const submitBtn = document.getElementById('mainSubmitBtn');

    // Enable/Disable Submit based on Terms
    termsCheck.addEventListener('change', function() {
        if (this.checked) {
            submitBtn.classList.remove('disabled');
        } else {
            submitBtn.classList.add('disabled');
        }
    });

    function calculate() {
        let itemsCount = 0; 
        let subtotal = 0; 
        
        // DINAGDAG NA LOGIC PARA SA SHIPPING HIDE/SHOW
        const isCOD = document.getElementById("COD").checked;
        const shippingRow = document.getElementById("shipping-row");
        
        if (isCOD) {
            shippingRow.classList.add("d-flex");
            shippingRow.classList.remove("d-none");
        } else {
            shippingRow.classList.add("d-none");
            shippingRow.classList.remove("d-flex");
        }

        const ship = isCOD ? 50 : 0;

        document.querySelectorAll(".item-row").forEach(row => {
            const qtyInput = row.querySelector(".quantity-input");
            const unit = row.querySelector(".unit-selector").value;
            const price = parseFloat(row.querySelector(".base-price").value);
            const stockKg = parseFloat(qtyInput.dataset.stockKg);
            let qty = parseFloat(qtyInput.value) || 0;
            const limit = (unit === 'kg') ? stockKg : (stockKg * 1000);

            if (qty > limit) { qtyInput.value = limit; qty = limit; limitModal.show(); }

            let total = (unit === 'kg') ? (price * qty) : (price * (qty / 1000));
            row.querySelector(".item-total-price").innerText = "₱" + total.toLocaleString(undefined, {minimumFractionDigits: 2});

            if (row.querySelector(".product-checkbox").checked) {
                subtotal += total; itemsCount++;
            }
        });
        document.getElementById("items-count").innerText = itemsCount;
        document.getElementById("subtotal-price").innerText = "₱" + subtotal.toLocaleString(undefined, {minimumFractionDigits: 2});
        document.getElementById("grand-total").innerText = "₱" + (itemsCount > 0 ? subtotal + ship : 0).toLocaleString(undefined, {minimumFractionDigits: 2});
    }

    // DINAGDAG NA LISTENER PARA SA PAYMENT RADIO BUTTONS
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', calculate);
    });

    document.addEventListener("input", e => { if (e.target.matches(".quantity-input, .unit-selector, .product-checkbox")) calculate(); });
    document.addEventListener("click", e => {
        const btn = e.target.closest(".increase-qty, .decrease-qty");
        if (btn) {
            const input = btn.closest(".qty-control-v2").querySelector(".quantity-input");
            let v = parseFloat(input.value) || 0;
            input.value = btn.classList.contains("increase-qty") ? v + 1 : Math.max(0, v - 1);
            calculate();
        }
    });

    document.querySelectorAll(".delete_cart_item").forEach(btn => {
        btn.addEventListener("click", function() {
            if(confirm("Remove?")) {
                const id = this.dataset.id;
                fetch("delete_cart_item.php", { method: "POST", headers: { "Content-Type": "application/x-www-form-urlencoded" }, body: "id=" + id })
                .then(() => { this.closest(".item-row").remove(); calculate(); });
            }
        });
    });
    calculate();
});
</script>

<?php include_once "../layout/layout_foot.php"; ?>