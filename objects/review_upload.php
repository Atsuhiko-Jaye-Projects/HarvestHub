<?php

class ReviewUpload{

    private $conn;
    private $table_name = "review_images";

    public $id;
    public $image;
    public $customer_id;
    public $product_id;
    public $farmer_id;
    public $created_at;

    public function __construct($db){
        $this->conn = $db;
    }

    function saveReviewImages(){

        $query = "INSERT INTO
                    " . $this->table_name ."
                    SET
                    image= :image,
                    customer_id = :customer_id,
                    product_id = :product_id,
                    farmer_id = :farmer_id,
                    created_at = :created_at";

        $stmt = $this->conn->prepare($query);
        $this->created_at = date("Y-m-d H:i:s");

        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":farmer_id", $this->farmer_id);
        $stmt->bindParam(":created_at", $this->created_at);

        if ($stmt->execute()) {
            return true;
        }
        return false;

    }

public function uploadPhoto($file, $farmerid) {
    // 1️⃣ Check if file exists and uploaded correctly
    if (!isset($file['name']) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'No file uploaded or upload error: ' . $file['error']];
    }

    // 2️⃣ Ensure upload directory exists
    $target_directory = "../../uploads/reviews/{$farmerid}/review_images/";
    if (!is_dir($target_directory)) {
        if (!mkdir($target_directory, 0777, true)) {
            return ['success' => false, 'error' => 'Failed to create upload directory'];
        }
    }

    // 3️⃣ Validate file type
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed_file_types = ['jpg','jpeg','png','gif'];
    if (!in_array($ext, $allowed_file_types)) {
        return ['success' => false, 'error' => 'Invalid file type: ' . $ext];
    }

    // 4️⃣ Validate file size
    if ($file['size'] > 1024 * 1024) { // 1MB
        return ['success' => false, 'error' => 'File too large: ' . $file['name']];
    }

    // 5️⃣ Check if real image
    if (!getimagesize($file['tmp_name'])) {
        return ['success' => false, 'error' => 'File is not a valid image: ' . $file['name']];
    }

    // 6️⃣ Generate unique filename
    $unique_name = sha1_file($file['tmp_name']) . "-" . basename($file['name']);
    $target_file = $target_directory . $unique_name;

    // 7️⃣ Move uploaded file
    if (!move_uploaded_file($file['tmp_name'], $target_file)) {
        return ['success' => false, 'error' => 'Failed to move uploaded file: ' . $file['name']];
    }

    // ✅ Success
    return ['success' => true, 'filename' => $unique_name];
}





}

?>