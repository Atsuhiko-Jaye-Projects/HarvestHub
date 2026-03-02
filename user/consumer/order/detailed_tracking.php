<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shipping Tracker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f6f8;
        }

        .tracking-card {
            max-width: 750px;
            margin: auto;
        }

        .timeline {
            position: relative;
            padding-left: 70px;
        }

        .timeline::before {
            content: "";
            position: absolute;
            left: 32px;
            top: 0;
            bottom: 0;
            width: 3px;
            background: #dee2e6;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 35px;
        }

        .timeline-icon {
            position: absolute;
            left: -70px;
            top: 0;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #fff;
        }

        /* Status Colors */
        .step-primary   { background: #0d6efd; }
        .step-success   { background: #198754; }
        .step-danger    { background: #dc3545; }
        .step-warning   { background: #ffc107; color: #000; }
        .step-info      { background: #0dcaf0; }
        .step-secondary { background: #6c757d; }

        .timeline-content {
            background: #ffffff;
            padding: 15px 18px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .timeline-content h6 {
            margin: 0;
            font-weight: 600;
        }

        .timeline-content p {
            margin: 5px 0 0;
            font-size: 0.9rem;
            color: #6c757d;
        }

        @media (max-width: 576px) {
            .timeline {
                padding-left: 60px;
            }
            .timeline-icon {
                width: 40px;
                height: 40px;
                font-size: 18px;
            }
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="card tracking-card shadow-sm">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="mb-0">Shipment Tracking</h5>
                    <small class="text-muted">Track your order status below</small>
                </div>
                <span class="badge bg-primary">Order #<?= htmlspecialchars($order_id ?? 'N/A'); ?></span>
            </div>

            <div class="timeline">

<?php
if ($num > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $icon_icon = "";
        $status_color = "";
        $description = "";

        switch (strtolower($row['status'])) {

            case 'order placed':
                $icon_icon = "<i class='bi bi-cart'></i>";
                $status_color = "step-primary";
                $description = "Your order has been successfully placed in our system.";
                break;

            case 'accept':
                $icon_icon = "<i class='bi bi-gear-wide-connected'></i>";
                $status_color = "step-info";
                $description = "Your order is being processed and prepared for shipment.";
                break;

            case 'order shipout':
                $icon_icon = "<i class='bi bi-truck'></i>";
                $status_color = "step-warning";
                $description = "Your package has left our facility and is on the way.";
                break;

            case 'order recieved':
                $icon_icon = "<i class='bi bi-box-seam'></i>";
                $status_color = "step-primary";
                $description = "The package has arrived at the local distribution hub.";
                break;

            case 'completed':
            case 'order confirmed':
                $icon_icon = "<i class='bi bi-check2-circle'></i>";
                $status_color = "step-success";
                $description = "Delivery completed successfully. Thank you for shopping with us!";
                break;

            case 'pending cancel':
                $icon_icon = "<i class='bi bi-exclamation-circle'></i>";
                $status_color = "step-warning";
                $description = "Your cancellation request is currently under review.";
                break;

            case 'order cancelled':
                $icon_icon = "<i class='bi bi-x-circle'></i>";
                $status_color = "step-danger";
                $description = "This order has been cancelled. Please contact support if needed.";
                break;

            default:
                $icon_icon = "<i class='bi bi-info-circle'></i>";
                $status_color = "step-secondary";
                $description = "Status updated.";
                break;
        }

        echo "
        <div class='timeline-item'>
            <div class='timeline-icon {$status_color}'>
                {$icon_icon}
            </div>
            <div class='timeline-content'>
                <h6>" . ucwords($row['status']) . "</h6>
                <p>{$description}</p>
                <small class='text-muted'>{$row['timestamp']}</small>
            </div>
        </div>";
    }
} else {
    echo "<p class='text-muted'>No tracking updates available.</p>";
}
?>

            </div>

        </div>
    </div>
</div>

</body>
</html>