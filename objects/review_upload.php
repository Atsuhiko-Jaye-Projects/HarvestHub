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

    function uploadPhoto($images, $farmerid, $product_id, $customer_id){
        $uploadedFiles = [];

        $target_directory = "../../uploads/reviews/{$farmerid}/review_images/{$product_id}/{$customer_id}/";

        // Create directory if not exists
        if (!is_dir($target_directory)) {
            if (!mkdir($target_directory, 0777, true)) {
                return ['success' => false, 'error' => 'Failed to create upload directory'];
            }
        }

        $allowed_file_types = ['jpg', 'jpeg', 'png', 'gif'];
        $max_size = 2 * 1024 * 1024; // 2MB

        foreach ($images['tmp_name'] as $key => $tmp_name) {

            if ($images['error'][$key] !== UPLOAD_ERR_OK) {
                continue;
            }

            $original_name = $images['name'][$key];
            $file_size = $images['size'][$key];
            $extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));

            // Validate extension
            if (!in_array($extension, $allowed_file_types)) {
                continue;
            }

            // Validate size
            if ($file_size > $max_size) {
                continue;
            }

            // Generate safe unique filename
            $unique_name = uniqid('img_', true) . "." . $extension;
            $target_file = $target_directory . $unique_name;

            if (move_uploaded_file($tmp_name, $target_file)) {
                $uploadedFiles[] = $unique_name;
            }
        }

        if (empty($uploadedFiles)) {
            return ['success' => false, 'error' => 'No images uploaded'];
        }

        return [
            'success' => true,
            'files' => $uploadedFiles
        ];
    }

    function getReviewImages(){
        $query = "SELECT *
                  FROM
                  " . $this->table_name . "
                  WHERE
                   customer_id = :customer_id";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":customer_id", $this->customer_id);

        $stmt->execute();
        
        return $stmt;
    }






}

?>