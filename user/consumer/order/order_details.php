<?php
$order_id = isset($_GET['vod']) ? $_GET['vod'] : die('ERROR: missing ID.');
include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/order.php";
include_once "../../../objects/user.php";
include_once "../../../objects/product.php";
include_once "../../../objects/order_status_history.php";

$page_title = "Order Details";
include_once "../layout/layout_head.php";

$require_login=true;
include_once "../../../login_checker.php";

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);
$product = new Product($db);
$user = new User($db);
$farmer = new User($db);
$order_status = new OrderHistory($db);

$order->id = $order_id;
$order->readOrderDetails();

// Customer Info
$user->id = $order->customer_id;
$user->getShippingAddress();
$shipping_address = "{$user->address}, {$user->barangay}, {$user->municipality}";


$product->product_id = $order->product_id;
// get image location base on product type


if ($order->product_type == "harvest") {
    // get harvested product type
    $product->getHarvestProductInfo();
    $image_path = "{$base_url}user/uploads/{$product->user_id}/products/{$product->product_image}";
}else{
    $product->getProductInfo();
    $image_path = "{$base_url}user/uploads/{$product->user_id}/posted_crops/{$product->product_image}";
}

if ($order->mode_of_payment == "COD") {
    // get the coordinates of two user
    $user->sender_id = $order->farmer_id;
    $user->reciever_id = $order->customer_id;
    $user->getShippingLocation();

    // sender location
    $sender_latitude = $user->sender_latitude;
    $sender_longitude = $user->sender_longitude;

    // reciever location
    $reciever_latitude = $user->reciever_latitude;
    $reciever_longitude = $user->reciever_longitude;

    $distanceText = "";
    $durationText = "";

    $apiKey = "eyJvcmciOiI1YjNjZTM1OTc4NTExMTAwMDFjZjYyNDgiLCJpZCI6IjE1Mjc3ZmM2ZGM3ZDQ5M2M4NWMxNWExNmQ4MWMxMmNkIiwiaCI6Im11cm11cjY0In0=";

    $url = "https://api.openrouteservice.org/v2/directions/driving-car";

    $data = [
        "coordinates" => [
            [(float)$sender_longitude, (float)$sender_latitude],
            [(float)$reciever_longitude, (float)$reciever_latitude]
        ]
    ];

    $options = [
        "http" => [
            "header"  => "Content-type: application/json\r\n" .
                        "Authorization: $apiKey\r\n",
            "method"  => "POST",
            "content" => json_encode($data),
        ]
    ];

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result !== FALSE) {
        $response = json_decode($result, true);

        if (isset($response['routes'][0])) {
            $distance = $response['routes'][0]['summary']['distance'];
            $duration = $response['routes'][0]['summary']['duration'];

            $distanceText = round($distance / 1000, 2) . " km";
            $distanceValue = round($distance / 1000, 2);
            $durationText = round($duration / 60, 2) . " minutes";
        } else {
            $distanceText = "Route not found.";
        }
    } else {
        $distanceText = "API request failed.";
    }


    $quantity = $order->quantity;
    $unit = strtolower($order->unit);
    $quantity_in_kg = ($unit == 'kg') ? $quantity : $quantity / 1000;
    $price_per_kg = $product->price_per_unit;
    $total = $price_per_kg * $quantity_in_kg;
    $additional_fare = $distanceValue * 5;
    $shipping_fee = 50 + $additional_fare;
    $service_fee = $total * 0.0225;
    $subtotal = $total - $service_fee;
    $grand_total = $shipping_fee + $subtotal;
    // shipping fee
}else{
    // Pricing Logic
    $quantity = $order->quantity;
    $unit = strtolower($order->unit);
    $quantity_in_kg = ($unit == 'kg') ? $quantity : $quantity / 1000;
    $price_per_kg = $product->price_per_unit;
    $total = $price_per_kg * $quantity_in_kg;
    $service_fee = $total * 0.0225;
    $grand_total = $total + $service_fee;
}




// Farmer Info
$farmer->id = $product->user_id;
$farmer->getFarmerInfo();
$farmer_address = "{$farmer->address}, {$farmer->barangay}, {$farmer->municipality}, {$farmer->province}";
$farmer_contact = $farmer->contact_number; // FIXED: Added this to prevent Warning

// Order History for Vertical Tracking
$order_status->invoice_number = $order->invoice_number;
$order_status->product_id = $order->product_id;
$stmt = $order_status->getOrderStatus();



?>

