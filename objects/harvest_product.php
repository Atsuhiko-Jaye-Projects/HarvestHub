<?php

class HarvestProduct{

    private $conn;
    private $table_name = "harvested_products";

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
    public $is_posted;
    public $modified;


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
                is_posted = :is_posted,
                created_at=:created_at";

        $stmt=$this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        $this->product_name = htmlspecialchars(strip_tags($this->product_name));
        $this->unit = htmlspecialchars(strip_tags($this->unit));
        $this->price_per_unit = htmlspecialchars(strip_tags($this->price_per_unit));
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->total_stocks = htmlspecialchars(strip_tags($this->total_stocks));
        $this->lot_size = htmlspecialchars(strip_tags($this->lot_size));
        $this->product_description = htmlspecialchars(strip_tags($this->product_description));
        $this->product_image = htmlspecialchars(strip_tags($this->product_image));
        $this->is_posted = htmlspecialchars(strip_tags($this->is_posted));
        $this->created_at = date ("Y-m-d H:i:s");


        $stmt->bindParam(":user_id", $this->user_id);

        $stmt->bindParam(":product_name", $this->product_name);
        $stmt->bindParam(":unit", $this->unit);
        $stmt->bindParam(":price_per_unit", $this->price_per_unit);
        $stmt->bindParam(":category", $this->category);
        $stmt->bindParam(":total_stocks", $this->total_stocks);
        $stmt->bindParam(":lot_size", $this->lot_size);
        $stmt->bindParam(":product_description", $this->product_description);
        $stmt->bindParam(":product_image", $this->product_image);
        $stmt->bindParam(":is_posted", $this->is_posted);
        $stmt->bindParam(":created_at", $this->created_at);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function uploadPhoto() {
        $result_message = "";

        $check = getimagesize($_FILES["product_image"]["tmp_name"]);
        if($check!==false){
            // submitted file is an image
        }else{
            $file_upload_error_messages.="<div>Submitted file is not an image.</div>";
        }

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

    function readAllProduct($from_record_num, $records_per_page) {
        $query = "SELECT * FROM " . $this->table_name . "
                  WHERE user_id = :user_id
                  ORDER BY id DESC
                  LIMIT :from_record_num, :records_per_page";

        $stmt = $this->conn->prepare($query);

        // IMPORTANT: Use bindValue() instead of bindParam() for LIMIT (avoids reference issues)
        $stmt->bindValue(":user_id", $this->user_id, PDO::PARAM_INT);
        $stmt->bindValue(":from_record_num", (int)$from_record_num, PDO::PARAM_INT);
        $stmt->bindValue(":records_per_page", (int)$records_per_page, PDO::PARAM_INT);

        $stmt->execute();

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Count total rows for pagination
        $count_query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . " WHERE user_id = :user_id";
        $count_stmt = $this->conn->prepare($count_query);
        $count_stmt->bindValue(":user_id", $this->user_id, PDO::PARAM_INT);
        $count_stmt->execute();

        $count_row = $count_stmt->fetch(PDO::FETCH_ASSOC);
        $total_rows = $count_row['total_rows'];

        return [
            "records" => $products,
            "total_rows" => $total_rows
        ];
    }



    function updateHarvestProduct(){

        $query = "UPDATE
                " . $this->table_name . "
                SET
                product_name=:product_name,
                unit=:unit,
                price_per_unit=:price_per_unit,
                category=:category,
                lot_size=:lot_size,
                product_description=:product_description,
                modified=:modified
                WHERE
                    id=:id";

        $stmt=$this->conn->prepare($query);

        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->product_name = htmlspecialchars(strip_tags($this->product_name));
        $this->price_per_unit = htmlspecialchars(strip_tags($this->price_per_unit));
        $this->unit = htmlspecialchars(strip_tags($this->unit));
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->lot_size = htmlspecialchars(strip_tags($this->lot_size));
        $this->product_description = htmlspecialchars(strip_tags($this->product_description));
        $this->modified_at = date ("Y-m-d H:i:s");


        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":product_name", $this->product_name);
        $stmt->bindParam(":price_per_unit", $this->price_per_unit);
        $stmt->bindParam(":category", $this->category);
        $stmt->bindParam(":lot_size", $this->lot_size);
        $stmt->bindParam(":unit", $this->unit);
        $stmt->bindParam(":product_description", $this->product_description);
        $stmt->bindParam(":modified", $this->modified);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function search($search_term, $from_record_num, $records_per_page) {
        // select query with alias used
        $query = "SELECT
                    p.*
                FROM
                    " . $this->table_name . " p
                WHERE
                    p.product_name LIKE ?
                LIMIT ?, ?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind variables
        $search_term = "%{$search_term}%";
        $stmt->bindParam(1, $search_term, PDO::PARAM_STR);
        $stmt->bindParam(2, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(3, $records_per_page, PDO::PARAM_INT);

        // execute query
        $stmt->execute();

        return $stmt;
    }


    public function countAll_BySearch($search_term) {
        // select query
        $query = "SELECT
                    COUNT(*) as total_rows
                FROM
                    " . $this->table_name . " p
                WHERE
                    p.product_name LIKE ?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind variable values
        $search_term = "%{$search_term}%";
        $stmt->bindParam(1, $search_term, PDO::PARAM_STR);

        // execute and fetch
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }

    function postedProduct(){

        $query = "UPDATE
                " . $this->table_name . "
                SET
                is_posted=:is_posted,
                modified=:modified
                WHERE
                    id=:id";

        $stmt=$this->conn->prepare($query);

        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->is_posted=htmlspecialchars(strip_tags($this->is_posted));
        $this->modified_at = date ("Y-m-d H:i:s");


        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":is_posted", $this->is_posted);
        $stmt->bindParam(":modified", $this->modified);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }







}


?>
