<?php 
include '../../config/core.php';


$require_login=true;
include_once "../../login_checker.php";

$page_title = "Order Info";
include_once "layout_head.php";
?>

<div class="oi-container">
	<div class="oi-header">
		<table class="oi-header-table">
			<tr class="oi-header-tr">
				<td><button>All</button></td>
				<td><button>In Progress</button></td>
				<td><button>Delivered</button></td>
				<td><button>Canceled</button></td>
				<td><button>Completed</button></td>
			</tr>
		</table>
	</div>

	<div class="oi-content">
		<table>
			<tr>
				<th>Order ID</th>
				<th>Customer ID</th>
				<th>Name</th>
				<th>Address</th>
				<th>Total</th>
				<th>Lot Size</th>
				<th>Date</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
			<tr>
				<td>1</td>
				<td>4116</td>
				<td>Juan Delacruz</td>
				<td>Laon, Mogpog</td>
				<td>$100</td>
				<td>10KG</td>
				<td>5/15/2025</td>
				<td>Pending</td>
				<td><button>Edit</button></td>
			</tr>
		</table>
	</div>
</div>


<?php include_once "layout_foot.php"; ?>