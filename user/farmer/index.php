<?php
include_once "../../config/core.php";


$require_login=true;
include_once "../../login_checker.php";

$page_title = "Dashboard";
include_once "layout_head.php";


?>

<button id= "ap-btn">New Product</button>

<?php include_once 'add-product.php';?>

<div class="product-details">
    <table>
        <tr>
            <th>Item No.</th>
            <th>Type</th>
            <th>Category</th>
            <th>Price</th>
            <th>Unit</th>
            <th>Lot size</th>
            <th>Date</th>
            <th>Action</th>

        </tr>
        <tr>
            <td>1</td>
            <td>Kamote</td>
            <td>Vegetable</td>
            <td>$100.00</td>
            <td>KG</td>
            <td>10kg/lot</td>
            <td>5/14/2024</td>
            <td><button>Edit</button></td>
        </tr>
    </table>
</div>

<?php include_once "layout_foot.php"; ?>