<style>
    .info-box {
        background: #ffffff;
        border-radius: 15px;
        padding: 20px;
        border: 1px solid rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }
    .info-box h6 {
        color: #64748b;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 15px;
    }
    .status-badge {
        font-size: 0.7rem;
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 700;
        text-transform: uppercase;
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }
    .product-img-box {
        width: 70px;
        height: 70px;
        background: #f8f9fa;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
</style>

<div class="row g-4">
    <div class="col-xl-8">
        <?php 
            include_once "modal/cancel_order_modal.php"; 
            include_once "modal/confirm_order_modal.php"; 
            include_once "modal/receive_pre_order_product.php"; 
            include_once "modal/receive_order.php"; 
        ?>

        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h4 class="fw-800 m-0">Order <span class="text-success">#<?php echo htmlspecialchars($order->invoice_number); ?></span></h4>
                <p class="text-muted small m-0"><i class="bi bi-calendar3"></i> <?php echo date("M d, Y", strtotime($order->created_at)); ?></p>
            </div>
            <span class="status-badge">
                <?php echo $order->status; ?>
            </span>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="info-box shadow-sm h-100">
                    <h6><i class="bi bi-geo-alt-fill text-success"></i> Delivery Address</h6>
                    <p class="mb-1 fw-bold"><?php echo htmlspecialchars($user->firstname . " " . $user->lastname); ?></p>
                    <p class="small text-muted mb-2"><?php echo htmlspecialchars($shipping_address); ?></p>
                    <p class="small text-muted m-0"><i class="bi bi-phone"></i> <?php echo htmlspecialchars($user->contact_number); ?></p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-box shadow-sm h-100">
                    <h6><i class="bi bi-person-badge-fill text-success"></i> Seller Information</h6>
                    <p class="mb-1 fw-bold"><?php echo htmlspecialchars($farmer->firstname . " " . $farmer->lastname); ?></p>
                    <p class="small text-muted mb-2"><?php echo htmlspecialchars($farmer_address); ?></p>
                    <p class="small text-muted m-0"><i class="bi bi-telephone"></i> <?php echo !empty($farmer_contact) ? htmlspecialchars($farmer_contact) : 'No contact info'; ?></p>
                </div>
            </div>
        </div>

        <div class="info-box shadow-sm mt-4">
            <h6><i class="bi bi-box-seize me-2 text-success"></i>Item Details & Tracking</h6>
            
            <div class="d-flex align-items-center mb-4 bg-light p-3 rounded-4">
                <div class="product-img-box me-3 border">
                    <img src="<?php echo $image_path;?>" style="width: 70px; height: 70px; object-fit: cover;">
                </div>
                <div>
                    <h6 class="m-0 text-dark fw-bold" style="text-transform: none; letter-spacing: 0;"><?php echo htmlspecialchars($product->product_name); ?></h6>
                    <p class="small text-muted m-0"><?php echo $order->quantity . " " . $order->unit; ?> ordered</p>
                </div>
                <div class="ms-auto pe-2">
                    <span class="fw-800 text-success">₱<?php echo number_format($total, 2); ?></span>
                </div>
            </div>

            <hr class="my-4 opacity-5">
            
            <div class="px-2">
                <?php require "tracking_status.php"; ?>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Summary</h5>
                
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Items total</span>
                    <span class="fw-bold">₱<?php echo number_format($total, 2); ?></span>
                </div>
                
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted small">Service Fee (2.25%)</span>
                    <span class="fw-bold">₱<?php echo number_format($service_fee, 2); ?></span>
                </div>
                <?php
                    if ($order->mode_of_payment == "COD") {
                        echo "<div class='d-flex justify-content-between mb-3'>
                            <span class='text-muted small'>
                                Shipping Fee (₱50.00 Base Fare) + 
                                <span class='text-danger fw-semibold'>₱" .number_format($additional_fare, 2) . "</span>
                            </span>
                            <span class='fw-bold'>₱ " . number_format($shipping_fee, 2) . "</span>
                        </div>";
                    }
                ?>
                <div class="p-3 bg-light rounded-3 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Method</span>
                        <span class="badge bg-white text-dark border shadow-sm small fw-bold px-3"><?php echo $order->mode_of_payment; ?></span>
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="h6 m-0 fw-bold">Grand Total</span>
                    <span class="h4 m-0 fw-800 text-success">₱<?php echo number_format($grand_total, 2); ?></span>
                </div>

                <div class="pt-2">
                    <?php
                    switch ($order->status) {
                        case 'order cancelled':
                            echo '<button disabled class="btn btn-secondary w-100 py-3 rounded-4 fw-bold">Cancelled</button>';
                            break;

                        case 'order placed':
                            echo '<button type="button" class="btn btn-outline-danger w-100 py-3 rounded-4 fw-bold" 
                                    data-bs-toggle="modal" data-bs-target="#cancel-order-modal">
                                    <i class="bi bi-x-circle me-1"></i> Cancel Order
                                  </button>';
                            break;

                        case 'order shipout':
                            echo '<button type="button" class="btn btn-success w-100 py-3 rounded-4 fw-bold shadow" 
                                    data-bs-toggle="modal" data-bs-target="#recieve-order-modal">
                                    <i class="bi bi-check-circle me-1"></i> I Received the Order
                                  </button>';
                            break;

                        case 'accept pre-order':
                            echo '<button type="button" class="btn btn-outline-danger w-100 py-3 rounded-4 fw-bold" 
                                    data-bs-toggle="modal" data-bs-target="#cancel-order-modal">
                                    <i class="bi bi-x-circle me-1"></i> Cancel Order
                                  </button>';
                            break;

                        case 'accept':
                            echo '<button type="button" class="btn btn-outline-danger w-100 py-3 rounded-4 fw-bold" 
                                    data-bs-toggle="modal" data-bs-target="#cancel-order-modal">
                                    <i class="bi bi-x-circle me-1"></i> Cancel Order
                                  </button>';
                            break;

                        default:
                            echo '<div class="alert alert-success border-0 rounded-4 text-center small fw-bold mb-0">
                                    <i class="bi bi-check2-all"></i> Transaction Completed
                                  </div>';
                            break;
                    }
                    ?>
                </div>
            </div>
        </div>
        
        <div class="mt-4 p-3 bg-white rounded-4 border border-dashed text-center">
            <small class="text-muted">Need help with this order? <a href="#" class="text-success text-decoration-none fw-bold">Contact Support</a></small>
        </div>
    </div>
</div>

<?php include_once "../layout/layout_foot.php"; ?>