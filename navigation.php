<!-- navbar -->
<div class="navbar navbar-default navbar-static-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<!-- to enable navigation dropdown when viewed in mobile device -->
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<!-- Change "Your Site" to your site name -->
			<a class="navbar-brand" href="<?php echo $home_url; ?>">Harvest Hub</a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<!-- link to the "Cart" page, highlight if current page is cart.php -->
				<li <?php echo $page_title=="Index" ? "class='active'" : ""; ?>>
					<a href="<?php echo $home_url; ?>">Home</a>
				</li>
			</ul>
			<?php
			// login and logout options will be here
			?>
		</div><!--/.nav-collapse -->
	</div>
</div>
<!-- /navbar -->