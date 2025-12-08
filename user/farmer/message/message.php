<?php 
include_once '../../../config/core.php';
include_once '../../../config/database.php';
include_once '../../../objects/order.php'; 

$page_title = "Messages";
include_once "../layout/layout_head.php";

$require_login = true;
include_once "../../../login_checker.php";

$database = new Database();
$db = $database->getConnection();
?>

<div class="container-fluid mt-3">
  <div class="row">

    <!-- Conversations List -->
    <div class="col-md-4">
      <div class="card h-100 p-2 shadow-sm">
        <h6 class="mb-3">Inbox</h6>
        <ul class="list-group list-group-flush" id="conversationList">
          <!-- Sample conversation -->
          <li class="list-group-item d-flex align-items-center cursor-pointer">
            <div class="avatar bg-purple text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width:40px; height:40px;">
              J
            </div>
            <div>
              <strong>Sadiwa, Jessi</strong><br>
              <small class="text-muted">Hello!</small>
            </div>
          </li>
          <li class="list-group-item text-center text-muted">No more conversations</li>
        </ul>
      </div>
    </div>

    <!-- Chat Content -->
    <div class="col-md-8">
      <div class="card h-100 shadow-sm p-3" id="chatContent">
        <p class="text-center text-muted mt-5">Select a conversation to start chatting</p>
      </div>
    </div>

  </div>
</div>

<?php include_once "../layout/layout_foot.php"; ?>
