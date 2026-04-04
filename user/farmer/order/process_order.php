<?php 
$order_id = isset($_GET['pid']) ? $_GET['pid'] : die('ERROR: missing ID.');
include_once '../../../config/core.php';
include_once '../../../config/database.php';
include_once '../../../objects/order.php'; 
include_once '../../../objects/product.php';
include_once '../../../objects/user.php';
include_once '../../../objects/order_status_history.php';
include_once '../../../objects/crop.php';

$page_title = "Order Processing | Harvest Hub";
include_once "../layout/layout_head.php";

$require_login = true;
include_once "../../../login_checker.php";

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);
$product = new Product($db);
$customer = new User($db);
$user = new User($db);
$order_status_history = new OrderHistory($db);
$crop = new Crop($db);

// Load Data
$order->id = $order_id;
$order->readOneOrder();

$product->product_id = $order->product_id; 

if ($order->product_type == "harvest") {
    $product->getHarvestProductInfo();
    $image_path = "{$base_url}user/uploads/{$product->user_id}/products/{$product->product_image}";
}else{
    $product->getProductInfo();
    $image_path = "{$base_url}user/uploads/{$product->user_id}/posted_crops/{$product->product_image}";
}

if ($order->mode_of_payment == "COD" || $order->mode_of_payment == "COP") {
    $user->sender_id = $order->farmer_id;
    $user->reciever_id = $order->customer_id;
    $user->getShippingLocation();

    // Coordinates with Fallback
    $sender_latitude = !empty($user->sender_latitude) ? $user->sender_latitude : 13.4475;
    $sender_longitude = !empty($user->sender_longitude) ? $user->sender_longitude : 121.8347;
    $reciever_latitude = !empty($user->reciever_latitude) ? $user->reciever_latitude : 13.4767;
    $reciever_longitude = !empty($user->reciever_longitude) ? $user->reciever_longitude : 121.9032;

    $distanceText = "Route calculating...";
    $distanceValue = 2;

    $apiKey = "eyJvcmciOiI1YjNjZTM1OTc4NTExMTAwMDFjZjYyNDgiLCJpZCI6IjE1Mjc3ZmM2ZGM3ZDQ5M2M4NWMxNWExNmQ4MWMxMmNkIiwiaCI6Im11cm11cjY0In0=";
    $url = "https://api.openrouteservice.org/v2/directions/driving-car";
    $data = ["coordinates" => [[(float)$sender_longitude, (float)$sender_latitude], [(float)$reciever_longitude, (float)$reciever_latitude]]];
    $options = ["http" => ["header" => "Content-type: application/json\r\nAuthorization: $apiKey\r\n", "method" => "POST", "content" => json_encode($data)]];

    $context = @stream_context_create($options);
    $result = @file_get_contents($url, false, $context);

    if ($result !== FALSE) {
        $response = json_decode($result, true);
        if (isset($response['routes'][0])) {
            $distance = $response['routes'][0]['summary']['distance'];
            $distanceValue = round($distance / 1000, 2);
            $distanceText = $distanceValue . " km";
        }
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
}else{
    $quantity = $order->quantity;
    $unit = strtolower($order->unit);
    $quantity_in_kg = ($unit == 'kg') ? $quantity : $quantity / 1000;
    $price_per_kg = $product->price_per_unit;
    $total = $price_per_kg * $quantity_in_kg;
    $service_fee = $total * 0.0225;
    $grand_total = $total - $service_fee;
}

$customer->id = $order->customer_id;
$customer->getShippingAddress();

$user_id = $product->user_id;
$raw_product_image = $product->product_image;
$product_type = $product->product_type;
$product_image_path = ($product_type == 'preorder') 
    ? "{$base_url}user/uploads/{$user_id}/posted_crops/{$raw_product_image}" 
    : "{$base_url}user/uploads/{$user_id}/products/{$raw_product_image}";

if ($_POST) {
    if (!empty($_POST['action'])) {
        $order->id = $_POST['order_id'];
        $order->status = $_POST['action'];
        if ($order->processOrder($_POST['action'])) {
            $product->product_id = $_POST['product_id'];
            $product->sold_count = $_POST['product_quantity'];
            $product->quantity = $_POST['product_quantity'];
            
            if ($_POST['action'] == "accept pre-order") {
                $crop->id = $_POST['product_id'];
                $crop->reserve_kg = $_POST['product_quantity'];
                $crop->AddReserveKG();
            }else{
                $product->deductStock();
            }

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

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>


<style>
    :root { --harvest-green: #2dce89; --glass-bg: rgba(255, 255, 255, 0.9); }
    body { background-color: #f0f2f5; font-family: 'Plus Jakarta Sans', sans-serif; }
    .main-card { background: var(--glass-bg); border-radius: 24px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.04); overflow: hidden; }
    .status-banner { background: linear-gradient(90deg, #11cdef 0%, #1171ef 100%); color: white; padding: 20px; border-radius: 15px; margin-bottom: 25px; }
    .info-box { background: #ffffff; border: 1px solid #e9ecef; border-radius: 16px; padding: 20px; height: 100%; position: relative; }
    #map { height: 350px; width: 100%; border-radius: 12px; margin-top: 15px; border: 1px solid #ddd; z-index: 1; }
    .btn-go-live { position: absolute; bottom: 35px; right: 35px; z-index: 1000; background: #fff; border-radius: 50px; padding: 10px 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); text-decoration: none; display: flex; align-items: center; gap: 8px; color: #000; font-weight: bold; border: 1px solid #ddd; }
    
    /* WAYBILL DESIGN */
    .waybill-card { width: 100%; max-width: 500px; margin: 0 auto; color: #000; background: #fff; border: 2px solid #000; font-family: Arial, sans-serif; }
    .wb-header { border-bottom: 2px solid #000; padding: 15px; display: flex; justify-content: space-between; align-items: center; }
    .wb-section { border-bottom: 1px solid #000; padding: 15px; }
    
    @media print { 
        body * { visibility: hidden; } 
        #waybill-area, #waybill-area * { visibility: visible; } 
        #waybill-area { position: absolute; left: 0; top: 0; width: 100%; } 
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
            <?php if ($order->product_type == "harvest"): ?>
                <button class="btn btn-dark px-4 rounded-pill shadow" data-bs-toggle='modal' data-bs-target='#waybillModal'><i class="bi bi-printer me-2"></i> Print Waybill</button>
            <?php endif; ?>
        </div>
    </div>

    <div class="row g-4 no-print">
        <div class="col-lg-8">
            <div class="main-card p-4">
                <div class="status-banner d-flex justify-content-between align-items-center">
                    <div><span class="text-white-50 small text-uppercase fw-bold">Current Status</span><h4 class="mb-0 fw-bold"><?php echo strtoupper($order->status); ?></h4></div>
                    <i class="bi bi-box-seam fs-1 opacity-50"></i>
                </div>
                <div class="row g-3">
                    <div class="col-md-4"><img src="<?php echo $product_image_path; ?>" class="img-fluid rounded-4 border shadow-sm" style="width: 100%; height: 200px; object-fit: cover;"></div>
                    <div class="col-md-8">
                        <span class="badge bg-soft-success text-success mb-2 px-3 py-2 rounded-pill"><?php echo strtoupper($product_type); ?></span>
                        <h3 class="fw-bold text-dark"><?php echo $product->product_name; ?></h3>
                        <div class="d-flex gap-4 mt-3">
                            <div><p class="text-muted small mb-0 text-uppercase">Quantity</p><h5 class="fw-bold"><?php echo $order->quantity . ' ' . $order->unit; ?></h5></div>
                            <div><p class="text-muted small mb-0 text-uppercase">Invoice</p><h5 class="fw-bold text-primary">#<?php echo $order->invoice_number; ?></h5></div>
                        </div>
                    </div>
                </div>
                <hr class="my-4 opacity-5">
                <div class="info-box">
                    <h6 class="fw-bold mb-3"><i class="bi bi-person-circle me-2 text-primary"></i> Buyer & Logistics</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1 fw-bold"><?php echo $customer->firstname ." ". $customer->lastname; ?></p>
                            <p class="mb-1 text-primary small fw-bold"><i class="bi bi-telephone me-1"></i> <?php echo $customer->contact_number; ?></p>
                            <p class="mb-0 small text-muted"><i class="bi bi-geo-alt me-1"></i> <?php echo $customer->address . ', ' . $customer->barangay . ', ' . $customer->municipality; ?></p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h5 class="text-success fw-bold mb-1"><?php echo $order->mode_of_payment; ?></h5>
                            <p class="small text-muted mb-0">Est. Distance: <?php echo $distanceText; ?></p>
                        </div>
                    </div>
                    <a href="https://www.google.com/maps/dir/?api=1&origin=<?php echo $sender_latitude.','.$sender_longitude; ?>&destination=<?php echo $reciever_latitude.','.$reciever_longitude; ?>" target="_blank" class="btn-go-live no-print">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/3/39/Google_Maps_icon_%282015-2020%29.svg" width="20"> Open Route
                    </a>
                    <div id="map"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="main-card p-4 mb-4">
                <h5 class="fw-bold mb-4">Earnings</h5>
                <div class="d-flex justify-content-between mb-2"><span class="text-muted small">Gross Subtotal</span><span class="fw-bold">₱<?php echo number_format($total, 2); ?></span></div>
                <div class="d-flex justify-content-between mb-3 text-danger"><span class="small">System Fee (2.25%)</span><span class="fw-bold">- ₱<?php echo number_format($service_fee, 2); ?></span></div>
                <?php if ($order->mode_of_payment == "COD"): ?>
                    <div class="d-flex justify-content-between mb-3"><span class="text-muted small">Shipping Fee</span><span class="fw-bold">₱<?php echo number_format($shipping_fee, 2); ?></span></div>
                <?php endif; ?>
                <div class="border-top pt-3 d-flex justify-content-between align-items-center">
                    <span class="fw-bold fs-5">Net Payout</span>
                    <span class="text-success fw-bold fs-3">₱<?php echo number_format($grand_total, 2); ?></span>
                </div>
            </div>

            <div class="main-card p-4">
                <form method="POST" id="actionForm">
                    <input type="hidden" name="product_id" value="<?php echo $order->product_id; ?>">
                    <input type="hidden" name="order_id" value="<?php echo $order->id; ?>">
                    <input type="hidden" name="product_quantity" value="<?php echo $order->quantity; ?>">
                    <input type="hidden" name="action" id="actionInput">
                    <?php
                    $status = $order->status;
                    if ($status == "order placed") {
                        $btnVal = ($product->product_type == "preorder") ? "accept pre-order" : "accept";
                        echo "<button type='button' onclick='confirmSubmit(\"$btnVal\")' class='btn btn-success w-100 py-3 rounded-4 fw-bold mb-2'>ACCEPT ORDER</button>";
                    } elseif ($status == "accept" || $status == "accept pre-order") {
                        $btnVal = ($product->product_type == "preorder") ? "pre-order shipout" : "order shipout";
                        echo "<button type='button' onclick='confirmSubmit(\"$btnVal\")' class='btn btn-primary w-100 py-3 rounded-4 fw-bold mb-2'>READY TO SHIP</button>";
                    } else {
                        echo "<button type='button' disabled class='btn btn-outline-secondary w-100 py-3 rounded-4 fw-bold mb-2'>PROCESSED</button>";
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="waybillModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header no-print"><h5>Waybill Preview</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body p-4">
                <div id="waybill-area" class="waybill-card">
                    <div class="wb-header"><h4>HARVEST HUB</h4><span>Standard Delivery</span></div>
                    <div class="wb-section text-center">
                        <small>INVOICE NUMBER</small>
                        <h2 class="mb-0">#<?php echo $order->invoice_number; ?></h2>
                    </div>
                    <div class="wb-section">
                        <p class="mb-1 text-bold small">RECEIVER:</p>
                        <h4 class="mb-0"><?php echo strtoupper($customer->firstname ." ". $customer->lastname); ?></h4>
                        <p class="mb-2 fw-bold"><?php echo $customer->contact_number; ?></p>
                        <p class="small mb-0"><?php echo $customer->address . ', ' . $customer->barangay . ', ' . $customer->municipality; ?></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer no-print">
                <button class="btn btn-primary px-4" onclick="window.print()">Print</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var sLat = <?php echo (float)$sender_latitude; ?>;
    var sLng = <?php echo (float)$sender_longitude; ?>;
    var rLat = <?php echo (float)$reciever_latitude; ?>;
    var rLng = <?php echo (float)$reciever_longitude; ?>;

    var map = L.map('map', { zoomControl: false }).setView([sLat, sLng], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    // SVG Markers
    var farmIcon = L.divIcon({
        html: `<svg width="30" height="30" viewBox="0 0 30 30">
                <circle cx="15" cy="15" r="13" fill="white" stroke="#2dce89" stroke-width="2"/>
                <path d="M15 8L10 13V20H20V13L15 8Z" fill="#2dce89"/>
              </svg>`,
        className: '',
        iconSize: [30, 30],
        iconAnchor: [15, 15]
    });

    var userIcon = L.divIcon({
        html: `<svg width="30" height="30" viewBox="0 0 30 30">
                <circle cx="15" cy="15" r="13" fill="white" stroke="#1171ef" stroke-width="2"/>
                <path d="M15 8C12 8 10 10 10 13C10 17 15 21 15 21C15 21 20 17 20 13C20 10 18 8 15 8Z" fill="#1171ef"/>
              </svg>`,
        className: '',
        iconSize: [30, 30],
        iconAnchor: [15, 15]
    });

    var startMarker = L.marker([sLat, sLng], {icon: farmIcon}).addTo(map).bindPopup('Farmer');
    var endMarker = L.marker([rLat, rLng], {icon: userIcon}).addTo(map).bindPopup('Buyer');

    // ✅ ROAD ROUTE (instead of straight line)
    var routingControl = L.Routing.control({
        waypoints: [
            L.latLng(sLat, sLng),
            L.latLng(rLat, rLng)
        ],
        addWaypoints: false,
        draggableWaypoints: false,
        routeWhileDragging: false,
        createMarker: function() { return null; }, // we already made custom markers
        lineOptions: {
            styles: [
                { color: '#1171ef', weight: 5, opacity: 0.8 }
            ]
        }
    }).addTo(map);

    // Hide routing panel UI
    setTimeout(() => {
        const container = document.querySelector('.leaflet-routing-container');
        if (container) container.style.display = 'none';
    }, 100);

    // Fit map to route bounds
    routingControl.on('routesfound', function(e) {
        var route = e.routes[0];
        var bounds = L.latLngBounds(route.coordinates);
        map.fitBounds(bounds, { padding: [50, 50] });
    });
});

function confirmSubmit(action) {
    document.getElementById('actionInput').value = action;

    Swal.fire({
        title: 'Update Order?',
        text: "Status: " + action.toUpperCase(),
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#2dce89'
    }).then((res) => {
        if(res.isConfirmed) document.getElementById('actionForm').submit();
    });
}
</script>

<?php include_once "../layout/layout_foot.php"; ?>