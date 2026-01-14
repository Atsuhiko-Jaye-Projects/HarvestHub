<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Tracker</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
.step {
    position: relative;
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 10px 0;
}

.step-icon {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: #fff;
    flex-shrink: 0;
}

/* Colors */
.step-primary { background: #0d6efd; }
.step-warning { background: #ffc107; }
.step-info    { background: #0dcaf0; }
.step-success { background: #198754; }
.step-danger  { background: #dc3545; }
.step-secondary { background: #6c757d; }

.step-details {
    display: flex;
    flex-direction: column;
}

.step-text {
    font-weight: 600;
    font-size: 1rem;
}

.step-time {
    font-size: 0.8rem;
    color: #6c757d;
}

/* Line */
.step-line {
    position: absolute;
    height: 2px;
    background: #d1d1d1;
    left: 60px;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
}

.step:last-child .step-line {
    display: none;
}
@media (max-width: 480px) {
    .step {
        flex-direction: column;
        align-items: flex-start;
    }

    .step-line {
        display: none; /* hide line on very small screens */
    }

    .step-icon {
        margin-bottom: 5px;
    }
}
    </style>
</head>
<body>
    <div class="container mt-5 align-center">
        <!-- Step container -->
        <div class="d-flex  steps-container">
            <!-- Order Placed -->
            <?php
                    if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                // Default values
                $icon_icon = "";
                $status_color = "";

                switch ($row['status']) {

                    case 'order placed':
                        $icon_icon = "<i class='bi bi-cart'></i>";
                        $status_color = "step-primary";
                        break;

                    case 'preparing':
                        $icon_icon = "<i class='bi bi-gear-wide-connected'></i>";
                        $status_color = "step-warning";
                        break;

                    case 'in transit':
                        $icon_icon = "<i class='bi bi-truck'></i>";
                        $status_color = "step-info";
                        break;

                    case 'delivered':
                        $icon_icon = "<i class='bi bi-box-seam'></i>";
                        $status_color = "step-success";
                        break;

                    case 'completed':
                        $icon_icon = "<i class='bi bi-check2-circle'></i>";
                        $status_color = "step-success";
                        break;

                    case 'order confirmed':
                        $icon_icon = "<i class='bi bi-check2-circle'></i>";
                        $status_color = "step-success";
                        break;

                    case 'pending cancel':
                        $icon_icon = "<i class='bi bi-x-circle'></i>";
                        $status_color = "step-danger";
                        break;
                        
                    case 'order cancelled':
                        $icon_icon = "<i class='bi bi-x-circle'></i>";
                        $status_color = "step-danger";
                        break;

                    default:
                        $icon_icon = "<i class='bi bi-info-circle'></i>";
                        $status_color = "step-secondary";
                        break;
                }

                echo "
                <div class='step'>
                    <div class='step-icon $status_color'>{$icon_icon}</div>
                    <div class='step-details'>
                        <div class='step-text'>" . ucwords($row['status']) . "</div>
                        <div class='step-time'>{$row['timestamp']}</div>
                    </div>
                    <div class='step-line'></div>
                </div>";
            }
        }


            // Associative array of statuses with their corresponding step numbers

            ?>



        </div>
    </div>

    <!-- Bootstrap 5 JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
