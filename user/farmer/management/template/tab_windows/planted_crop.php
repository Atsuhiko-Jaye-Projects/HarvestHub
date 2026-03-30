<div class="table-responsive shadow-sm rounded-2">
    <table class="table table-hover table-bordered align-middle mb-0 text-center" style="table-layout: fixed; width: 100%;">
        <thead class="table-success text-uppercase">
            <tr>
                <th style="width: 10%;"><i class="bi bi-flower1 me-1"></i> Crop Name</th>
                <th style="width: 10%;"><i class="bi bi-box-seam me-1"></i> Harvest Stocks (EST.)</th>
                <th style="width: 10%;"><i class="bi bi-clipboard-data me-1"></i> Planted Crops</th>
                <th style="width: 10%;"><i class="bi bi-calendar-plus me-1"></i> Date Planted</th>
                <th style="width: 10%;"><i class="bi bi-calendar-check me-1"></i> Harvest Est.</th>
                <th style="width: 10%;" class="text-center"><i class="bi bi-gear me-1"></i> Action</th>
            </tr>
        </thead>
        <tbody id="crop_table" class="table-group-divider text-center">
            <?php
            if ($crop_num > 0) {
                while ($row = $crop_stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $datePlanted = new DateTime($row['date_planted']);
                    $harvestEst  = new DateTime($row['estimated_harvest_date']);
                    $today       = new DateTime(); // current date

                    // Duration: from planted to estimated harvest
                    $duration = $datePlanted->diff($harvestEst);
                    $durationDays = $duration->days;

                    // Crop Age: from planted to today
                    $age = $datePlanted->diff($today);
                    $ageDays = $age->days;

                    echo "<tr>";
                        echo "<td class='text-nowrap text-truncate'>" . ucwords($row['crop_name']) . "</td>";
                        echo "<td class='text-truncate'>" . number_format($row['stocks']) . " KG</td>";
                        echo "<td class='text-truncate'>{$row['plant_count']} Crops</td>";
                        echo "<td class='text-truncate'>{$row['date_planted']}</td>";
                        echo "<td class='text-truncate'>{$row['estimated_harvest_date']}</td>";
                        echo "<td class='text-nowrap'>";
                            echo "<button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#update-crop-modal-{$row['id']}'>";
                                echo "<i class='bi bi-pencil-square'></i>";
                            echo "</button>";
                            if ($row['crop_status'] != "harvested" && $row['status'] != 'posted') {
                                echo "<button class='btn btn-success ms-1' data-bs-toggle='modal' data-bs-target='#post-crop-modal-{$row['id']}'>
                                <i class='bi bi-cloud-upload-fill'></i>
                              </button>";
                            } else if ($row['crop_status'] == "crop planted" && $row['status'] != 'posted'){
                                echo "<button class='btn btn-success ms-1' data-bs-toggle='modal' data-bs-target='#post-crop-modal-{$row['id']}'>
                                <i class='bi bi-cloud-upload-fill'></i>
                              </button>";
                            }
                            echo "
                              <button
                                  class='btn btn-danger ms-1 btn-delete'
                                  data-id='{$row['id']}'
                                  data-farm-resource-id='{$row['farm_resource_id']}'
                                  data-carea='{$row['cultivated_area']}'
                                  data-uid='{$row['user_id']}'
                              >
                                  <i class='bi bi-trash'></i>
                              </button>
                              ";
                        echo "</td>";
                    echo "</tr>";
                    include "../modal-forms/crop/edit_crop.php";
                    include "../modal-forms/crop/post_crop.php";
                }

            } else {
                echo "<tr>
                    <td colspan='6' class='text-center'>No Crop found</td>
                  </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<?php include_once "../../../paging.php"; ?>