<?php
include_once "../config/core.php";
include_once "../config/database.php";
include_once "../objects/transaction.php";
include_once "../objects/queue_reservation.php";
include_once "../objects/department.php";
include_once "../objects/queue_number.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$database = new Database();
$db = $database->getConnection();

$transaction       = new Transaction($db);
$queue_reservation = new QueueReservation($db);
$departments       = new Department($db);
$queue_number      = new QueueNumber($db);

$did = isset($_GET['did']) ? $_GET['did'] : die("ERROR: 404 Not Found");

$department = null;
if     ($did == 1) { $department = "Cashier";   }
else if($did == 2) { $department = "Admission"; }
else if($did == 3) { $department = "MIS";       }
else if($did == 4) { $department = "Registrar"; }
else               { $department = "Department Not Available"; }

$page_title = $department;
include_once "layout_head.php";

if ($_POST) {
    switch ($did) {
        case 1:  $prefix = "C"; break;
        case 2:  $prefix = "A"; break;
        case 3:  $prefix = "M"; break;
        case 4:  $prefix = "R"; break;
        default: $prefix = "X"; break;
    }

    $queue_reservation_id = $prefix . rand(1000, 9999);

    $posted_tx_id   = $_POST['transaction_id']   ?? '';
    $posted_tx_name = $_POST['transaction_name'] ?? '';

    if ($posted_tx_name === '' && $posted_tx_id !== '') {
        try {
            $stmt = $db->prepare("SELECT name FROM transactions WHERE id = :id LIMIT 1");
            $stmt->execute([":id" => $posted_tx_id]);
            $posted_tx_name = (string)$stmt->fetchColumn();
        } catch (Throwable $e) {
            $posted_tx_name = '';
        }
    }

    $queue_reservation->full_name            = $_POST['full_name'] ?? '';
    $queue_reservation->department_id        = $did;
    $queue_reservation->queue_reservation_id = $queue_reservation_id;
    $queue_reservation->user_type            = $_POST['user_type'] ?? '';
    $queue_reservation->source               = "By Kiosk";
    $queue_reservation->customer_number      = $_POST['customer_number'] ?? '';

    $queue_number->queue_reservation_id = $queue_reservation_id;

    if ($queue_reservation->create()) {
        $queue_number->UpdateQueueNumber($did);
        $departments->deductSlot($did);

        $_SESSION['name'] = $_POST['full_name'];
        $_SESSION['ticket_number']  = $prefix . $queue_number->last_queue_number;
        $_SESSION['department']     = $department;
        $_SESSION['transaction']    = $posted_tx_name;
        $_SESSION['priority']       = $_POST['priority'] ?? '';
        $_SESSION['customer_number'] = $_POST['customer_number'] ?? '';

        if (isset($_POST['trigger_python']) && $_POST['trigger_python'] === '1') {
            $phone_number = $_POST['phone'] ?? ($_SESSION['customer_number'] ?? '');
            $priority = $_POST['priority'] ?? '';
            $name = $_POST['name'] ?? ($_SESSION['name'] ?? 'Unknown');
            $ticket_number = $_SESSION['ticket_number'] ?? '';
            $department = $_SESSION['department'] ?? '';

            $message = "Hi {$name}, your queue ticket {$ticket_number} for {$department} has been confirmed. Customer Number: {$phone_number}. Thank you for using the kiosk!";

            $phone_safe = escapeshellarg($phone_number);
            $message_safe = escapeshellarg($message);
            $priority_safe = escapeshellarg($priority);

            $python_path = "python";
            $send_message_python = "$python_path /var/www/html/kioskrepo/student/test.py $phone_safe $message_safe $priority_safe 2>&1";
            $output = shell_exec($send_message_python);
            echo $output;
        }
        ?>

        <!-- ✅ Modal Section -->
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

        <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-50">
            <div class="modal-content">
              <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Your Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body text-dark">
                <p class="fs-5">Are these details correct?</p>
                <p><strong>Name:</strong> <?php echo $_SESSION['name']; ?></p>
                <p><strong>Ticket Number:</strong> <?php echo $_SESSION['ticket_number']; ?></p>
                <p><strong>Department:</strong> <?php echo $_SESSION['department']; ?></p>
                <p><strong>Customer Number:</strong> <?php echo $_SESSION['customer_number']; ?></p>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-lg btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="button" class="btn btn-lg btn-success" id="proceedToPrintBtn">Yes</button>
              </div>
            </div>
          </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
          console.log("Forcing modal to show...");
          var myModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
          myModal.show();

          $('#proceedToPrintBtn').on('click', function() {
              $(this).prop('disabled', true);
              $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...');
              $.ajax({
                  url: '', // same page
                  method: 'POST',
                  data: { 
                      trigger_python: '1',
                      phone: '<?php echo $_POST['customer_number']; ?>',
                      priority: '<?php echo $_SESSION['priority']; ?>',
                      name: '<?php echo $_SESSION['name']; ?>'
                  },
                  success: function(response) {
                      console.log(response);
                      window.location.href = "/var/www/html/kioskrepo/student/ticket.php";
                  },
                  error: function(err) {
                      console.error(err);
                      window.location.href = "/var/www/html/kioskrepo/student/ticket.php";
                  }
              });
          });
        });
        </script>
        <?php
    } else {
        echo "failed";
    }
}
?>

