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
    public $sold_count;
    public $modified;


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
                product_image = :product_image,
                product_description=:product_description,
                status=:status,
                created_at=:created_at";
        
        $stmt=$this->conn->prepare($query);

        $this->product_id=htmlspecialchars(strip_tags($this->product_id));
        $this->product_name = htmlspecialchars(strip_tags($this->product_name));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->price_per_unit = htmlspecialchars(strip_tags($this->price_per_unit));
        $this->unit = htmlspecialchars(strip_tags($this->unit));
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->lot_size = htmlspecialchars(strip_tags($this->lot_size));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->product_image = htmlspecialchars(strip_tags($this->product_image));
        $this->created_at = date ("Y-m-d H:i:s");

        
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":product_name", $this->product_name);
        $stmt->bindParam(":price_per_unit", $this->price_per_unit);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":category", $this->category);
        $stmt->bindParam(":lot_size", $this->lot_size);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":product_image", $this->product_image);
        $stmt->bindParam(":unit", $this->unit);
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
        }else{
            return null;
        }
    }

    function getProductInfo(){
        $query = "SELECT 
                price_per_unit,
                product_image,
                product_name,
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
        $this->user_id = $row['user_id'];

    }





}


?>