<?php 
include '../../config/core.php';


$require_login=true;
include_once "../../login_checker.php";

$page_title = "Manage Product";
include_once "layout_head.php";
?>

<div class="mp-container">
	<div class="mp-header">
		<table class="mp-header-table">
			<tr class="mp-header-tr">
				<td>
					<h3>Laon Mogpog</h3>
					<span>May 13, 2023</span>
					<h2 id="temperature"></h2>
					<span>Partly Cloudy</span>
				</td>
				<td>
					<span>Total Expense</span>
					<span><h3>150.00 PHP</h3></span>
				</td>
			</tr>
		</table>
	</div>



	<div class="mp-content">
		<table>
			<tr>
				<th>Type</th>
				<th>Item name</th>
				<th>Quantity</th>
				<th>Unit Cost</th>
				<th>Date</th>
				<th>Action</th>
			</tr>
			<tr>
				<td>Seed</td>
				<td>Corn Seed</td>
				<td>10</td>
				<td>1500 PHP</td>
				<td>02/20/2023</td>
				<td><button>Edit</button></td>
			</tr>
		</table>
	</div>
</div>


<?php include_once "layout_foot.php"; ?>