<!-- ✅ CSS Section -->
<style>
  #department-form .card { border-radius: 20px; }
  #department-form .disclaimer { font-size: 1rem; line-height: 1.5; }

  #department-form input,
  #department-form select {
    font-size: 1.25rem;
    padding: 1rem;
    height: auto;
  }

  #department-form button {
    font-size: 1.5rem;
    padding: 1rem;
  }

  #department-form .form-check {
    gap: .5rem;
    align-items: center;
  }

  #department-form .form-check-label {
    margin-left: .5rem;
    font-size: 1.25rem;
  }

  @media (min-width: 992px) {
    #department-form .main-col {
        width: 90%;
        max-width: 1400px;
        margin: 0 auto;
        margin-top:5%;
    }
  }

  .btn-navy {
    background-color: #001f3f;
    color: #fff;
    transition: background-color 0.3s ease;
  }
  .btn-navy:hover {
    background-color: #003366;
    color: #fff;
  }

  .modal-50 {
    max-width: 50%;
  }

  @media (max-width: 768px) {
    .modal-50 {
      max-width: 90%;
    }
  }
</style>

<!-- ✅ Department Form -->
<div id="department-form" class="container-fluid mt-5">
  <div class="row justify-content-center">
    <div class="col-12 main-col">
      <div class="card shadow p-4">

        <p class="disclaimer text-center text-muted mb-4">
          <strong>Disclaimer:</strong> By using this kiosk, you agree to provide accurate information. Your queue numbers are for personal use only. Missed or skipped turns may require rebooking. All personal data is handled in compliance with the Data Privacy Act of 2012.
        </p>

        <form aria-label="Queue registration form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . "?did={$did}"); ?>" method="POST">
          <div class="row g-4">

            <div class="col-md-6">
              <div class="mb-3">
                <input type="text" readonly class="form-control bg-light" value="<?php echo $page_title; ?>">
              </div>
              <div class="mb-3">
                <input type="text" name="full_name" placeholder="Full Name" class="form-control" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <select name="priority" id="" class="form-select">
                  <option value="" disabled selected hidden>Select Priority Type</option>
                  <option value="Pregnant">Pregnant</option>
                  <option value="pwd">PWD</option>
                  <option value="senior">Senior Citizen</option>
                </select>
                <input type="hidden" name="transaction_name" id="transaction_name">
              </div>

              <div class="mb-3">
                <input name="customer_number" id="customer_number" class="form-control" placeholder="Enter your contact number" required>
              </div>
            </div>

            <div class="col-12 text-center">
              <button type="submit" class="btn btn-navy w-50">Print</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
(function () {
  const sel = document.getElementById('transaction_id');
  const hid = document.getElementById('transaction_name');
  function syncName() {
    const opt = sel?.options[sel.selectedIndex];
    hid.value = opt ? (opt.getAttribute('data-name') || opt.textContent.trim()) : '';
  }
  if (sel) {
    sel.addEventListener('change', syncName);
    syncName();
  }
})();
</script>

<?php include_once "layout_foot.php"; ?>
