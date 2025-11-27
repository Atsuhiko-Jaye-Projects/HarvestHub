<?php

class Product{

    private $conn;
    private $table_name = "products";

    public $id;
    public $product_name;
    public $product_id;
    public $price_per_unit;
    public $category;
    public $user_id;
    public $total_stocks;
    public $lot_size;
    public $product_description;
    public $product_image;
    public $unit;
    public $status;
    public $created_at;
    public $available_stocks;
    public $sold_count;
    public $modified;
    public $product_type;


    public function __construct($db){
        $this->conn = $db;
    }


    function postProduct(){

        $query = "INSERT INTO
                " . $this->table_name . "
                SET
                product_name=:product_name,
                product_id=:product_id,
                user_id=:user_id,
                unit=:unit,
                price_per_unit=:price_per_unit,
                category=:category,
                lot_size=:lot_size,
                total_stocks=:total_stocks,
                product_image = :product_image,
                available_stocks=:available_stocks,
                product_description=:product_description,
                status=:status,
                product_type=:product_type,
                created_at=:created_at";
        
        $stmt=$this->conn->prepare($query);

        $this->product_id=htmlspecialchars(strip_tags($this->product_id));
        $this->product_name = htmlspecialchars(strip_tags($this->product_name));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->price_per_unit = htmlspecialchars(strip_tags($this->price_per_unit));
        $this->unit = htmlspecialchars(strip_tags($this->unit));
        $this->total_stocks = htmlspecialchars(strip_tags($this->total_stocks));
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->lot_size = htmlspecialchars(strip_tags($this->lot_size));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->available_stocks = htmlspecialchars(strip_tags($this->available_stocks));
        $this->product_image = htmlspecialchars(strip_tags($this->product_image));
        $this->product_type = htmlspecialchars(strip_tags($this->product_type));
        $this->created_at = date ("Y-m-d H:i:s");

        
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":product_name", $this->product_name);
        $stmt->bindParam(":price_per_unit", $this->price_per_unit);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":category", $this->category);
        $stmt->bindParam(":lot_size", $this->lot_size);
        $stmt->bindParam(":available_stocks", $this->available_stocks);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":product_image", $this->product_image);
        $stmt->bindParam(":unit", $this->unit);
        $stmt->bindParam(":total_stocks", $this->total_stocks);
        $stmt->bindParam(":product_type", $this->product_type);
        $stmt->bindParam(":product_description", $this->product_description);
        $stmt->bindParam(":created_at", $this->created_at);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function postCrop(){

        $query = "INSERT INTO
                " . $this->table_name . "
                SET
                product_id=:product_id,
                product_name=:product_name,
                user_id=:user_id,
                price_per_unit=:price_per_unit,
                category=:category,
                total_stocks=:total_stocks,
                available_stocks=:available_stocks,
                product_description=:product_description,
                product_image = :product_image,
                status=:status,
                product_type=:product_type,
                created_at=:created_at";
        
        $stmt=$this->conn->prepare($query);

        $this->product_id=htmlspecialchars(strip_tags($this->product_id));
        $this->product_name = htmlspecialchars(strip_tags($this->product_name));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->price_per_unit = htmlspecialchars(strip_tags($this->price_per_unit));
        $this->total_stocks = htmlspecialchars(strip_tags($this->total_stocks));
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->product_image = htmlspecialchars(strip_tags($this->product_image));
        $this->product_type = htmlspecialchars(strip_tags($this->product_type));
        $this->available_stocks = htmlspecialchars(strip_tags($this->available_stocks));
        $this->created_at = date ("Y-m-d H:i:s");

        
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":product_name", $this->product_name);
        $stmt->bindParam(":price_per_unit", $this->price_per_unit);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":category", $this->category);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":product_image", $this->product_image);
        $stmt->bindParam(":total_stocks", $this->total_stocks);
        $stmt->bindParam(":product_type", $this->product_type);
        $stmt->bindParam(":available_stocks", $this->available_stocks);
        $stmt->bindParam(":product_description", $this->product_description);
        $stmt->bindParam(":created_at", $this->created_at);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function readAllProduct($from_record_num, $records_per_page) {
        $query = "SELECT * FROM " . $this->table_name . "
                WHERE 
                
                user_id = :user_id && status = 'Active'
                LIMIT 
                {$from_record_num}, {$records_per_page}";

        $stmt = $this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        $stmt->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt;
    }

    

    public function countAll(){

        $query = "SELECT id FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        $num = $stmt->rowCount();

        return $num;
    }
    
    function deleteProduct(){

        $query = "DELETE FROM " . $this->table_name . " 
                    WHERE id = :id";

        $stmt = $this->conn->prepare($query);


        $this->status=htmlspecialchars(strip_tags($this->status));

        $stmt->bindParam(":id", $this->id);

        if($result = $stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    function showAllProduct($from_record_num, $records_per_page){
        $query = "SELECT * FROM " . $this->table_name . "
                WHERE 
                status = 'Active' 
                LIMIT
                {$from_record_num}, {$records_per_page}";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE product_id = ? LIMIT 0, 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->product_name = $row['product_name'];
            $this->user_id = $row['user_id'];
            $this->price_per_unit = $row['price_per_unit'];
            $this->unit = $row['unit'];
            $this->category = $row['category'];
            $this->lot_size = $row['lot_size'];
            $this->product_description = $row['product_description'];
            $this->total_stocks = $row['total_stocks'];
            $this->product_image = $row['product_image'];
            $this->sold_count = $row['sold_count'];
            return true;
        }

        return false;
    }


    function readProductName(){
        
        $query = "SELECT * FROM 
                    ". $this->table_name . "
                    WHERE 
                    product_id=:product_id";
        
        $stmt = $this->conn->prepare($query);

        $this->product_id = htmlspecialchars(strip_tags($this->product_id));
        
        $stmt->bindParam(":product_id", $this->product_id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->product_name = $row['product_name'];
            $this->product_image = $row['product_image'];
            $this->user_id = $row['user_id'];
            $this->price_per_unit = $row['price_per_unit'];
            $this->product_image = $row['product_image'];
            $this->user_id = $row['user_id'];
        }else{
            return null;
        }
    }

    function getProductInfo(){
        $query = "SELECT 
                price_per_unit,
                product_image,
                product_name,
                product_type,
                category,
                user_id
            FROM 
                " . $this->table_name . "
            WHERE
                product_id = :product_id
            LIMIT 
                0,1";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->price_per_unit = $row['price_per_unit'];
        $this->product_image = $row['product_image'];
        $this->product_name = $row['product_name'];
        $this->category = $row['category'];
        $this->product_type = $row['product_type'];
        $this->user_id = $row['user_id'];
    }

    function activeProductCount(){
        $query = "SELECT COUNT(*) as total
                  FROM 
                    " . $this->table_name . "
                  WHERE user_id = :user_id AND status = 'Active'";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $total = $row['total'];
    }

    function countProductSold(){
        $query = "SELECT SUM(sold_count) as product_sold_count
                  FROM 
                    " . $this->table_name . "
                  WHERE user_id = :user_id AND status = 'Active'";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $total = $row['product_sold_count'];
    }

    function productValue(){

        $query = "SELECT 
                  SUM(price_per_unit * total_stocks) as total_value
                  FROM
                  " . $this->table_name . "
                  WHERE 
                    user_id = :user_id";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total_value'];
    }



    function uploadPhoto() {
        $result_message = "";

        // Make sure a file was uploaded
        if (!empty($_FILES["crop_image"]["name"])) {

            // Generate a unique filename using sha1
            $image_name = sha1_file($_FILES['crop_image']['tmp_name']) . "-" . basename($_FILES['crop_image']['name']);
            $this->product_image = $image_name;

            $user_id = $this->user_id; // Assuming this is set
            $target_directory = "../../uploads/{$user_id}/posted_crops/";
            $target_file = $target_directory . $image_name;
            $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $file_upload_error_messages = "";

            // Check if the uploaded file is an image
            $check = getimagesize($_FILES["crop_image"]["tmp_name"]);
            if ($check === false) {
                $file_upload_error_messages .= "<div>Submitted file is not an image.</div>";
            }

            // Allowed file types
            $allowed_file_types = array("jpg", "jpeg", "png", "gif");
            if (!in_array($file_type, $allowed_file_types)) {
                $file_upload_error_messages .= "<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                $file_upload_error_messages .= "<div>Image already exists. Try to change file name.</div>";
            }

            // Check file size (max 1 MB)
            if ($_FILES['crop_image']['size'] > 1024000) {
                $file_upload_error_messages .= "<div>Image must be less than 1 MB in size.</div>";
            }

            // Ensure the upload folder exists
            if (!is_dir($target_directory)) {
                mkdir($target_directory, 0777, true);
            }

            // If no errors, move the uploaded file
            if (empty($file_upload_error_messages)) {
                if (move_uploaded_file($_FILES["crop_image"]["tmp_name"], $target_file)) {
                    $result_message = "<div class='alert alert-success'>Image uploaded successfully.</div>";
                } else {
                    $result_message = "<div class='alert alert-danger'>Unable to upload image.</div>";
                }
            } else {
                $result_message = "<div class='alert alert-danger'>{$file_upload_error_messages}</div>";
            }

        } else {
            $result_message = "<div class='alert alert-warning'>No file selected for upload.</div>";
        }

        return $result_message;
    }

    function getProductStock(){
        $query = "SELECT * 
                    FROM
                        " . $this->table_name . "
                    WHERE
                        user_id = :user_id";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":user_id", $this->user_id);

        $stmt->execute();

        $product_stock = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return [
            "records" => $product_stock
        ];
    }

    function getProductStockCount(){
        $query = "SELECT product_name, available_stocks, total_stocks
                    FROM
                        " . $this->table_name . "
                    WHERE
                        user_id = :user_id AND available_stocks < 100";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":user_id", $this->user_id);

        $stmt->execute();

        $product_status = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return [
            "records" => $product_status
        ];
    }

    function deductStock(){
        $query = "UPDATE " . $this->table_name . "
                SET 
                    available_stocks = available_stocks - :quantity,
                    sold_count = sold_count + :quantity
                WHERE 
                    product_id = :product_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":quantity", $this->sold_count);
        $stmt->bindParam(":product_id", $this->product_id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}


?>