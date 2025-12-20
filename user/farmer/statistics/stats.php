<?php
if ($page_title == "Manage Crop") {
?>
<div class="container-fluid mt-3">
    <div class="d-flex flex-wrap gap-3">
        <!-- Card 1 -->
        <div class="card text-white bg-success flex-fill col-4 col-sm-6 col-lg-4 mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 id="location"></h6>
                        <h2 id="temperature"></h2>
                        <small id="desc"></small>
                    </div>
                    <div>
                        <i class="bi bi-clipboard" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="card flex-fill col-4 col-sm-6 col-lg-4 mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6>Planted Crops</h6>
                        <h2 id="recordCount"><?php  echo str_pad($farm_stats['crop_plant_count'] ?? 0, 2, '0', STR_PAD_LEFT); ?></h2>
                        <small>Crops</small>
                    </div>
                    <div>
                        <i class="bi bi-clipboard" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
                <small class="text-success">+3.16% From last month</small>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="card flex-fill col-6 col-sm-12 col-lg-4 mb-3">
             <div class="card shadow-sm" style="background-color: #28a745;">
                <div class="card-header fw-bold" style="background-color: #28a745; color: white; font-size: 1.1rem;">Top Crops in This Farm</div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Rank</th>
                                <th>Product Name</th>
                                <th>Total Planted</th>
                            </tr>
                        </thead>
                        <tbody id="mostPlantedTable">
                            <tr><td colspan="3" class="text-center">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card flex-fill col-6 col-sm-12 col-lg-4 mb-3">
            <div class="card shadow-sm" style="background-color: #007bff;">
                <div class="card-header fw-bold" style="background-color: #007bff; font-size: 1.1rem;">Planted Crops in your Brgy.</div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Rank</th>
                                <th>Product Name</th>
                                <th>Total Planted</th>
                            </tr>
                        </thead>
                        <tbody id="TopCropsInArea">
                            <tr><td colspan="3" class="text-center">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php if ($page_title == "Feedback") { ?>
<div class="container-fluid mt-3">
    <div class="d-flex flex-wrap gap-3">
        <!-- Card 1 -->
        <div class="card text-white bg-success flex-fill col-12 col-sm-6 col-lg-3 mb-3" >
            <div class="card-body" >
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6>Rating</h6>
                        <h2></h2>
                        <small></small>
                    </div>
                    <div>
                        <i class="bi bi-clipboard" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="card flex-fill col-12 col-sm-6 col-lg-3 mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6>Pending Orders</h6>
                        <h2>15</h2>
                        <small>Orders</small>
                    </div>
                    <div>
                        <i class="bi bi-clipboard" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
                <small class="text-success">+3.16% From last month</small>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="card flex-fill col-12 col-sm-6 col-lg-3 mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6>Completed Orders</h6>
                        <h2>10</h2>
                        <small></small>
                    </div>
                    <div>
                        <i class="bi bi-clipboard" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
                <small class="text-success">+2.24% From last month</small>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php if ($page_title == "Reviews") { ?>
<div class="container-fluid mt-3">
    <div class="d-flex flex-wrap gap-3">
        <!-- Card 1 -->
        <div class="card flex-fill col-12 col-sm-6 col-lg-3 mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6>Rating Received</h6>
                        <h2></h2>
                        <small></small>
                    </div>
                    <div>
                        <i class="bi bi-clipboard" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="card flex-fill col-12 col-sm-6 col-lg-3 mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6>Review Rate of Orders</h6>
                        <h2>15</h2>
                        <small>Orders</small>
                    </div>
                    <div>
                        <i class="bi bi-clipboard" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
                <small class="text-success">+3.16% From last month</small>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="card flex-fill col-12 col-sm-6 col-lg-3 mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6>Good Rating</h6>
                        <h2>10</h2>
                        <small></small>
                    </div>
                    <div>
                        <i class="bi bi-clipboard" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
                <small class="text-success">+2.24% From last month</small>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="card flex-fill col-12 col-sm-6 col-lg-3 mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6>Unreplied Bad Ratings</h6>
                        <h2>10</h2>
                        <small></small>
                    </div>
                    <div>
                        <i class="bi bi-clipboard" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
                <small class="text-success">+2.24% From last month</small>
            </div>
        </div>
    </div>
</div>
<?php } ?>
