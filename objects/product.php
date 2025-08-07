<?php

class Product{

    private $conn;
    private $table_name = "products";

    public $id;
    public $product_name;
    public $price_per_unit;
    public $category;
    public $user_id;
    public $total_stocks;
    public $lot_size;
    public $product_description;
    public $product_image;
    public $unit;
    public $created_at;


    public function __construct($db) {
	    $this->conn = $db;
	}

    function createProduct(){

        $query = "INSERT INTO 
                " . $this->table_name . "
                SET
                user_id=:user_id,
                product_name=:product_name,
                unit=:unit,
                price_per_unit=:price_per_unit,
                category=:category,
                total_stocks=:total_stocks,
                lot_size=:lot_size,
                product_description=:product_description,
                product_image=:product_image,
                created_at=:created_at";
        
        $stmt=$this->conn->prepare($query);

        $this->product_name = htmlspecialchars(strip_tags($this->product_name));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->price_per_unit = htmlspecialchars(strip_tags($this->price_per_unit));
        $this->unit = htmlspecialchars(strip_tags($this->unit));
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->total_stocks = htmlspecialchars(strip_tags($this->total_stocks));
        $this->lot_size = htmlspecialchars(strip_tags($this->lot_size));
        $this->product_description = htmlspecialchars(strip_tags($this->product_description));
        $this->product_image = htmlspecialchars(strip_tags($this->product_image));

        $this->created_at = date ("Y-m-d H:i:s");

        $stmt->bindParam(":product_name", $this->product_name);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":price_per_unit", $this->price_per_unit);
        $stmt->bindParam(":category", $this->category);
        $stmt->bindParam(":total_stocks", $this->total_stocks);
        $stmt->bindParam(":lot_size", $this->lot_size);
        $stmt->bindParam(":unit", $this->unit);
        $stmt->bindParam(":product_description", $this->product_description);
        $stmt->bindParam(":product_image", $this->product_image);
        $stmt->bindParam(":created_at", $this->created_at);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

function uploadPhoto() {
    $result_message = "";

    if ($this->product_image) {
        $user_id = $this->user_id; // Assuming this is set from the session or earlier
        $target_directory = "../../uploads/{$user_id}/products/";
        $file_name = basename($this->product_image);
        $target_file = $target_directory . $file_name;
        $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

        $file_upload_error_messages = "";

        // Validate image file
        $check = getimagesize($_FILES["product_image"]["tmp_name"]);
        if ($check === false) {
            $file_upload_error_messages .= "<div>Submitted file is not an image.</div>";
        }

        // Allowed file types
        $allowed_file_types = array("jpg", "jpeg", "png", "gif");
        if (!in_array(strtolower($file_type), $allowed_file_types)) {
            $file_upload_error_messages .= "<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
        }

        // File exists check
        if (file_exists($target_file)) {
            $file_upload_error_messages .= "<div>Image already exists. Try to change file name.</div>";
        }

        // File size check (max 1MB)
        if ($_FILES['product_image']['size'] > 1024000) {
            $file_upload_error_messages .= "<div>Image must be less than 1 MB in size.</div>";
        }

        // Ensure the upload folder exists
        if (!is_dir($target_directory)) {
            mkdir($target_directory, 0777, true);
        }

        // If no errors, attempt to move file
        if (empty($file_upload_error_messages)) {
            if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            } else {
                $result_message = "<div>Unable to upload image.</div>";
            }
        } else {
            $result_message = "<div class='alert alert-danger'>{$file_upload_error_messages}</div>";
        }
    }

    return $result_message;
}




}


?>