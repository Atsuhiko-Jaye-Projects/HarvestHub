<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" type="text/css" href="../../libs/css/farmer_style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

</head>
<body>
    <?php include_once "sidebar.php"; ?>
    <div class="container">
        <div class="header-container">
            <?php include_once "farmer-alert.php";?>
            <h1><?php echo $page_title; ?></h1>
        </div>
        <hr>
    <?php 
        if ($page_title=="Dashboard") {
    ?>
            <div class="stats-container">
                <div class="stats-content">
                    <table>
                        <tr>
                            <td><span class="stats-labels">Total Products</span></td>
                            <td><span class="stats-labels">Total Products</span></td>
                            <td><span class="stats-labels">Total Products</span></td>
                        </tr>
                        <tr>
                            <td class='stats-value'>
                                <span class="stats-counts">
                                    <img src="../../libs/images/farmer/shopping-bag-hallow.png" alt="">
                                    <h1>13</h1></span>
                                </span>
                            </td>
                            <td class='stats-value'>
                                <span class="stats-counts">
                                    <img src="../../libs/images/farmer/shopping-bag-hallow.png" alt="">
                                    <h1>13</h1></span>
                                </span>
                            </td>
                            <td class='stats-value'>
                                <span class="stats-counts">
                                    <img src="../../libs/images/farmer/shopping-bag-hallow.png" alt="">
                                    <h1>13</h1></span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="stats-title">Vegetable</span></td>
                            <td><span class="stats-title">Fruits</span></td>
                            <td><span class="stats-title">Fresh Proteins</span></td>     
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
    <?php
    }
    ?>
        
