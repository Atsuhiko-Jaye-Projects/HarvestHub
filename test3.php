<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Tracker</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Container for the progress bar */
        .progress-bar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 50px;
            position: relative;
        }

        /* Circle icon for each step */
        .step-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
            margin: 0 auto;
            z-index: 2;
        }

        /* Connecting lines between steps */
        .step-line {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100%;
            height: 2px;
            background-color: #ddd;
            z-index: 1;
            transform: translateY(-50%);
        }

        /* Style for active and completed steps */
        .active .step-icon {
            background-color: #28a745;
        }
        .completed .step-icon {
            background-color: #007bff;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .progress-bar-container {
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

        /* Styling for the step text */
        .step-text {
            margin-top: 10px;
            font-weight: bold;
        }
        .step-time {
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3 class="text-center">Shipping Status Tracker</h3>
        
        <div class="progress-bar-container">
            <div class="step completed">
                <div class="step-icon">1</div>
                <div class="step-text">Order Placed</div>
                <div class="step-time">15/06/2022 11:46</div>
                <div class="step-line"></div>
            </div>

            <div class="step completed">
                <div class="step-icon">2</div>
                <div class="step-text">Order Paid</div>
                <div class="step-time">15/06/2022 11:46</div>
                <div class="step-line"></div>
            </div>

            <div class="step completed">
                <div class="step-icon">3</div>
                <div class="step-text">Order Shipped Out</div>
                <div class="step-time">15/06/2022 16:30</div>
                <div class="step-line"></div>
            </div>

            <div class="step active">
                <div class="step-icon">4</div>
                <div class="step-text">Order Received</div>
                <div class="step-time">30/06/2022 12:01</div>
                <div class="step-line"></div>
            </div>

            <div class="step">
                <div class="step-icon">5</div>
                <div class="step-text">Order Completed</div>
                <div class="step-time">30/07/2022 23:59</div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
