<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Tracker</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Custom styles for the progress bar tracker */
        .step {
            position: relative;
            text-align: center;
        }
        
        .step .step-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #ddd;
            color: white;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            z-index: 2;
        }

        /* Active and completed step colors */
        .completed .step-icon {
            background-color: #007bff;
        }

        .active .step-icon {
            background-color: #28a745;
        }

        /* Custom styling for text */
        .step-text {
            margin-top: 10px;
            font-weight: bold;
        }

        .step-time {
            font-size: 12px;
            color: #777;
        }

        /* Stack vertically on small screens */
        @media (max-width: 768px) {
            .steps-container {
                flex-direction: column;
                align-items: center;
            }

            .step-line {
                position: absolute;
                top: 50%;
                width: 100%;
                transform: translateY(-50%);
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5 align-center">
        <!-- Step container -->
        <div class="d-flex justify-content-between steps-container">
            <!-- Order Placed -->
            <?php
            if ($num>0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $placenumber = "";
                    $icon_icon = "";
                    switch ($row['status']) {
                        case 'order placed':
                            $placenumber = "1";
                            $icon_icon = "<i class='bi bi-cart'></i>";
                            break;
                        
                        case 'preparing':
                            $placenumber = "2";
                            $icon_icon = "<i class='bi bi-gear'></i>";
                            break;
                        
                        case 'in transit':
                            $placenumber = "3";
                            $icon_icon = "<i class='bi bi-truck'></i>";
                            break;
                        case 'delivered':
                            $placenumber = "4";
                            $icon_icon = "<i class='bi bi-check-circle'></i>";
                            break;
                        case 'completed':
                            $placenumber = "5";
                            $icon_icon = "<i class='bi bi-check-lg'></i>";
                            break;
                        
                        default:
                            # code...
                            break;
                    }

                    echo "
                    <div class='step completed'>
                        <div class='step-icon'>{$icon_icon}</div>
                        <div class='step-text'>{$placenumber}</div>
                        <div class='step-text'>" . ucwords($row['status']) . "</div>
                        <div class='step-time'>{$row['timestamp']}</div>
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
