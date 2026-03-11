<?php
$base_url = "/HarvestHub/";
$root_path = $_SERVER['DOCUMENT_ROOT'] . "/HarvestHub/";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($page_title) ? $page_title : "HarvestHub"; ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <style>
        :root {
            --cyber-bg: #05080a;
            --neon-emerald: #10b981;
            --glass-border: rgba(255, 255, 255, 0.08);
            --sidebar-width: 280px; /* Eksaktong sukat ng sidebar */
        }

        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            background: #f8f9fa;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* SIDEBAR WRAPPER - Naka-fixed para hindi mausog */
        .sidebar-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            z-index: 1050;
            background-color: var(--cyber-bg);
            transition: transform 0.3s ease;
        }

        /* CONTENT WRAPPER - Ito ang magpapatabi sa kanila */
        .content-wrapper {
            margin-left: var(--sidebar-width); /* Eto ang fix! */
            min-height: 100vh;
            width: calc(100% - var(--sidebar-width));
            background: #f8f9fa;
            transition: all 0.3s ease;
            position: relative;
        }

        /* Mobile View Fix */
        @media (max-width: 1199px) {
            .sidebar-wrapper {
                transform: translateX(-100%);
            }
            .sidebar-wrapper.show {
                transform: translateX(0);
            }
            .content-wrapper {
                margin-left: 0;
                width: 100%;
            }
        }

        /* Card styles para sa Review Items */
        .order-card, .main-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            background: #fff;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="d-flex">
        <aside class="sidebar-wrapper">
            <?php include $root_path . "user/consumer/layout/sidebar.php"; ?>
        </aside>

        <main class="content-wrapper">
            <?php include $root_path . "user/consumer/layout/navigation.php"; ?>

            <div class="container-fluid p-4">